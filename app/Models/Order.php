<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $presenter = ModulePresenter::class;

    public $appends = ['order_state', 'payment_state'];

    public function payment_states()
    {
        return $this->hasMany(PaymentState::class,'order_id','id')->orderBy('created_at','DESC');
    }

    public function order_states()
    {
        return $this->hasMany(OrderState::class,'order_id','id')->orderBy('created_at','DESC');
    }

    public function delivery_states()
    {
        return $this->hasMany(DeliveryState::class,'order_id','id')->orderBy('created_at','DESC');
    }


    public function orderItem(){
        return $this->hasMany(OrderItem::class,'order_id','id');
    }
    public function getThumbAttribute(): string
    {
        return $this->present()->image(null, 54);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    public function product(){
        return $this->belongsToMany(Shopproduct::class, 'order_items')->withPivot('price','amount');
    }

    public function getSubtotalAttribute(){
        /*
         * 商品小記
         */
        return $this->amount;
    }
    public function getDeliveryPrice(){
        /*
         * 計算運費
         */
        return $this->delivery_shipping;
    }

    public function member()
    {
        return $this->belongsTo(Member::class,'member_id','id');
    }

    public function getOrderStateAttribute()
    {
        $state = OrderState::where('order_id',$this->id)->orderBy('created_at','DESC')->first();
        if($state){
            return $state->getText();
        }
        return '';
    }

    public function getPaymentStateAttribute()
    {
        $state = PaymentState::where('order_id',$this->id)->orderBy('created_at','DESC')->first();
        if($state){
            return $state->getText();
        }
        return '';
    }


    //給予宅配方式名稱
    public function getDeliveryMethodName()
    {
        $delivery = json_decode($this->delivery);

        return $delivery->title->cht ?? '';
    }

   //給予宅配方式關聯物件
    public function getDeliveryMethod()
    {
        return $this->belongsTo(Shopdelivery::class,'delivery_method_id');
    }


    //給予寄件人關聯物件
    public function getOrderAddress()
    {
        return $this->belongsTo(Address::class,'order_address_id');
    }


    //給予寄件人關聯物件
    public function getOrderAddressAttribute()
    {
        return $this->getOrderAddress;
    }



    //給予收件人關聯物件
    public function getRecipientAddress()
    {
        return $this->belongsTo(Address::class,'recipient_address_id');
    }


    //給予付款方式關聯物件
    public function getPaymentTitle()
    {
        $payment = json_decode($this->payment);

        return $payment->title->cht ?? '';
    }

    //給予付款方式關聯物件
    public function getPaymentMemo()
    {
        $payment = json_decode($this->payment);

        return $payment->description->cht ?? '';
    }


    //給予發票種類名稱
    public function getInvoiceName()
    {
        $invoice = json_decode($this->invoice);
        if($invoice->type==2){
            return '二聯式發票';
        }elseif($invoice->type==3){
            return "三聯式發票";
        }else{
            return "未選定";
        }
    }

    //判斷是否為三聯式發票
    public function isBussinessInvoice()
    {
        $invoice = json_decode($this->invoice);
        if($invoice->type==3){
            return true;
        }else{
            return false;
        }
    }


    //判斷是否為三聯式發票
    public function getBussinessInvoiceNumber()
    {
        $invoice = json_decode($this->invoice);
        return $invoice->title;
    }

    public function getBussinessInvoiceTitle()
    {
        $invoice = json_decode($this->invoice);
        return $invoice->title;
    }

    //產生下一個訂單id
    public static function generateNextOrderId()
    {
        $oldOrder=Order::withTrashed()->orderBy('serial_number','DESC')->first();
        $oldOrderId=$oldOrder->serial_number ?? null;
        $serial='0000';
        if($oldOrderId!=null || $oldOrderId !=0){
            $old_Date=substr($oldOrderId, 0, 8);
            $old_Serial=substr($oldOrderId, 8, 4);
            if($old_Date==date("Ymd")){
                $str=intval($old_Serial)+1;
                $serial=str_pad($str,4,'0',STR_PAD_LEFT);
            }else{
                $serial='0001';
            }
        }else{
            $serial='0001';
        }
        return date("Ymd").$serial;
    }

}
