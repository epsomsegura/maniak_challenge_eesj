<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Exception;

use App\Models\Book as B;
use App\Models\User as U;
use App\Models\Library as L;

class LibraryController extends Controller
{
    //
    public function index(Request $r){
        $q = B::With(["bookLibrary"=>function($query){$query->with('libraryUser')->orderBy("borrow_date","DESC");}])->get();
        foreach($q as $k=>$v){
            $q[$k]['idC'] = Crypt::encryptString($q[$k]['id']);
            $q[$k]['publication_date'] = date('d/m/Y',strtotime($q[$k]['publication_date']));
        }
        $data['books'] = $q;
        $data['users'] = U::Where('profile_id',2)->get();

        return ($r->wantsJson()) ? response()->json($data,200) : View("library.index",$data);
    }

    private $rules = [
        "book_id" => "required",
        "user_id" => "required"
    ];
    private $msgs = [
        "book_id.required" => "Book is required",
        "user_id" => "Reader is required"
    ];
    public function borrow(Request $r){
        $valid = Validator::make($r->all(),$this->rules,$this->msgs);

        DB::beginTransaction();
        try{
            if($valid->fails()){
                return ($r->wantsJson()) ? response()->json(["errors"=>$valid->errors()],400) : redirect()->back()->withErrors($valid->errors());
            }
            else{
                if($b = B::find($r->book_id)){
                    if($u = U::find($r->user_id)){
                        $b->update(["user_id"=>$r->user_id]);
                        if($b->save()){
                            $l = L::create([
                                "book_id"=>$r->book_id,
                                "user_id" =>$r->user_id,
                                "borrow_date" => date("Y-m-d H:i:s"),
                                "return_date" => NULL
                            ]);
                            if($l->save()){
                                DB::commit();
                                return ($r->wantsJson()) ?
                                    response()->json("Data successfully saved") :
                                    redirect()->back()->with("status","Data successfully saved");
                            }
                            else{
                                throw new Exception("Internal server error",500);
                            }
                        }
                        else{
                            throw new Exception("Internal server error",500);
                        }
                    }
                    else{
                        throw new Exception("Reader not found",400);
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

    private $rulesR = [
        "library_id" => "required"
    ];
    private $msgsR = [
        "library_id.required" => "Data required"
    ];
    public function return(Request $r){
        $valid = Validator::make($r->all(),$this->rulesR,$this->msgsR);

        DB::beginTransaction();
        try{
            if($valid->fails()){
                return ($r->wantsJson()) ? response()->json(["errors"=>$valid->errors()],400) : redirect()->back()->withErrors($valid->errors());
            }
            else{
                if($l = L::find($r->library_id)){
                    if($b = B::find($l->book_id)){
                        $b->update(["user_id"=>NULL]);
                        if($b->save()){
                            $l->update(["return_date"=>date("Y-m-d H:i:s")]);
                            if($l->save()){
                                DB::commit();
                                return ($r->wantsJson()) ?
                                    response()->json("Data successfully updated",200) :
                                    redirect()->back()->with("status","Data successfuly updated");
                            }
                            else{
                                throw new Exception("Internal server error",500);
                            }
                        }
                        else{
                            throw new Exception("Internal server error",500);
                        }
                    }
                    else{
                        throw new Exception("Book not found",400);
                    }
                }
                else{
                    throw new Exception("Data not found",400);
                }
            }

        }catch(Exception $e){
            DB::rollback();
            return ($r->wantsJson()) ?
                response()->json(["errors" => $e->getMessage()], $e->getCode()) :
                redirect()->back()->withErrors($e->getMessage());
        }
    }
}
