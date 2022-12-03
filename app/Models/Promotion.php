<?php

namespace TypiCMS\Modules\Promotions\Models;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Members\Models\Member;
use TypiCMS\Modules\Shopproducts\Models\Shopproduct;

class Promotion extends Model
{
    protected $primaryKey = 'promotion_id';
    protected $guarded = [];

    public function list()
    {
        return self::published()
        ->where('type',">",1)
        ->where('type',"<",4)
        ->where('start_date','<=',now())
        ->where('end_date','>=',now())
        ->orderBy('position','ASC')->get();
    }

    /**
     * 計算促銷
     */
    public function calcPromotion($product_list, $payment, $delivery)
    {
        if($this->checkNotExcludePaymentAndDelivery($payment, $delivery)){//檢查是否有被排除
            if($this->checkRole()){
                switch($this->type){
                    case 1:
                        return $this->calcPromotion1($product_list);
                        break;
                    case 2:
                        return $this->calcPromotion2($product_list);
                        break;
                    case 3:
                        return $this->calcPromotion3($product_list);
                        break;
                    case 4:
                        return $this->calcPromotion4($product_list);
                        break;
                }
            }
        }
        return [
            'type'=>0,
            'product_list' => $product_list
        ];
    }

    /**
     * 確認身份是否合法
     */
    public function checkRole()
    {
        $target = json_decode($this->target);
        if($target->type == 'all_customer'){
            return true;
        }elseif($target->type == 'only_member'){
            if(Member::check()){
                return true;
            }
        }
        return false;
    }

    /**
     * 是否沒有被排除付款與運送方式
     */
    public function checkNotExcludePaymentAndDelivery($payment, $delivery)
    {
        //抓出該促銷排除的付款與運送方式
        $exclude_payments = json_decode($this->exclude_payments);
        $exclude_deliverys = json_decode($this->exclude_deliverys);

        if(!$payment){
            return false;
        }

        if(!$delivery){
            return false;
        }

        foreach($exclude_payments as $exclude_payment_item){
            try{
                if($exclude_payment_item->id == $payment->id){
                    return false;
                }
            }catch(\ErrorException $ex){

            }
        }

        foreach($exclude_deliverys as $exclude_delivery_item){
            try{
                if($exclude_delivery_item->id == $delivery->id){
                    return false;
                }
            }catch(\ErrorException $ex){

            }
        }


        return true;
    }

    /**
     * 該商品是否沒有被其他促銷排除
     */
    public function checkNotExclude($product)
    {
        $exclude_promotions = json_decode($this->exclude_promotions);

        foreach( $product['promotion'] as $product_promotion){
            try{
                if(in_array($product_promotion['id'],$exclude_promotions)){
                    return false;
                }
            }catch(\ErrorException $ex){

            }
        }

        return true;
    }

    //免運費(建議該促銷方在最後面)
    public function calcPromotion1($product_list)
    {
        $sum = 0;//差額
        $subtotal = 0;
        $is_free = false;
        //獲取免運條件
        $condition = json_decode($this->condition);
        $is_free = true;

        if($condition->type == "none"){//無條件免運
            $is_free = true;
        }elseif($condition->type == "full"){//有條件免運
            foreach($product_list as $product_item){
                if($this->checkNotExclude($product_item)){//看看有沒有排斥的運費計算

                    $price = $product_item['price'][count($product_item['price'])-1];//找出最後一個價格

                    $subtotal += $price * $product_item['amount'];
                }
            }

            if($subtotal >= $condition->limit){
                $is_free = true;
             }else{
                $sum = $condition->limit - $subtotal;
             }
        }
        return [
            'type' => 1,//免運
            'promotion' => $this,
            'sum' => $sum,
            'is_free' => $is_free,
        ];
    }

    //紅配綠
    public function calcPromotion2($product_list)
    {
        $setting = json_decode($this->setting);
        $include_product_list = $setting->product_list;
        $new_product_list = self::splitProductList($product_list);


        $discount_type = $setting->discount->type;
        $fixed_price = $setting->discount->price;

        //拆掉原本的產品
        $other_product_list= [];
        $green_list = [];
        $red_list = [];

        /**
         * 將產品放入對應的顏色內
         */
        foreach($new_product_list as $product_item){
            $color = null;
            foreach($include_product_list as $include_product_item){
                if($product_item['spec'] == $include_product_item->spec->name //檢查規格是否一樣
                &&
                $product_item['id'] == $include_product_item->product->id //檢查商品是否一樣
                &&
                $this->checkNotExclude($product_item) //檢查有沒有與其他促銷有衝突
                ){
                    if($color == null){
                        $color = $include_product_item->color;
                    }else{
                        if($color == "red" && $include_product_item->color == "green"){
                            $color = "mix";
                        }elseif($color == "green" && $include_product_item->color == "red"){
                            $color = "mix";
                        }
                    }
                }
            }
            if($color == "red"){
                array_push($red_list,$product_item);
            }else if($color == "green"){
                array_push($green_list,$product_item);
            }else{
                array_push($other_product_list,$product_item);
            }

        }
        //分出紅、綠、混三種分類(須以價格排序)

        $other_product_list= self::sortPrice($other_product_list);
        $green_list = self::sortPrice($green_list);//排序
        $red_list = self::sortPrice($red_list);//排序
        //看看紅色與綠色哪個分類比較多，多的那組為基準，分別套入優惠
        $base_count = min(count($green_list),count($red_list));


        for($index = 0; $index < $base_count ; $index++){

            //檢查看看是不是都有數值
            if(count($green_list) - $index > 0 && count($red_list) - $index >0){

                $green_price = $green_list[$index]['price'][count( $green_list[$index]['price'])-1];
                $red_price = $red_list[$index]['price'][count( $red_list[$index]['price'])-1];
                //比較價格大小
                if($green_price > $red_price){

                    //根據規則增加促銷與金額
                    array_push($red_list[$index]['promotion'],$this);
                    if($discount_type == 'fixed'){
                        array_push($red_list[$index]['price'],0);//插入促銷價格
                    }else{
                        $p = $red_list[$index]['price'][count($red_list[$index]['price'])-1];
                        array_push($red_list[$index]['price'],$p/2);//插入促銷價格
                    }


                    array_push($green_list[$index]['promotion'],$this);

                    if($discount_type == 'fixed'){
                        array_push($green_list[$index]['price'],$fixed_price);//插入促銷價格
                    }else{

                    }

                }else{
                    //根據規則增加促銷與金額
                    array_push($green_list[$index]['promotion'],$this);
                    if($discount_type == 'fixed'){
                        array_push($green_list[$index]['price'],0);//插入促銷價格
                    }else{
                        $p = $red_list[$index]['price'][count($green_list[$index]['price'])-1];
                        array_push($green_list[$index]['price'],$p/2);//插入促銷價格
                    }

                    array_push($red_list[$index]['promotion'],$this);

                    if($discount_type == 'fixed'){
                        array_push($red_list[$index]['price'],$fixed_price);//插入促銷價格
                    }else{

                    }


                }

            }
        }


        $other_product_list = array_merge($other_product_list,$green_list,$red_list);

        $product_list =  self::mergeProductList($other_product_list);
        $product_list =  self::sortPrice($other_product_list);

        return [
            'type' => 2,//紅配綠優惠
            'product_list' => $product_list
        ];
    }

    /**
     * 拆分所有商品
     */
    public static function splitProductList($product_list)
    {
        $new_product_list = [];
        foreach($product_list as $product_item){
            for($n=1;$n<=$product_item['amount'];$n++){
                $new_product_item = $product_item;
                $new_product_item['amount'] = 1;
                array_push($new_product_list,$new_product_item);
            }
        }
        return $new_product_list;
    }

    public static function isSamePrice($price1,$price2)
    {
        foreach($price1 as $key => $price_item){
            try{
                if($price_item != $price2[$key]){
                    return false;
                }
            }catch(\ErrorException $ex){
                return false;
            }
        }

        return true;
    }

    /**
     * 合併一樣的商品
     */
    public static function mergeProductList($new_product_list)
    {
        $product_list = [];
        foreach($new_product_list as $new_product_key => $new_product_item){
            $same = null;
            $smae_key = null;
            foreach($product_list as $product_key => $product_item){
                if($product_item['id'] == $new_product_item['id']
                && $product_item['spec'] == $new_product_item['spec']
                && self::isSamePrice($product_item['promotion'], $new_product_item['promotion'])
                && json_encode($product_item['price']) == json_encode($new_product_item['price'])){

                    $same = $product_item;
                    $smae_key = $product_key;
                    break;
                }
            }

            if($same && $smae_key >=0){

                $product_list[$smae_key]['amount'] = $product_list[$smae_key]['amount'] + $new_product_item['amount'];
            }else{
                array_push($product_list, $new_product_item);
            }
        }


        return $product_list;
    }

    /**
     * 按照價格排序
     */
    public static function sortPrice($product_list)
    {
        for($i = 0; $i < count($product_list)-1; $i++){
            for($j = 0; $j < count($product_list)-$i-1; $j++){
                $price1 = $product_list[$j]['price'][count( $product_list[$j]['price'])-1];
                $price2 = $product_list[$j+1]['price'][count( $product_list[$j+1]['price'])-1];
                if($price1 > $price2){
                    $temp = $product_list[$j];
                    $product_list[$j] = $product_list[$j+1];
                    $product_list[$j+1] = $temp;
                }

            }
        }
        return $product_list;
    }



    //第2件半價
    public function calcPromotion3($product_list)
    {
        $new_product_list = self::splitProductList($product_list);
        $new_product_list = self::sortPrice($new_product_list);
        $setting = json_decode($this->setting);
        $include_product_list = $setting->product_list;
        $amount = 0;

        //先找出有幾組促銷
        foreach($new_product_list as $product_item){

            foreach($include_product_list as $include_product_item){
                if($product_item['spec'] == $include_product_item->spec->name //檢查規格是否一樣
                &&
                $product_item['id'] == $include_product_item->product->id //檢查商品是否一樣
                &&
                $this->checkNotExclude($product_item) //檢查有沒有與其他促銷有衝突
                ){
                    $amount += $product_item['amount'];
                    break;
                }
            }
        }
        //插入促銷標籤
        $ok_amount = 0;
        foreach($new_product_list as $new_product_key =>$product_item){

            foreach($include_product_list as $include_product_item){
                if($product_item['spec'] == $include_product_item->spec->name //檢查規格是否一樣
                &&
                $product_item['id'] == $include_product_item->product->id //檢查商品是否一樣
                &&
                $this->checkNotExclude($product_item) //檢查有沒有與其他促銷有衝突
                ){
                    if( floor($amount/2)*2 > $ok_amount){//查看有沒有超過促銷總額
                        if($ok_amount < floor($amount/2)){//前n/2打五折
                            array_push($new_product_list[$new_product_key]['promotion'],$this);
                            $price = $new_product_list[$new_product_key]['price'][count( $new_product_list[$new_product_key]['price'])-1];
                            array_push($new_product_list[$new_product_key]['price'],$price/2);//插入促銷價格
                            $ok_amount++;
                            break;
                        }else{//後n/2不打折，但是要給促銷
                            array_push($new_product_list[$new_product_key]['promotion'],$this);
                            $ok_amount++;
                            break;
                        }
                    }else{
                        $ok_amount++;
                        break;
                    }
                }
            }
        }

        //插入促銷標籤
        return [
            'type' => 3,//滿N件特惠價
            'product_list' => self::mergeProductList($new_product_list)
        ];
    }

    //滿N件特惠價
    public function calcPromotion4($product_list)
    {
        $amount = 0;//所有價格總覽
        $setting = json_decode($this->setting);
        $include_product_list = $setting->product_list;
        $range = $setting->range;
        //先找出有幾組促銷
        foreach($product_list as $product_item){

            foreach($include_product_list as $include_product_item){
                if($product_item['spec'] == $include_product_item->spec->name //檢查規格是否一樣
                &&
                $product_item['id'] == $include_product_item->product->id //檢查商品是否一樣
                &&
                $this->checkNotExclude($product_item) //檢查有沒有與其他促銷有衝突
                ){
                    $amount += $product_item['amount'];
                    break;
                }
            }
        }

        //查看數量大小是否包含
        if($range->min <= $amount && $amount <= $range->max){
            //插入促銷標籤與價格

            foreach($product_list as $key=>$product_item){

                foreach($include_product_list as $include_product_item){
                    if($product_item['spec'] == $include_product_item->spec->name
                    &&
                    $product_item['id'] == $include_product_item->product->id
                    &&
                    $this->checkNotExclude($product_item)){
                        array_push($product_list[$key]['promotion'],$this);
                        array_push($product_list[$key]['price'],$include_product_item->promotion_price);//插入促銷價格

                    }
                }
            }

        }

        return [
            'type' => 4,//滿N件特惠價
            'product_list' =>  self::mergeProductList($product_list)
        ];
    }


    public static function getProductSpecPromotion($product_id,$spec_name)
    {
        $list = [];

        $promotion_list = self::published()
                            ->where('type', 4)
                            ->where('start_date','<=',now())
                            ->where('end_date','>=',now())
                            ->orderBy('position','ASC')
                            ->get();

        foreach($promotion_list as $promotion) {
            $setting = json_decode($promotion->setting);
            $product_list = $setting->product_list;
            foreach($product_list as $product) {

                if($product->product->id == $product_id) {
                    if($product->spec->name == $spec_name) {
                        $product_model = Shopproduct::published()->where('id', $product_id)->first();

                        if($product_model) {
                            $product_promotion = [
                                'proudct_id'=> $product->product->id,
                                'spec_name'=> $product->spec->name,
                                'original_price'=>   $product_model->getSpecOrignalPrice($spec_name),
                                'promotion_price'=> $product->promotion_price,
                                'price'=> $product->spec->price,
                                'max'=> $setting->range->max,
                                'min'=> $setting->range->min,
                                'promotion_id'=> $promotion->id
                            ];
                            array_push($list, $product_promotion);
                        }

                    }
                }

            }
        }


        return $list;
    }
}
