<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

use App\Models\User as U;

class AuthController extends Controller
{
    #region Login
    public function loginView(){
        return View('auth.login');
    }

    private $loginRules = [
        "email" => "required|email",
        "password" => "required"
    ];
    private $loginMsg = [
        "email.required" => "Email is required",
        "email.email" => "Email field must be a email",
        "password.required" => "Password is required"
    ];

    public function login(Request $r){
        $valid = Validator::make($r->all(),$this->loginRules,$this->loginMsg);

        if($valid->fails()){
            return ($r->wantsJson()) ?
            response()->json(["message"=>"Bad request","errors"=>"$valid->errors()"],400) :
            redirect()->back()->withErrors($valid->errors());
        }
        else{
            try{
                if($q = U::Where('email',$r->email)->first()){
                    if(Hash::check($r->password,$q->password)){
                        if($q->status == 1){
                            $credentials = ["email"=>$r->email,"password"=>$r->password];
                            $remember = $r->has('rememberme');

                            if($r->wantsJson()){
                                return (! $token = JWTAuth::attempt($credentials)) ? response()->json(["error"=>"Unauthorized"],419) : response()->json(["token"=>$token,"user"=>$q],200);
                            }
                            else{
                                if(Auth::attempt($credentials,$remember)){
                                    return redirect('/home');
                                }
                                else{
                                    throw new Exception("Internal server error",500);
                                }
                            }
                        }
                        else{
                            throw new Exception("User status inactive",403);
                        }
                    }
                    else {
                        throw new Exception("Incorrect password",400);
                    }
                }
                else{
                    throw new Exception("Email not found",400);
                }
            }
            catch(Exception $e){
                return ($r->wantsJson()) ?
                response()->json(["message"=>"Bad request","errors"=>$e->getMessage()],$e->getCode()) :
                redirect()->back()->withErrors($e->getMessage());
            }
        }
    }

    public function logout(Request $r){
        try{
            if($r->wantsJson()){
                JWTAuth::invalidate($r->token);
                return response()->json("loggedout",200);
            }
            else{
                Auth::logout();
                $r->session()->invalidate();
                $r->session()->regenerateToken();
                $r->session()->flush();
                return redirect("/login");
            }
        }
        catch(Exception $e){
            return ($r->wantsJson()) ?
            response()->json(["errors"=>$e],$e->getMessage()) :
            redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function JWTMe(Request $r){
        $u = JWTAuth::authenticate($r->token);
        return response()->json([$u],200);
    }

    public function JWTRefresh(Request $r){
        $credentials = $r->only(['email','password']);
        $q=U::Where('email',$r->email)->first();
        return (! $token = JWTAuth::attempt($credentials)) ? response()->json(["error"=>"Unauthorized"],419) : response()->json(["token"=>$token,"user"=>$q],200);
    }
    #endregion Login
}
