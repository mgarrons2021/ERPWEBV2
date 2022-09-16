<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginManualController extends Controller
{

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function authenticate(Request $request)
    {
        if ($request->ajax()) {
            $user = User::Where('codigo',$request->codigo)->get();            
            return response()->json(
                $user->toArray()
            );
        }
    }
}
