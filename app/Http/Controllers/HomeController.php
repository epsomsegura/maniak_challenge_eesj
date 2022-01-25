<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book as B;
use App\Models\Category as C;
use App\Models\User as U;

class HomeController extends Controller
{
    #region Home
    public function homeView(Request $r){
        $data['books'] = B::count();
        $data['categories'] = C::count();
        $data['readers'] = U::Where('profile_id',2)->count();

        return ($r->wantsJson()) ?
        response()->json($data,200) :
        View('home.home',$data);
    }
    #endregion Home
}
