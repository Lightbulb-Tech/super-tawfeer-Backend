<?php

namespace App\Models\Banha;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['title'];
    protected $fillable = ['main_category_id', 'image', 'store_id', 'is_active', 'our_products', 'made_in_egypt'];


    public function mainCategory()
    {
        return $this->belongsTo(Category::class, 'main_category_id');
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'main_category_id');
    }

    public function subProducts()
    {
        return $this->hasMany(Product::class, 'sub_category_id');
    }
    public function mainProducts()
    {
        return $this->hasMany(Product::class, 'main_category_id');
    }
}
