<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    //
    private $success = false;
    private $data = null;
    private $error = null;

    public function getListProduct()
    {
        //$user = Auth::user();
        $this->data = Product::getListProduct();
        $this->success = true;
        return $this->doResponse($this->success, $this->data, $this->error);
    }

    public function getProductById($id)
    {
        return $this->doResponse($this->success, 'id: ' . $id, $this->error);
    }

    // Add product
    public function addProduct(Request $request)
    {
        $user = Auth::user();
        //dd($user->id);
        try {
            $validator = Validator::make($request->all(), [
                'product_name' => 'required'
            ]);
            if ($validator->fails()) {
                $this->error = $validator->errors()->first();
            } else {
                $product = new Product();
                $product->product_name = $request->product_name;
                $product->user_id = $user->id;
                $result = Product::addProduct($product);
                if ($result) {
                    $this->success = true;
                    $this->data = $request->product_name;
                } else {
                    $this->success = false;
                }
            }
        } catch (QueryException $ex) {
            \Log::error("[" . __METHOD__ . "][" . __LINE__ . "]" . "error" . $ex->getMessage());
            $this->error = config('message.error.database');
        } catch (Exception $ex) {
            \Log::error("[" . __METHOD__ . "][" . __LINE__ . "]" . "error" . $ex->getMessage());
            $this->error = config('message.error.internal');
        }
        return $this->doResponse($this->success, $this->data, $this->error);
    }
    // detail
    public function detailProduct($id)
    {
        try {
            $pr = Product::where('id', $id)->first();
            if (Auth::user()->can('update', $pr)) {
                $this->data = $pr;
                $this->success = true;
            }else {
                $this->error = "Ban khong co quyen sua";
            }
        } catch (QueryException $ex) {
            \Log::error("[" . __METHOD__ . "][" . __LINE__ . "]" . "error" . $ex->getMessage());
            $this->error = config('message.error.database');
        } catch (Exception $ex) {
            \Log::error("[" . __METHOD__ . "][" . __LINE__ . "]" . "error" . $ex->getMessage());
            $this->error = config('message.error.internal');
        }
        return $this->doResponse($this->success, $this->data, $this->error);
    }

    // update
    public function updateProduct(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_name' => 'required'
            ]);
            if ($validator->fails()) {
                $this->error = $validator->errors()->first();
            } else {
                $pr = Product::where('id', $id)->first();
                if (Auth::user()->can('update', $pr)) {
                    $product = new Product();
                    $product->id = $id;
                    $product->product_name = $request->product_name;
                    $result = Product::updateProduct($product);
                    if ($result) {
                        $this->success = true;
                        $this->data = $product;
                    } else {
                        $this->success = false;
                    }
                }
            }
        } catch (QueryException $ex) {
            \Log::error("[" . __METHOD__ . "][" . __LINE__ . "]" . "error" . $ex->getMessage());
            $this->error = config('message.error.database');
        } catch (Exception $ex) {
            \Log::error("[" . __METHOD__ . "][" . __LINE__ . "]" . "error" . $ex->getMessage());
            $this->error = config('message.error.internal');
        }
        return $this->doResponse($this->success, $this->data, $this->error);
    }
}
