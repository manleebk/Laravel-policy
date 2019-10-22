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

    public function addProduct(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_name' => 'required'
            ]);
            if ($validator->fails()) {
                $this->error = $validator->errors()->first();
            } else {
                $product = new Product();
                $product->product_name = $request->product_name;
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

    public function updateProduct(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|numeric',
                'product_name' => 'required'
            ]);
            if ($validator->fails()) {
                $this->error = $validator->errors()->first();
            } else {
                $product = new Product();
                $product->id = $request->id;
                $product->product_name = $request->product_name;
                $result = Product::updateProduct($product);
                if ($result) {
                    $this->success = true;
                    $this->data = $product;
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
}
