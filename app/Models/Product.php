<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'category_id',
        'type',
        'description',
        'price',
        'stock_quantity',
        'image',
        'is_mining_product',
        'mining_product_id'
    ];

   
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function miningProduct(): BelongsTo
    {
        return $this->belongsTo(MiningProduct::class);
    }
}
