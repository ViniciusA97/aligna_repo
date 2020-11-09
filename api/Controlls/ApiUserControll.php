<?php

namespace Api\Controlls;

use App\User;
use App\PasswordReset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Str;
use Api\Presenters\MailCreateUserPresenter;
use Api\Presenters\MailConfirmateMember;
use Api\Events\EventMail;

use \Validator;


class ApiUserControll extends Controller{

    public function createWithEmail(Request $request){
        $validate = Validator::make(
            $request->all(),
            [
                'name'=>'required' ,
                'email'=>'required',
                'id_cargo'=>'required',
                'id_setor'=>'required',
                'role'=>'required'
        ]);
        if($validate->fails()){ 
            return response()->json(['success'=>false,'error'=>'Campos requiridos faltando.'],401);
        }
        try{
            
            $user = User::create($request->all());
            
            $password_reset = PasswordReset::create([
                "email"=>$request->email,
                "token"=>Str::random(30)
            ]);

            
            $mail = new MailCreateUserPresenter($user->email, $password_reset->token, $user->name);
            $event = new EventMail($mail);
            $event->handleEvent();
            
            return response()->json([
                'success'=>true,
                'user'=>$user,
                'friendlyMessage'=>'Um email foi enviado ao membro.'
            ],201);

        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'friendlyMessage'=>'Não foi possível criar o usuário. Cheque as informações.',
                'error' => $e->getMessage()
            ],400);
        }

    }

    public function createWithOutEmail(Request $request){
        
        $validate = Validator::make(
            $request->all(),
            [
                'name'=>'required' ,
                'id_cargo'=>'required',
                'id_setor'=>'required',
                'role'=>'required'
        ]);
        
        if($validate->fails()){ 
            return response()->json(['success'=>false,'error'=>'Campos requiridos faltando.'],401);
        }

        try{
            
            $user = User::create($request->all());
            return response()->json([
                'success'=>true,
                'user'=>$user
            ],201);

        }catch(Exeption $e){
            
            return response()->json([
                'success'=>false,
                'friendlyMessage'=>'Não foi possível criar o Membro. Verifique os dados.',
                'error'=>$e->getMessage()
            ],400);
        
        }

    }

    public function confirmAccount(Request $request){
       
        $validate = Validator::make(
            $request->all(),
            [
                'name'=>'required' ,
                'password'=>'required',
                'token'=>'required'
        ]);
        
        if($validate->fails()){ 
            return response()->json(['success'=>false,'error'=>'Campos requiridos faltando.'],401);
        }

        $token = $request->token;
        $password_reset = PasswordReset::where('token',$token)->first();
        $user = User::where('email',$password_reset->email)->first();
        if(is_null($user->email_verified_at)){

            $to_update = [
                "password"=>password_hash($request->password, PASSWORD_BCRYPT),
                "name"=>$request->name,
                "email_verified_at"=>Carbon::now()
            ];

            $user->update($to_update);
            $password_reset->delete();
            
            $mail = new MailConfirmateMember($user->email, $user->name);
            $event = new EventMail($mail);
            $event->handleEvent();

            return response()->json([
                'success'=>true,
                'friendlyMessage'=>'Conta confirmada com sucesso'
            ],200);
        }else{
            return response()->json([
                'success'=>false,
                'error'=>'Email já verificado',
                'friendlyMessage'=>'Email já verificado'
            ]);
        }
    }

    public function update(Request $request){

    }

    public function getAll(Request $request){

    }

    public function getById($id){
        try{

            $user = User::find($id);
            
            if(is_null($user)){
                return response()->json([
                    'error'=>'Usuário não encontrado.',
                    'friendlyMessage'=>'Usuário não encontrado.'
                ],404);
            }
            
            $response = [
                'user'=>$user,
                'cargo'=>$user->cargo()->get(),
                'setor'=>$user->setor()->get()
            ];
            
            return response()->json([
                'data'=>$response,
            ], 200);
        
        }catch(Exception $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'friendlyMessage'=>'Usuário não encontrado.'
            ],404);
        }
    }

    public function delete($id){
        try{

            $user = User::find($id);
            
            if(is_null($user)){
                return response()->json([
                    'error'=>'Usuário não encontrado.',
                    'friendlyMessage'=>'Usuário não encontrado.'
                ],404);
            }
            $user->delete();
            
            return response()->json([
                'success'=>true,
            ], 200);
        
        }catch(Exception $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'friendlyMessage'=>'Usuário não encontrado.'
            ],404);
        }
    }
    
}
?>