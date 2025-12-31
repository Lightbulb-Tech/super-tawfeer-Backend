<?php

namespace App\Traits;

trait ImageTrait
{
    public function uploadImage($image, $folder)
    {
        if (isset($image)) {
            $imageName = uniqid() . $image->getClientOriginalName();
            $imagePath = $image->move($folder, $imageName);
            return $imagePath;
        }
    }

    public function getImage($image)
    {
        return '<img src="' . asset('') . $image . '" width="50px" height="50px">';
    }


}
