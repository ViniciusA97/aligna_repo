<?php

namespace Api\Controlls;

use App\Setor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Mail;
use \Validator;

class ApiSetorControll extends Controller
{

    public function create(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name'=>'required' ,
                'descricao'=>'required'
        ]);
        if($validate->fails()){ 
            return response()->json(['success'=>false,'error'=>'Campos requiridos faltando.'],401);
        }
        try{
            $cargo = Setor::create($request->all());

            return response()->json(['success'=>true,'data'=>$cargo],201);
        }catch(Exception $e){
            return response()->json(['success'=>false],500);
        }
    }

    public function getAll(Request $request){
       
        try{
            $all_data = Setor::where('active',1)->get();
            return response()->json(['success'=>true,'data'=>$all_data],200);
        }catch(Exception $e){
            return response()->json(['Error'=>$e->getMessage()],500);
        }
    }

    public function getById($id)
    {
        try{
            $cargo = Setor::find($id);
            if(is_null($cargo)) return response()->json(['error'=>'Cargo com id '.$id.' não encontrado'],404);
            return response()->json(['success'=>true, 'data'=>$cargo],200);
        }catch(Exception $e){
            return response()->json(['success'=>false, 'error'=>$e->getMessage()],500);
        }
    }

    public function update(Request $request,$id)
    {
        
        $cargo = Setor::find($id);
        if(is_null($cargo)) return response()->json(['error'=>'Cargo com id '.$id.' não encontrado'],404);
        $cargo->update($request->all());
        return response()->json(['success'=>true, 'data'=>$cargo],200);
    }

    public function delete(Request $request , $id)
    {
       
        try{
            $cargo = Setor::find($id);
            if(is_null($cargo)) return response()->json(['error'=>'Cargo com id '.$id.' não encontrado'],404);
            $cargo->delete();
            return response()->json(['success'=>true]);
        }catch(Exception $e){
            return response()->json(['success'=>false],500);
        }
    }

    public function getAllUserById($id){
        $setor = Setor::find($id);
        if(empty($setor)){
            return response()->json(
                [
                    'success'=>false,
                    'error'=>'Não foi possivel encontrar um setor com esse id.',
                    'friendlyMessage'=>'Não foi possível encontrar o setor.'
                ],404);
        }
        $users = $setor->users()->get();

        $response['setor']=$setor;
        $response['setor']['users'] = $users;

        return response()->json(
            [
                'success'=>true,
                'data'=>$response
            ],
            200
        );
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
