<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //
    private $success = false;
    private $data = null;
    private $error = null;

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                $this->error = $validator->errors()->first();
            } else {
                if (Auth::guard('web')->once(['username' => $request->username, 'password' => $request->password])) {
                    $info = array();
                    $api_token = Str::random(60);
                    $us = Auth::guard("web")->user();
                    $us->api_token = $api_token;
                    $us->save();
                    $info = $us;
                    $this->success = true;
                    $this->data = $info;
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


    public function signup(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required'
            ]);
            if ($validator && !(User::isExist($request->username))) {
                $user = new User();
                $user->username = $request->username;
                $user->password = Hash::make($request->password);
                //var_dump($user);
                $result = $user->save();
                if ($result) {
                    $this->data = $user;
                    $this->success = true;
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
