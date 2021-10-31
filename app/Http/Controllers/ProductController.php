<?php

namespace App\Http\Controllers;

use App\Helpers\Import;
use App\Models\Shop;
use App\Models\Common;
use App\Models\Product;
use DataTables;
use Illuminate\Http\Request;
use App\Services\ShopService;

class ProductController extends Controller
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


    public function ProductList($id)
    {
        return view('product.product')->with(['id' => $id]);
    }
    public function ProductListDataTable($id)
    {



        $productData = Product::where('shop_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        $arrItem = [];
        foreach ($productData as $itm) {
            $varItem = [
                'id'           => $itm->id,
                'shop_id'         => $itm->shop_id,
                'product_name' => $itm->product_name,
                'price'        => $itm->price,
                'stock'        => $itm->stock,
                'video'        => $itm->video_url,
                'created_at'        => $this->common->adminDateFormat($itm->created_at),
                'updated_at'        => $this->common->adminDateFormat($itm->updated_at),
            ];

            array_push($arrItem, $varItem);
        }

        return Datatables::of($arrItem)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $url    = url('product/edit-product') . '/' . $row['shop_id'] . '/' . $row['id'];
                $action1 = '<center>
                    <a href="' . $url . '" title="Edit">
                        <i class="fa fa-pencil"></i>
                    </a>

                    &nbsp

                    <a href="javascript:void(0)" onclick="DeleteProduct(' . $row['shop_id'] . ',' . $row['id'] . ')" data-toggle="tooltip" title="Delete">
                        <i class="fa fa-trash"></i>
                    </a>
                </center>';

                return $action1;
            })
            ->rawColumns(['action'])
            ->make(true);
    }









    public function EditProduct($id, $productId)
    {

        $productData = Product::where('id', $productId)->first();
        return view('product.edit-product')->with([
            'ProductData' => $productData,
            'id' => $id,
        ]);
    }

    public function AddProduct($id)
    {

        return view('product.add-product')->with([
            'id' => $id,
        ]);
    }


    public function BulkProduct($id)
    {

        return view('product.bulk-product')->with([
            'id' => $id,
        ]);
    }



    public function InsertBulkProduct(Request $request)
    {
        $id = $request->get('id');


        $file = $request->file('bulk');

        $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

        $import = Import::readFile($file->path(), function ($row) use ($id) {

            return $this->importRow($row, $id);
        });

        return redirect('product/product/' . $id);
    }

    public  function importRow($data, $id)
    {

        try {
            $check = Product::where('product_name', $data['product_name'])->where('shop_id', $id)->first();

            if (!$check) {
                $data =  Product::create([
                    'product_name' => $data['product_name'],
                    'price' => $data['price'],
                    'stock' => $data['stock'],
                    'shop_id' => $id,
                    'video' => $data['video'],
                ]);
            }

            $error = Import::STATUS_OK;
        } catch (\Exception $e) {
            $error = Import::STATUS_ERROR;
            $message = $e->getMessage();
            $data['error'] = "Error:- $message!";
        }

        return [$error,  $data];
    }

    public function CheckProduct(Request $request)
    {
        $Name = $request->product_name;

        $id = $request->id;

        $Data =  Product::where('product_name', $Name)->where('shop_id', $id)->first();
        if ($Data) {
            echo true;
        } else {
            echo false;
        }
    }


    public function UpdateCheckProduct(Request $request)
    {
        $Name = $request->product_name;
        $productid = $request->productid;
        $id = $request->id;
        $Data =  Product::where('product_name', $Name)->where('shop_id', $id)->where('id', '!=', $productid)
            ->first();

        if ($Data) {
            echo true;
        } else {
            echo false;
        }
    }
    public function InsertProduct(Request $request)
    {
        $id = $request->get('id');

        $folder = 'images';
        $productVideo = $request->file('video');
        $file_name = $this->common->upload_image($productVideo, $folder);
        $product_name = $request->get('product_name');
        $price = $request->get('price');
        $stock = $request->get('stock');
        $data =  Product::create([
            'product_name' => $product_name,
            'price' => $price,
            'stock' => $stock,
            'shop_id' => $id,
            'video' => $file_name,
        ]);

        return redirect('product/product/' . $id);
    }
    public function UpdateProduct(Request $request)
    {

        $id = $request->get('id');

        $folder = 'images';

        $product_name = $request->get('product_name');
        $price = $request->get('price');
        $stock = $request->get('stock');
        $productId = $request->get('productId');
        $data = Product::where('id', $productId)->first();

        if ($request->has('video')) {
            $productVideo = $request->file('video');
            $fileName = $data->video;
            $this->common->delete_image($fileName, $folder);
            $file_name = $this->common->upload_image($productVideo, $folder);
        } else {
            $file_name = $data->video;
        }



        $update =  Product::where('id', $productId)->update([
            'product_name' => $product_name,
            'price' => $price,
            'stock' => $stock,
            'shop_id' => $id,
            'video' => $file_name,
        ]);

        return redirect('product/product/' . $id);
    }
    public function DeleteProduct(Request $request)
    {
        $id = $request->get('id');
        $folder = 'images';
        $productId = $request->get('ProductId');

        if ($productId) {
            $this->ShopService->DeleteProduct($productId);
        }
        return redirect('product/product/' . $id);
    }
}
