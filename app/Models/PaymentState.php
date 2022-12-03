<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Files\Models\File;

class PaymentState extends Model
{
    protected $primaryKey = 'payment_state_id';
    protected $guarded = [];

    public static $UNPAID=1;//未付款
    public static $PAID=2;//已付款
    public static $REFUNDING=3;//退款中
    public static $REFUNDED=4;//已退款



    public function getText()
    {
        switch($this->status){
            case self::$UNPAID:
                return '未付款';
                break;
            case self::$PAID:
                return '已付款';
                break;
            case self::$REFUNDING:
                return '退款中';
                break;
            case self::$REFUNDED:
                return '已退款';
                break;
        }
        return '';
    }

    public function getOperatorText()
    {
        switch($this->operator){
            case "ROOT":
                return '管理者';
                break;
            case "SYSTEM":
                return '系統自訂';
                break;
            case "ECPAY":
                return '綠界科技';
                break;
        }
        return '';
    }


    public function getThumbAttribute(): string
    {
        return $this->present()->image(null, 54);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }
}
