<?php

namespace App\Repositories\Banha;

use App\Models\Banha\StoreFeature;
use App\Repositories\MainRepository;

class StoreFeatureRepository extends MainRepository
{
    public function __construct(StoreFeature $model)
    {
        $this->model = $model;
        $this->columsFile = ['icon'];
        $this->fileFolder = 'store_features_images';
    }

    public function storeFeatures($data, $store_id)
    {
        foreach ($data as $item) {
            $item['store_id'] = $store_id;
            if (!isset($item['icon']) || empty($item['icon'])) {
                continue;
            }
            $this->storeWithFilesWithOneLanguage($item);
        }
        return true;
    }


    public function updateFeatures($data, $store_id)
    {
        foreach ($data as $item) {
            if (!isset($item['id'])) {
                continue;
            }
            if (isset($item['icon']) && is_string($item['icon'])) {
                unset($item['icon']);
            }
            $item['store_id'] = $store_id;
            $this->updateWithFiles($item['id'], $item);
        }
        return true;
    }

    public function deleteFeatures($featuresIds)
    {
        foreach ($featuresIds as $featuresId) {
            $this->deleteWithFiles($featuresId);
        }
        return true;
    }


}
