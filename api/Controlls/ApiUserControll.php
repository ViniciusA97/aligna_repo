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
use Illuminate\Support\Facades\Storage;
use \Validator;
use Cookie;


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
            
            $data = $request->all();
            $data['send_last_invite'] = Carbon::now();
        
            $user = User::create($data);
            
            $password_reset = PasswordReset::create([
                "email"=>$request->email,
                "token"=>Str::random(30)
            ]);

            $url = $request->url();
            $urlFinal = str_replace('/api/member/accessible','',$url);
            
            $link = $urlFinal.'/'.$password_reset->token;

            $mail = new MailCreateUserPresenter($user->email, $link, $user->name);
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

    public function update(Request $request, $id){
        
        if(!is_null($request->foto_perfil)){
            
            $website   = \Hyn\Tenancy\Facades\TenancyFacade::website();
            $directory_url = 'tenancy/tenants/'.$website->uuid.'/media/perfil';
            
            $file = $request->file('foto_perfil');
            
            $path = Storage::putFile($directory_url, $file);
            $path_explode = explode("media", $path);
            $filename = $path_explode[1];
            $originalFilename = $file->getClientOriginalName();
            $size = Storage::size($path);
            $mineType = $file->getClientMimeType();
            $extension = $file->extension();
            $external_url = route('tenant.media', ['path' => $filename]);

            User::find($id)->update([
                'foto_perfil'=>$external_url
            ]);
        }
        $data = $request->all();
        unset($data['foto_perfil']);
        $user = User::find($id);
        $user->update($data);
        return response()->json(
            [
                'success'=>true,
                'data'=>$user
            ],200
        );
    }

    public function getAll(Request $request){
        $users = User::all();
        $response = [];
        foreach($users as &$user){
            $cargo = $user->cargo()->get();
            $setor = $user->setor()->get();
        
            $builder['user'] = $user;
            $builder['user']['cargo'] = $cargo;
            $builder['user']['setor'] = $setor;

            $response[] = $builder;
        }

        return response()->json(
            [
                'success'=>true,
                'data'=>$response
            ],200
        );
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
            
            $response['user'] = $user;
            $response['user']['cargo'] = $user->cargo()->get();
            $response['user']['setor'] = $user->setor()->get();
            
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