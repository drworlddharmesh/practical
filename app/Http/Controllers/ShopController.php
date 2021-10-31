<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\Common;
use DataTables;
use Illuminate\Http\Request;
use App\Services\ShopService;

class ShopController extends Controller
{
    protected $common;
    protected $CurrentDate;
    protected $ShopService;
    public function __construct(Request $request, ShopService $ShopService)
    {
        $this->common = new Common;
        $this->ShopService = $ShopService;
        date_default_timezone_set('Asia/Kolkata');
        $this->CurrentDate = date("Y-m-d H:i:s");
    }
    public function ShopList(Request $request)
    {
        return view('shop.shop');
    }
    public function ShopListDataTable(Request $request)
    {
        $ShopData = Shop::orderBy('id', 'desc')->get();

        $arrItem = [];
        foreach ($ShopData as $itm) {
            $varItem = [
                'id'           => $itm->id,
                'shop_name'         => $itm->shop_name,
                'image' => $itm->image_url,
                'address'        => $itm->address,
                'email'        => $itm->email,
                'created_at'        => $this->common->adminDateFormat($itm->created_at),
                'updated_at'        => $this->common->adminDateFormat($itm->updated_at),
            ];

            array_push($arrItem, $varItem);
        }

        return Datatables::of($arrItem)
            ->addIndexColumn()
            ->addColumn('Product', function ($row) {
                $url    = url('product/product') . '/' . $row['id'];
                $action = '<center>
                    <a href="' . $url . '" title="Edit" class="btn btn-sm btn-primary">
                        Product List
                    </a>

                    &nbsp

                </center>';

                return $action;
            })
            ->addColumn('action', function ($row) {
                $url    = url('shop/edit-shop') . '/' . $row['id'];
                $action1 = '<center>
                    <a href="' . $url . '" title="Edit">
                        <i class="fa fa-pencil"></i>
                    </a>

                    &nbsp

                    <a href="javascript:void(0)" onclick="DeleteShop(' . $row['id'] . ')" data-toggle="tooltip" title="Delete">
                        <i class="fa fa-trash"></i>
                    </a>
                </center>';

                return $action1;
            })
            ->rawColumns(['Product','action'])
            ->make(true);
    }




    public function EditShop($id)
    {

        $ShopData = Shop::where('id', $id)->first();
        return view('shop.edit-shop')->with([
            'ShopData' => $ShopData,
        ]);
    }

    public function AddShop()
    {

        return view('shop.add-shop');
    }

    public function InsertShop(Request $request)
    {

        $image = $request->file('image');
        $folder = 'images';
        $file_name = $this->common->upload_image($image, $folder);
        $shop_name = $request->get('shop_name');
        $address = $request->get('address');
        $email = $request->get('email');

        $data =  Shop::create([
            'image' => $file_name,
            'shop_name' => $shop_name,
            'address' => $address,
            'email' => $email,
        ]);
        return redirect('shop/shop');
    }
    public function UpdateShop(Request $request)
    {

        $folder = 'images';
        $shop_name = $request->get('shop_name');
        $address = $request->get('address');
        $email = $request->get('email');
        $id = $request->get('id');
        $data = Shop::where('id', $id)->first();
        if ($request->has('image')) {
            $image = $request->file('image');
            $folder = 'images';
            $fileName = $data->image;
            $this->common->delete_image($fileName, $folder);
            $file_name = $this->common->upload_image($image, $folder);
        } else {
            $file_name = $data->image;
        }
        $update =  Shop::where('id', $id)->update([
            'shop_name' => $shop_name,
            'address' => $address,
            'email' => $email,
            'image' => $file_name,
        ]);
        return redirect('shop/shop');
    }
    public function DeleteShop(Request $request)
    {

        $id = $request->get('id');
        $this->ShopService->DeleteShop($id);

        return redirect('shop/shop');
    }
}
