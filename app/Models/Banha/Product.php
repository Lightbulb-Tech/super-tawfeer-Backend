<?php

namespace App\Models\Banha;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['price', 'image', 'amount', 'max_quantity_for_order', 'ordered_count', 'sold_count', 'reserved_amount', 'points', 'our_products', 'main_category_id', 'sub_category_id', 'store_id', 'brand_id', 'is_active', 'made_in_egypt'];

    public function translation(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ProductTranslation::class)->where('locale', app()->getLocale());
    }

    public function mainCategory()
    {
        return $this->belongsTo(Category::class, 'main_category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }


    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function offer()
    {
        return $this->hasOne(Offer::class, 'product_id')
            ->whereDate('from_date', '<=', now())
            ->whereDate('to_date', '>=', now());
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }

    public function favourite()
    {
        return $this->hasOne(Favourite::class, 'product_id')->where('user_id', Auth::guard('api')->id());
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

}
