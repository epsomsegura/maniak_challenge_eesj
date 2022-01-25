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

use App\Models\Category as C;

class CategoryController extends Controller
{
    public function index(Request $r){
        $q = C::all();

        foreach($q as $k=>$v){$q[$k]['idC'] = Crypt::encryptString($q[$k]['id']);}
        $data['categories'] = $q;

        return ($r->wantsJson()) ?response()->json($data,200) :View('categories.index',$data);
    }

    private $rules = [
        "name" => "required",
        "description" => "required|max:255",
    ];
    private $msg = [
        "name.required" => "Name is required",
        "description.required" => "Description is required",
        "description.max" => "Description must be 255 characters maximum",
    ];
    public function save(Request $r){
        DB::Begintransaction();
        try{
            $this->rules['name'] = "required|unique:categories,name,".$r->name;
            $this->rules['name.unique'] = "Duplicated name, change this and try again";
            $valid = Validator::make($r->all(),$this->rules,$this->msg);

            if($valid->fails()){
                return ($r->wantsJson()) ? response()->json(["errors"=>$valid->errors()],400) : redirect()->back()->withErrors($valid->errors());
            }
            else{
                $arrData = $r->only(["name","description"]);
                $c = C::create($arrData);

                if($c->save()){
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
                if($c = C::find(Crypt::decryptString($r->id))){
                    $arrData = $r->only(["name","description"]);
                    $c->update($arrData);

                    if($c->save()){
                        DB::commit();
                        return ($r->wantsJson()) ? response()->json("Data updated successfully",200) : redirect()->back()->with("status","Data updated successfully");
                    }
                    else{
                        throw new Exception("Internal server error",500);
                    }
                }
                else{
                    throw new Exception("Category not found",400);
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
            if($c = C::find(Crypt::decryptString($r->id))){
                $c->delete();
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
}
