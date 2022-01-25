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

use App\Models\Profile as P;
use App\Models\User as U;

class UserController extends Controller
{
    //
    public function index(Request $r){
        $data['profiles'] = P::all();
        $q = U::with(['userProfile','userLibrary'=>function($q){$q->with(['libraryBook'=>function($q2){$q2->with('bookCategory');}])->orderBy('borrow_date','DESC');}]);

        $userProfile = $r->wantsJson() ? JWTAuth::authenticate($r->token)->profile_id : Auth::user()->profile_id;

        switch(true){
            case ($userProfile == 1): $q = $q->get(); break;
            case ($userProfile == 2): $q = $q->where('profile_id','>',1)->get(); break;
        }
        foreach($q as $k=>$v){$q[$k]['idC'] = Crypt::encryptString($q[$k]['id']);}
        $data['users'] = $q;

        return ($r->wantsJson()) ?response()->json($data,200) :View('users.index',$data);
    }

    private $rules = [
        "profile_id" => "required",
        "name" => "required",
        "email" => "required|email",
        "chngPassword" => "sometimes",
        "password" => "required_with:chngPassword,1,min:8|same:repeat_password",
        "repeat_password" => "required_with:chngPassword,1,min:8",
    ];
    private $msg = [
        "profile_id.required" => "Profile type is required",
        "name.required" => "Name is required",
        "email.required" => "Email is required",
        "email.email" => "This is no a email",
        "password.required_with" => "Password is required",
        "password.min" => "The password must be at least 8 characters long",
        "password.same" => "Passwords are not equals",
        "repeat_password.required_with" => "Repeat password is required",
        "repeat_password.min" => "The repeat password must be at least 8 characters long",
    ];
    public function save(Request $r){
        DB::Begintransaction();
        try{
            $this->rules["email"] = "required|email|unique:users,email,".$r->email;
            $this->rules["email.unique"] = "Duplicated email, change this and try again";
            $valid = Validator::make($r->all(),$this->rules,$this->msg);

            if($valid->fails()){
                return ($r->wantsJson()) ? response()->json(["errors"=>$valid->errors()],400) : redirect()->back()->withErrors($valid->errors());
            }
            else{
                $arrData = $r->only(["profile_id","name","email","status"]);
                $arrData["password"] = Hash::make($r->password);
                $u = U::create($arrData);

                if($u->save()){
                    DB::commit();
                    return ($r->wantsJson()) ? response()->json("Data saved successfully",200) : redirect()->back()->with("status","Data saved successfully");
                }
                else{
                    throw new Exception("Internal server error",500);
                }
            }
        }
        catch(Exception $e){
            DB::rollback();
            return ($r->wantsJson()) ?
                response()->json(["errors" => $e->getMessage()], $e->getCode()) :
                redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function edit(Request $r){
        DB::Begintransaction();
        try{
            $valid = Validator::make($r->all(),$this->rules,$this->msg);

            if($valid->fails()){
                return ($r->wantsJson()) ? response()->json(["errors"=>$valid->errors()],400) : redirect()->back()->withErrors($valid->errors());
            }
            else{
                if($u = U::find(Crypt::decryptString($r->id))){
                    $arrData = $r->only(["profile_id","name","email","status"]);
                    if($r->has('chngPassword')) $arrData['password'] = Hash::make($r->password);
                    $u->update($arrData);

                    if($u->save()){
                        DB::commit();
                        return ($r->wantsJson()) ? response()->json("Data updated successfully",200) : redirect()->back()->with("status","Data updated successfully");
                    }
                    else{
                        throw new Exception("Internal server error",500);
                    }
                }
                else{
                    throw new Exception("User not found",400);
                }
            }
        }
        catch(Exception $e){
            DB::rollback();
            return ($r->wantsJson()) ?
                response()->json(["errors" => $e->getMessage()], $e->getCode()) :
                redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function delete(Request $r){
        DB::beginTransaction();
        try{
            if($u = U::find(Crypt::decryptString($r->id))){
                $u->delete();
                DB::commit();
                return response()->json("Data deleted successfully",200);
            }
            else{
                throw new Exception("Internal server error",500);
            }
        }
        catch(Exception $e){
            DB::rollback();
            return ($r->wantsJson()) ?
                response()->json(['errors'=>$e->getMessage()],$e->getCode()) :
                redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function status(Request $r)
    {
        DB::beginTransaction();
        try {
            if($u = U::find(Crypt::decryptString($r->id))){
                $u->status = $r->status;
                if ($u->save()) {
                    DB::commit();
                    return response()->json('Data ' . ($r->status == 1 ? 'activated' : 'deactivated') . ' successfully', 200);
                } else {
                    throw new Exception("Internal server error", 500);
                }
            }
            else{
                throw new Exception("User not found",400);
            }

        } catch (Exception $e) {
            DB::rollback();
            return response()->json($e->getMessage(), $e->getCode());
        }
    }
}
