<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $primaryKey = 'payment_id';
    protected $guarded = [];

    public static function getTypeList()
    {
        if(env('ECPAY_ENABLE')){
            return [
                ''=>'無串接',
                'ecpay_credit'=>'信用卡(綠界)',
                'ecpay_atm'=>'ATM(綠界)',
                'ecpay_cvs'=>'超商代碼(綠界)',
            ];
        }else{
            return [
                ''=>'無串接'
            ];
        }
    }

    /**
     * 給予沒有被排除的付款方式
     */
    public static function getPaymentList($delivery)
    {
        $list = [];
        $payment_list = self::published()->orderBy('position','ASC')->get();
        //假如沒有選delivery的話
        if(!$delivery){
            return $payment_list;
        }
        foreach($payment_list as  $payment_item){
            if($payment_item->excluded_shipping){
                $excluded_shipping = json_decode($payment_item->excluded_shipping);
                if(!in_array($delivery->id, $excluded_shipping)){
                    array_push($list, $payment_item);
                }
            }else{
                array_push($list, $payment_item);
            }
        }

        return $list;
    }

    /**
     * 檢查
     */
    public static function hasPayment($list, $payment_id)
    {
        foreach($list as $item){
            if($item->id == $payment_id){
                return true;
            }
        }
        return false;
    }
}
