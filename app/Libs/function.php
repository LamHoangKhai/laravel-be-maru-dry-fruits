<?php

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

function RootCategory($categories, $selected, $parent = 0, $str = "")
{
    foreach ($categories as $key => $value) {
        if ($value->parent_id === $parent) {
            if ($selected == $value->id) {
                echo '<option value="' . $value->id . '"selected >' . $str . $value->name . '</option>';
            } else {
                echo '<option value="' . $value->id . '" >' . $str . $value->name . '</option>';
            }

            unset($categories[$key]);

            RootCategory($categories, $selected, $value->id, $str . "---|");
        }
    }
}

function UploadImageToCould($data, $folderName)
{

    $uploadedFileUrl = Cloudinary::upload($data, [
        "folder" => $folderName,
    ])->getSecurePath();
    return $uploadedFileUrl;
}

function DeleteImageOnCloud($folderNamer, $data)
{
    Cloudinary::destroy($folderNamer . $data);
    return 0;
}

