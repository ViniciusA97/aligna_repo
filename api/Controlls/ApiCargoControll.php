<?php

namespace Api\Controlls;

use App\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Mail;
use \Validator;

class ApiCargoControll extends Controller
{
    

    public function create(Request $request)
    {
        try{
            $check_auth = $this->checkAutentication($request);
            if(!$check_auth['auth']){
                return $check_auth['response'];
            }else{
                //if($user->role != null){
                    //return response()->json(['success'=>false,'error'=>'Escopo de usuário não permite realizar esta ação.'],401);
                //}
            }

            $validate = Validator::make(
                $request->all(),
                [
                    'name'=>'required' ,
                    'resumo'=>'required',
                    'descricao'=>'required'
            ]);
            if($validate->fails()){ 
                return response()->json(['success'=>false,'error'=>'Escopo de usuário não permite executar esta ação.'],401);
            }
            $cargo = Cargo::create($request->all());

            return response()->json(['success'=>true,'data'=>$cargo],201);
        }catch(Exception $e){
            return response()->json(['success'=>false],500);
        }
    }

    public function getAll(Request $request){
        $check_auth = $this->checkAutentication($request);
            if(!$check_auth['auth']){
                return $check_auth['response'];
            }
        try{
            $all_data = Cargo::where('active',1)->get();
            return response()->json(['success'=>true,'data'=>$all_data],200);
        }catch(Exception $e){
            return response()->json(['Error'=>$e->getMessage()],500);
        }
    }

    public function getById($id)
    {
        try{
            $cargo = Cargo::find($id);
            if(is_null($cargo)) return response()->json(['error'=>'Cargo com id '.$id.' não encontrado'],404);
            return response()->json(['success'=>true, 'data'=>$cargo],200);
        }catch(Exception $e){
            return response()->json(['success'=>false, 'error'=>$e->getMessage()],500);
        }
    }

    public function update(Request $request,$id)
    {
        $check_auth = $this->checkAutentication($request);
        if(!$check_auth['auth']){
            return $check_auth['response'];
        }
        $cargo = Cargo::find($id);
        if(is_null($cargo)) return response()->json(['error'=>'Cargo com id '.$id.' não encontrado'],404);
        $cargo->update($request->all());
        return response()->json(['success'=>true, 'data'=>$cargo],200);
    }

    public function delete($id)
    {
        $check_auth = $this->checkAutentication($request);
        if(!$check_auth['auth']){
            return $check_auth['response'];
        }
        try{
            $cargo = Cargo::find($id);
            if(is_null($cargo)) return response()->json(['error'=>'Cargo com id '.$id.' não encontrado'],404);
            $cargo->delete();
            return response()->json(['success'=>true]);
        }catch(Exception $e){
            return response()->json(['success'=>false],500);
        }
    }

    public function checkAutentication($request){
        $user = $request->user();
        if(is_null($user)){
            $response = ['response'=>response()->json(['success'=>false, 'error'=>"Token invalid."],401), 'auth'=>false];
        }
        return ['auth'=>true];
    }

    public function sendMail() {
        $data = array('name'=>"Virat Gandhi");
     
        Mail::send(['text'=>'mail.mail'], $data, function($message) {
           $message->to('viniqueiroz123@gmail.com', 'Teste')->subject
              ('Laravel Basic Testing Mail');
           $message->from('ti@stalo.com','Stalo Software Studio');
        });
     }
}
