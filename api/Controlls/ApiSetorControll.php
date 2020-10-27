<?php

namespace Api\Controlls;

use App\Setor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Mail;

class ApiSetorControll extends Controller
{

    public function create(Request $request, $id)
    {
        $user = $request->user();
        if(is_null($user)){
            return response()->json(['success'=>false, 'error'=>"Token invalid."],401);
        }

        $validate = Validator::make(
            $request->all(),
            [
                'email'=>'required| email' ,
                'cargo_id'=>'required',
                'setor_id'=>'required',
                'name' =>'required',
                'role' =>'required'
            ]);
        
        $member = User::create($request->all());

        return response()->json(['data'=>$data_view]);
    }

    public function update(Request $request, $id)
    {
        $pop = Pop::with('uploads')->with('functions')->with('processes')->find($id);
        $historic = PopHistoric::where('pop_id', $id);

        if($request){
            if($request->start){
                $start_date = explode("/", $request->start);
                $start_date = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];
                $historic->where('updated_at', '>=' , Carbon::create($start_date));
            }
            if($request->end){
                $end_date = explode("/", $request->end);
                $end_date = $end_date[2].'-'.$end_date[1].'-'.$end_date[0];
                $historic->where('updated_at', '<=' , Carbon::create($end_date));
            }
        }

        $data = array(
            'pop' => $pop,
            'current_version' => $pop->active_version_id,
            'historic' => $historic->with('recurrence')->with('createdBy')->orderBy('updated_at','desc')->paginate(5)
        );

        return response()->json($data, 200);
    }

    public function delete()
    {
        //
    }

    public function getAll(Request $request)
    {
        //
    }

    public function getById(Pop_historic $pop_historic)
    {
        //
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