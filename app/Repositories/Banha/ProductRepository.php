<?php

namespace App\Repositories\Banha;

use App\Models\Banha\Product;
use App\Repositories\MainRepository;

class ProductRepository extends MainRepository
{
    public function __construct(Product $model, protected ProductImageRepository $productImageRepository, protected OfferRepository $offerRepository, protected ProductAttributeRepository $productAttributeRepository)
    {
        $this->model = $model;
        $this->columsFile = ['image'];
        $this->fileFolder = 'product_images';
    }

    public function getDataForDataTable()
    {
        return $this->model->query()->select('products.id', 'products.is_active', 'products.price','products.ordered_count','products.sold_count', 'products.points', 'products.amount', 'products.main_category_id', 'products.sub_category_id', 'products.image', 'product_translations.title')
            ->join('product_translations', function ($join) {
                $join->on('products.id', '=', 'product_translations.product_id')
                    ->where('product_translations.locale', app()->getLocale());
            })->latest('products.id');
    }

    public function getDataWithZeroQuantityForDataTable()
    {
        return $this->model->query()->select('products.id', 'products.is_active', 'products.price', 'products.ordered_count', 'products.sold_count', 'products.points', 'products.amount', 'products.main_category_id', 'products.sub_category_id', 'products.image', 'product_translations.title')
            ->join('product_translations', function ($join) {
                $join->on('products.id', '=', 'product_translations.product_id')
                    ->where('product_translations.locale', app()->getLocale());
            })->where('products.amount', '=', 0)
            ->latest('products.id');
    }

    public function getMostProductsSoldForDataTable()
    {
        return $this->model->query()->select('products.id', 'products.is_active', 'products.price', 'products.ordered_count', 'products.sold_count', 'products.points', 'products.amount', 'products.main_category_id', 'products.sub_category_id', 'products.image', 'product_translations.title')
            ->join('product_translations', function ($join) {
                $join->on('products.id', '=', 'product_translations.product_id')
                    ->where('product_translations.locale', app()->getLocale());
            })
            ->where('products.sold_count', '!=', 0)
            ->latest('products.sold_count');
    }

    public function getMostProductsOrderedForDataTable()
    {
        return $this->model->query()->select('products.id', 'products.is_active', 'products.price', 'products.ordered_count', 'products.sold_count', 'products.points', 'products.amount', 'products.main_category_id', 'products.sub_category_id', 'products.image', 'product_translations.title')
            ->join('product_translations', function ($join) {
                $join->on('products.id', '=', 'product_translations.product_id')
                    ->where('product_translations.locale', app()->getLocale());
            })
            ->where('products.ordered_count', '!=', 0)
            ->latest('products.ordered_count');
    }

    public function storeProduct($data)
    {
        $data['is_active'] = 1;
        $product = $this->storeWithFiles($data);
        if ($data['has_offer'] == 'yes') {
            $offerData['product_id'] = $product->id;
            $offerData['type'] = $data['type'];
            $offerData['value'] = $data['value'];
            $offerData['from_date'] = $data['from_date'];
            $offerData['to_date'] = $data['to_date'];
            $this->offerRepository->store($offerData);
        }
        if (isset($data['images']) && count(array_filter($data['images'])) > 0) {
            $this->productImageRepository->storeProductImages($product->id, $data['images']);
        }
        if (isset($data['productAttributes'])) {
            $filtered = array_filter($data['productAttributes'], function ($feature) {
                $ar = $feature['ar']['attribute_name'] ?? null;
                $en = $feature['en']['attribute_name'] ?? $feature['ar']['attribute_name'];
                $val = $feature['attribute_value'] ?? null;
                return !((is_null($ar) || $ar === '') && (is_null($en) || $en === '') && (is_null($val) || $val === ''));
            });
            if (!empty($filtered)) {
                foreach ($filtered as $productAttribute) {
                    $productAttribute['product_id'] = $product->id;
                    $this->productAttributeRepository->store($productAttribute);
                }
            }
        }
        return $product;
    }

    public function updateProduct($id, $data)
    {
        $product = $this->find($id);
        $this->updateWithFiles($id, $data);
        if ($data['has_offer'] == 'yes') {
            $offerData['product_id'] = $product->id;
            $offerData['type'] = $data['type'];
            $offerData['value'] = $data['value'];
            $offerData['from_date'] = $data['from_date'];
            $offerData['to_date'] = $data['to_date'];
            if (isset($product->offer)) {
                $offer = $product->offer;
                $offer->update($offerData);
            } else {
                $this->offerRepository->store($offerData);
            }
        } elseif ($data['has_offer'] == 'no') {
            if (isset($product->offer)) {
                $offer = $product->offer;
                $offer->delete();
            }
        }
        if (isset($data['images'])) {
            $images = array_filter($data['images']);
            if (!empty($images)) {
                $this->productImageRepository->storeProductImages($product->id, $images);
            }
        }
        if (isset($data['productAttributes'])) {
            $product->productAttributes()->delete();
            foreach ($data['productAttributes'] as $productAttribute) {
                $productAttribute['product_id'] = $product->id;
                $this->productAttributeRepository->store($productAttribute);
            }

        }
        return $product;
    }

    public function deleteProduct($product_id)
    {
        $images = $this->productImageRepository->getWhere(['product_id' => $product_id]);
        foreach ($images as $image) {
            $this->productImageRepository->deleteWithFiles($image->id);
        }
        return $this->deleteWithFiles($product_id);
    }

    public function getOffersProducts()
    {
        return $this->model->whereHas("offer")->where('is_active', 1);
    }

    public function searchProducts($title)
    {
        return $this->model->query()
            ->when($title, function ($query) use ($title) {
                $query->where(function ($q) use ($title) {
                    $q->whereHas('translations', function ($q1) use ($title) {
                        $q1->where('title', 'like', "%{$title}%")
                            ->where('locale', app()->getLocale());
                    })
                        ->orWhereHas('mainCategory.translations', function ($q1) use ($title) {
                            $q1->where('title', 'like', "%{$title}%")
                                ->where('locale', app()->getLocale());
                        })
                        ->orWhereHas('subCategory.translations', function ($q1) use ($title) {
                            $q1->where('title', 'like', "%{$title}%")
                                ->where('locale', app()->getLocale());
                        });
                });
            })
            ->latest();
    }





}
