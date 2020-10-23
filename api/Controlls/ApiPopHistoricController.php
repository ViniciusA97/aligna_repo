<?php

namespace Api\Controlls;

use App\Pop;
use App\PopHistoric;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ApiPopHistoricController extends Controller
{

    public function index(Request $request, $id)
    {
        if(!$id)
            return response()->json(['error'=>"Id não encontrado"],404);

        $data_view = array(
            'page' => (object) [
                'title' => 'POP'
            ],
        );
        return response()->json(['data'=>$data_view]);
    }

    public function list(Request $request, $id)
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Pop_historic $pop_historic)
    {
        //
    }

    public function edit(Pop_historic $pop_historic)
    {
        //
    }

    public function update(Request $request, Pop_historic $pop_historic)
    {
        //
    }

    public function destroy(Pop_historic $pop_historic)
    {
        //
    }
}
