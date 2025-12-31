<?php

namespace App\Imports;

use App\Models\Banha\Product;
use App\Models\Banha\ProductTranslation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow , ShouldQueue ,WithChunkReading
{
    private $rowCounter = 1;
    private $map = [
        'alasm' => 'title',
        'alosf' => 'description',
        'alsaar' => 'price',
        'alkmy' => 'amount',
        'aadd_alnkat' => 'points',
        'snaa_fy_msr' => 'made_in_egypt',
        'mn_mntgatna' => 'our_products',
    ];


    private $mainCategoryId;
    private $subCategoryId;
    private $brandId;

    public function __construct($mainCategoryId, $subCategoryId, $brandId)
    {
        $this->mainCategoryId = $mainCategoryId;
        $this->subCategoryId = $subCategoryId;
        $this->brandId = $brandId;
    }

    public function model(array $row)
    {
        $data = [];
        foreach ($this->map as $arabic => $english) {
            if (isset($row[$arabic])) {
                $data[$english] = $row[$arabic];
            }
        }
        $product = Product::create([
            'price' => $data['price'] ?? null,
            'amount' => $data['amount'] ?? null,
            'points' => $data['points'] ?? null,
            'made_in_egypt' => $data['made_in_egypt'] == 'نعم' ? 'yes' : 'no',
            'our_products' => $data['our_products'] == 'نعم' ? 'yes' : 'no',
            'main_category_id' => $this->mainCategoryId,
            'sub_category_id' => $this->subCategoryId,
            'brand_id' => $this->brandId,
            'is_active' => 1,
        ]);
        ProductTranslation::create([
            'product_id' => $product->id,
            'locale' => 'ar',
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
        ]);
        ProductTranslation::create([
            'product_id' => $product->id,
            'locale' => 'en',
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
        ]);
        $this->rowCounter++;
        return $product;
    }
    public function chunkSize(): int
    {
        return 50;
    }
}
