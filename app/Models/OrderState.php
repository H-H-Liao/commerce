<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Traits\HasFiles;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\Carts\Presenters\ModulePresenter;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderState extends Model
{
    protected $primaryKey = 'order_state_id';
    protected $guarded = [];

    public static $PROCESSING=1;//處理中
    public static $CONFIRMED=2;//已確認
    public static $COMPLETED=3;//已完成
    public static $CANCELLED=4;//已取消


    public function getText()
    {
        switch($this->status){
            case self::$PROCESSING:
                return '處理中';
                break;
            case self::$CONFIRMED:
                return '已確認';
                break;
            case self::$COMPLETED:
                return '已完成';
                break;
            case self::$CANCELLED:
                return '已取消';
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
