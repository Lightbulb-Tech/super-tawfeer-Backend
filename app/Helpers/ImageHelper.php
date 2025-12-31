<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('upload_image')) {
    function upload_image($image, $folder_name)
    {
        if (isset($image)) {
            return $image->store($folder_name, 'public');
        }
    }
}
if (!function_exists('show_image')) {
    function show_image($image): string
    {
        if (Storage::exists('public/'.$image)) {
            $path_image = Storage::url('public/'.$image);
            return "
                <div style='width: 100px; height: 100px; overflow: hidden; border-radius: 50%;'>
                    <img src='" . $path_image . "'
                         style='width: 100%; height: 100%; object-fit: cover;'
                         class='img-fluid' />
                </div>";
                    } else {
                        return "
                <div style='width: 100px; height: 100px; overflow: hidden; border-radius: 50%;'>
                    <img src='" . asset('admin/images/default_image.png') . "'
                         style='width: 100%; height: 100%; object-fit: cover;'
                         class='img-fluid' />
                </div>";
        }
    }
}
if (!function_exists('show_file')) {
    function show_file($image): string
    {
        if ($image && Storage::exists('public/' . $image)) {
            return url('storage/' . $image);
        }
        return url('default/no_image.png');
    }
}

if (!function_exists('showFile')) {
    function showFile($fileFullPath)
    {
        if ($fileFullPath && file_exists(public_path('storage/' . $fileFullPath))) {
            return url('storage/' . $fileFullPath);
        }

        return url('default/no_image.png');
    }

}


if (!function_exists('delete_image')) {
    function delete_image($image): bool
    {
        if (Storage::exists('public/'.$image)) {
            $path = "public/" . $image;
            return Storage::delete($path);
        } else {
            return false;
        }
    }
}

if (!function_exists('download_image')) {
    function download_image($image): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        if (Storage::exists('public/'.$image)) {
            return Storage::download($image);

        } else {
            return false;
        }
    }
}
if (!function_exists('image_path')) {
    function image_path($image): bool|string
    {
        if (Storage::exists('public/' . $image)) {
            return "/storage/" . $image;
        } else {
            return false;
        }
    }
}
