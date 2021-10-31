<?php

namespace App\Services;

use App\Models\Shop;
use App\Models\Common;
use App\Models\Product;

class ShopService
{
    protected $common;
    public function __construct()
    {
        $this->common = new Common();
    }

    public function DeleteShop($id)
    {
        $data = Shop::where('id', $id)->first();
        if ($data) {
            $folder = 'images';
            $fileName = $data->image;
            $this->common->delete_image($fileName, $folder);
            $delete = Shop::where('id', $id)->delete();
            return true;
        } else {
            return false;
        }
    }


    public function DeleteProduct($id)
    {
        $data = Product::where('id', $id)->first();
        if ($data) {
            $folder = 'images';
            $fileName = $data->video;
            $this->common->delete_image($fileName, $folder);
            $delete = Product::where('id', $id)->delete();
            return true;
        } else {
            return false;
        }
    }
}
