<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductIndex extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'product_index_id';
    protected $guarded = [];
}
