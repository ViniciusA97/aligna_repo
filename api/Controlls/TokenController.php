<?php

namespace Api\Controlls;

use Illuminate\Http\Request;
use \Validator;
use Laravel\Passport\Client;
use GuzzleHttp\Client as http;
use App\User;
use App\Http\Controllers\Controller;

class TokenController extends Controller
{
    public function login(Request $request) {
        $validate = Validator::make($request->all(), ['email'=>'required' ,'password'=>'required']);
        if($validate->fails()){ return response()->json(['error'=>'Email e senha são obrigatórios']);}
        try{
            $user = User::where('active',1)->where('email',$request->email)->first();
            $result = password_verify($request->password,$user->password);
            if($result){
                $token = $user->createToken('Token')->accessToken;
                return response()->json(['token'=>$token, 'user'=>$user]);
            }else{
                return response()->json(['error'=>'Credenciais erradas.']);
            }
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'friendlyMessage'=>'Usuário não encontrado'],404);
        }
        // $client_data = Client::where('password_client',1)->where('revoked','!=',1)->first();
        // $data = [
        //       'grant_type'=>'password',
        //     'client_id' =>$client_data->id,
        //     'client_secret'=>$client_data->secret,
        //     'username'=>$request->email,
        //     'password'=>$request->password
        // ];
        // $request = app('request')->create('/oauth/token', 'POST', $data);
        // $response = app('router')->prepareResponse($request, app()->handle($request));
        // $response = \json_decode($response->content(),true);
        // return response()->json(['response'=>$response]);
    }


    public function signup(Request $request){

    }

    public function validateToken(Request $request){
    
        $user = $request->user();
        //Fazer uma comparação de IP.
        if(!is_null($user)){
            return response()->json(['success'=>true, 'user'=>$user],200);
        }
        return response()->json(['error'=>'invalid token'],400);

    }

}
