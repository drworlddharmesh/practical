<?php

namespace App\Models;



use File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

use Storage;

class Common extends Model
{
    public function adminDateFormat($date)
    {
        return Carbon::parse($date)->format('d-m-y');
    }


    public function upload_image($file, $folder)
    {

        $temp = time() . $file->getClientOriginalName();
        $name = str_replace(' ', '_', $temp);
        $filePath = $folder . '/' . $name;
        Storage::disk('public')->put($filePath, file_get_contents($file), 'public');
        return $name;
    }

    public function delete_image($fileName, $folder)
    {
        $image_path = 'storage/' . $folder . '/' . $fileName;
        if (File::exists($image_path)) {
            File::delete($image_path);
            return true;
        }
        return false;
    }
}
