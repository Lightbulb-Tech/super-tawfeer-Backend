<?php

namespace App\Services\TamoTech;

use App\Models\TamoTech\Settings;
use App\Services\MainService;
use App\Traits\ImageTrait;

class SettingsService extends MainService
{
    use ImageTrait;

    public function __construct(Settings $model)
    {
        $this->model = $model;
        $this->fileFolder = 'settingsImages/';
        $this->columsFile = ['icon', 'image_login'];
    }
    public function updateSettings($id, $data)
    {
        if (isset($data['icon'])) {
            $data['icon'] = $this->uploadImage($data['icon'], $this->fileFolder);
        }
        if (isset($data['image_login'])) {
            $data['image_login'] = $this->uploadImage($data['image_login'], $this->fileFolder);
        }
        return $this->find($id)->update($data);

    }


}
