<?php

namespace App\Models\Banha;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['attribute_name'];
    protected $fillable = ['product_id', 'attribute_value'];
    protected $translationForeignKey = 'product_attr_id';

}
