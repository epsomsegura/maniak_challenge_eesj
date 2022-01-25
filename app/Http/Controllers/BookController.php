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

use App\Models\Book as B;
use App\Models\Category as C;

class BookController extends Controller
{
    public function index(Request $r){
        $data['categories'] = C::OrderBy('name','ASC')->get();
        $q = B::with(['bookCategory','bookUser'])->get();

        foreach($q as $k=>$v){
            $q[$k]['idC'] = Crypt::encryptString($q[$k]['id']);
        }
        $data['books'] = $q;

        return ($r->wantsJson()) ?response()->json($data,200) :View('books.index',$data);
    }

    private $rules = [
        "name" => "required",
        "category_id" => "required",
        "publication_date" => "required|date",
    ];
    private $msg = [
        "name.required" => "Name is required",
        "category.required" => "Category is required",
        "publication_date.required" => "Publication date is required",
        "publication_date.date" => "This is no a date format",
    ];
    public function save(Request $r){
        DB::Begintransaction();
        try{
            $valid = Validator::make($r->all(),$this->rules,$this->msg);

            if($valid->fails()){
                return ($r->wantsJson()) ? response()->json(["errors"=>$valid->errors()],400) : redirect()->back()->withErrors($valid->errors());
            }
            else{
                $arrData = $r->only(["name","category_id","publication_date"]);
                $arrData["publication_date"] = date('Y-m-d',strtotime($arrData['publication_date']));
                $arrData["status"] = 0;
                $b = B::create($arrData);

                if($b->save()){
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
                if($b = B::find(Crypt::decryptString($r->id))){
                    $arrData = $r->only(["name","category_id","publication_date"]);
                    $arrData["publication_date"] = date('Y-m-d',strtotime($arrData['publication_date']));
                    $b->update($arrData);

                    if($b->save()){
                        DB::commit();
                        return ($r->wantsJson()) ? response()->json("Data updated successfully",200) : redirect()->back()->with("status","Data updated successfully");
                    }
                    else{
                        throw new Exception("Internal server error",500);
                    }
                }
                else{
                    throw new Exception("Book not found",400);
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
            if($b = B::find(Crypt::decryptString($r->id))){
                $b->delete();
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
