<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $response = false;
        if( isset($request->codigo) ){
              $response= true;
        }else{
            $response;
        }
        if($response == false){
            return response()->json(['error'=> $response]);
        }else{
            $credentials=request(['codigo']);
            if(!Auth::attempt($credentials)){
                return response()->json(['error'=>'datos invalidos']);
            }
            $user=User::where('codigo',$request->codigo)->first();
            $user_id =$user->id;
            $tokenResult=$user->createToken('authToken')->plainTextToken;        
            return response()->json([                
                'token'=>$tokenResult,
                'name' => Auth::user()->name,
                'codigo'=>Auth::user()->codigo,
                'sucursal' => Auth::user()->sucursals[0]->id,
                'sucursal_nombre' => Auth::user()->sucursals[0]->nombre,
                'codigo_fiscal' => Auth::user()->sucursals[0]->codigo_fiscal,
                'rol' => Auth::user()->roles[0]->id,
                'cargo' =>Auth::user()->cargosucursals[0]->nombre_cargo,
                'error'=>null,
                'user_id'=>$user->id,
                'verification'=>Auth::user()->email_verified_at
            ]);
        }
   }

   public function logout(Request $request)
   {
        $user = $request->codigo;
        $us= User::where('codigo',$user);
        $p= auth()->user();
       // dd( auth('api')->user() );
        if ( isset($us)  ) { 
            //$request->user()->currentAccessToken()->delete();
            return response()->json(['status_code'=>200,'message'=> $p ]);
        }else{
            return response()->json(['message' => 'Algo Salio Mal'], 400);
        }
   }

   public function login_nuevo(Request $request)
   {  
       $response = false;
       if( isset($request->codigo) ){
             $response= true;
       }else{
           $response;
       }
       if($response == false){
           return response()->json(['error'=> $response]);
       }else{
           $credentials=request(['codigo']);
            if(!Auth::attempt($credentials)){

                return response()->json(['error'=>'datos invalidos']);
            }
            $user=User::where('codigo',$request->codigo)->first();
            $tokenResult=$user->createToken('authToken')->plainTextToken;
            /* return response()->json(['token'=>$tokenResult,
                'name' => Auth::user()->name,
                'codigo'=>Auth::user()->codigo,
                'error'=>null,
                'id'=>$user->id,
                'verification'=>Auth::user()->email_verified_at]);
            } */  
            return redirect()->route('home') ;
       }
   }
}
