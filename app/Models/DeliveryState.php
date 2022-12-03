<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * 運送狀態
 */
class DeliveryState extends Model
{
    protected $primaryKey = 'delivery_state_id';
    protected $guarded = [];

    public static $STOCKING=1;//備貨中
    public static $SHIPPING=2;//發貨中
    public static $SHIPPED=3;//已發貨
    public static $ARRIVED=4;//已到達
    public static $PICKED_UP=5;//已取貨
    public static $RETURNED=6;//已退貨
    public static $RETURNING=7;//退貨中

    public function getText(){
        switch($this->status){
            case self::$STOCKING:
                return '備貨中';
                break;
            case self::$SHIPPING:
                return '發貨中';
                break;
            case self::$SHIPPED:
                return '已發貨';
                break;
            case self::$ARRIVED:
                return '已到達';
                break;
            case self::$PICKED_UP:
                return '已取貨';
                break;
            case self::$RETURNED:
                return '已退貨';
                break;
            case self::$RETURNING:
                return '退貨中';
                break;
        }
        return '';
    }

}
