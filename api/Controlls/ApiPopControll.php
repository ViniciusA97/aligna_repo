<?php

namespace Api\Controlls;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadController;

use App\Recurrence;
use App\Pop;
use App\PopHistoric;
use App\Functionm;
use App\Process;
use App\Upload;

use Cookie;

use Carbon\Carbon;

class ApiPopControll extends Controller
{

    protected $pdcaList = ['P - Planejamento', 'D - Execução', 'C - Conferência', 'A - Correção'];
    protected $perfilList = ['Operacional', 'Tático', 'Estratégico'];
    protected $statusList = [
        "preenchimento" => ['Em construção', 'Desatualizado', 'Concluído', 'Inativo'],
        "execucao" => ['Está sendo executado', 'Está sendo parcialmente executado', 'Não está sendo executado']
    ];

    public $search = '';
    public $searchs_ids = [];
    public $filters = [];
    public $sort = [];

    public function get(Request $request)
    {
        //dd($request);
        $pops = Pop::query();

        if($request){

            if($request->search){
                $this->search = $request->search;
                $pops->whereHas('version', function (Builder $query) {
                    $query->where('title', 'like', '%'.$this->search.'%');
                });
            }

            if($request->process){
                $this->filters['process'] = $request->process;
                $pops->whereHas('processes', function (Builder $query) {
                    $query->where('process_id', '=', $this->filters['process']);
                });
            }

            if($request->pdca){
                $this->filters['pdca'] = $request->pdca;
                $pops->whereHas('version', function (Builder $query) {
                    $query->where('pdca', '=', $this->filters['pdca']);
                });
            }

            if($request->status){
                $this->filters['status'] = $request->status;
                $pops->whereHas('version', function (Builder $query) {
                    $query->where('status', '=', $this->filters['status']);
                });
            }

            if($request->perfil){
                $this->filters['perfil'] = $request->perfil;
                $pops->whereHas('version', function (Builder $query) {
                    $query->where('perfil', '=', $this->filters['perfil']);
                });
            }

            if($request->function){
                $this->filters['function'] = $request->function;
                $pops->whereHas('functions', function (Builder $query) {
                    $query->where('function_id', '=', $this->filters['function']);
                });
            }

            if($request->by && $request->order){
                $this->sort['by'] = $request->by;
                $this->sort['order'] = $request->order;
                switch($request->by){
                    case 'id':
                        $pops->orderBy('id', $this->sort['order']);
                        break;
                    case 'name':

                        break;
                    case 'date':
                        $pops->orderBy('updated_at', $this->sort['order']);
                        break;
                    default:
                        $pops->orderBy('updated_at', 'desc');
                        break;
                }
            }
        }

        $data_view = array(
            
            'data' => (object) [
                'pdca' => $this->pdcaList,
                'perfil' => $this->perfilList,
                'status' => $this->statusList,
                'functions' => Functionm::all(),
                'process' => Process::all(),
                'pops' => $pops->orderBy('updated_at','desc')->paginate(5)
            ]
        );
        return response()->json($data_view,200);
    }

    public function list(Request $request)
    {
        $pops = Pop::join('pop_historics', 'pops.active_version_id', '=', 'pop_historics.id');
        $pops_active_ids = Pop::whereNotNull('active_version_id')->pluck('active_version_id')->toArray();

        if($request){

            if($request->search && $request->search != ''){
                $this->search = explode(' ', $request->search);
                $this->searchs_ids = [];
                foreach($this->search as $s){
                    $search = PopHistoric::whereIn('id', $pops_active_ids)->where('title', 'like', '%'.$s.'%')->pluck('id')->toArray();
                    foreach($search as $sr){
                        array_push($this->searchs_ids, $sr);
                    }
                }
                $pops->whereHas('version', function (Builder $query) {
                    $query->whereIn('id', $this->searchs_ids);
                });
            }

            if($request->process && $request->process != ''){
                $this->filters['process'] = $request->process;
                $pops->whereHas('processes', function (Builder $query) {
                    $query->where('process_id', '=', $this->filters['process']);
                });
            }

            if($request->pdca && $request->pdca != ''){
                $this->filters['pdca'] = $request->pdca;
                $pops->whereHas('version', function (Builder $query) {
                    $query->where('pdca', '=', $this->filters['pdca']);
                });
            }

            if($request->status_preenchimento && $request->status_preenchimento != ''){
                $this->filters['status_preenchimento'] = $request->status_preenchimento;
                $pops->whereHas('version', function (Builder $query) {
                    $query->where('status_preenchimento', '=', $this->filters['status_preenchimento']);
                });
            }

            if($request->status_execucao && $request->status_execucao != ''){
                $this->filters['status_execucao'] = $request->status_execucao;
                $pops->whereHas('version', function (Builder $query) {
                    $query->where('status_execucao', '=', $this->filters['status_execucao']);
                });
            }

            if($request->perfil && $request->perfil != ''){
                $this->filters['perfil'] = $request->perfil;
                $pops->whereHas('version', function (Builder $query) {
                    $query->where('perfil', '=', $this->filters['perfil']);
                });
            }

            if($request->function && $request->function != ''){
                $this->filters['function'] = $request->function;
                $pops->whereHas('functions', function (Builder $query) {
                    $query->where('function_id', '=', $this->filters['function']);
                });
            }

            if($request->by && $request->order){
                $this->sort['by'] = $request->by;
                $this->sort['order'] = $request->order;
                switch($request->by){
                    case 'id':
                        $pops->orderBy('pops.id', $this->sort['order']);
                        break;
                    case 'title':
                        $pops->orderBy('pop_historics.title', $this->sort['order']);
                        break;
                    case 'date':
                        $pops->orderBy('pops.updated_at', $this->sort['order']);
                        break;
                    default:
                        $pops->orderBy('pops.id', 'desc');
                        break;
                }
            }
        }

        $data = array(
            'pops' => $pops->select('pops.*','pop_historics.title', 'pop_historics.resume', 'pop_historics.pdca', 'pop_historics.perfil', 'pop_historics.status_preenchimento', 'pop_historics.status_execucao', 'pop_historics.description')->paginate(10),
            'searchs_ids' => $this->searchs_ids
        );

        if($request && $request->format && $request->format == 'pdf') {
            $pdf = \PDF::loadView('pop.pdfs.list', [
                'pops' => $data['pops']
            ]);
            $pdf->save(storage_path().'_filename.pdf');

            return $pdf->download('pop-lista.pdf');
        }

        return response()->json($data, 200);
    }

    public function selects(Request $request)
    {
        $data = array(
            'pdca' => $this->pdcaList,
            'perfil' => $this->perfilList,
            'status' => $this->statusList,
            'functions' => Functionm::all(),
            'process' => Process::all()
        );

        return response()->json($data, 200);
    }

    public function create()
    {
        $data_view = array(
            'page' => (object) [
                'title' => 'POPs'
            ],
            'data' => (object) [
                'pdca' => $this->pdcaList,
                'perfil' => $this->perfilList,
                'status' => $this->statusList,
                'functions' => Functionm::all(),
                'process' => Process::all()
            ]
        );
        return response()->json($data_view,200);
    }

    
    public function teste(Request $request)
    {
        //dd($request);
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            // 'resume' => 'required|max:200',
            // 'description' => 'required',
            // 'pdca' => 'required',
            // 'perfil' => 'required',
            // 'functions' => 'required',
            // 'process' => 'required',
            // 'frequencia' => 'required',
        ]);

        $user_id = 1;

        if($request->start_date){
            $start_date = explode("/", $request->start_date);
            $start_at = $start_date[2].'-'.$start_date[1].'-'.$start_date[0].' 23:59:59';
        }

        if($request->frequencia){
            try{
                $rrule = json_decode($request->frequencia);

                $recurrence = new Recurrence();
                $recurrence->user_creator_id = $user_id;
                $recurrence->rrule = serialize([
                    'FREQ' => $rrule->freq,
                    'WHEN' => $rrule->values
                ]);
                if($request->start_date){
                    $recurrence->start_date = $start_at;
                }
                // $recurrence->end_date = $end_date[2].'-'.$end_date[1].'-'.$end_date[0].' 23:59:59';

                $recurrence->save();
            } catch(\Exception $e) {
                return response()->json($e->getMessage(), 500);
                //return back()->withInput()->with('action_error', 'Algo saiu errado. Por favor tente novamente!');
            }
        }

        try{
            $pop = new Pop();
            $pop->user_creator_id = $user_id;
            if(isset($recurrence)) {
                $pop->recurrence_id = $recurrence->id;
            }
            $pop->save();
        } catch(\Exception $e) {
            // return response()->json($e, 500);
            if(isset($recurrence)) {
                $recurrence->delete();
            }
            return response()->json($e->getMessage(),406);
            //return back()->withInput()->with('action_error', 'Algo saiu errado ao criar o POP. Por favor tente novamente!');
        }

        try{
            $popHistoric =  new PopHistoric();
            $popHistoric->user_creator_id = $user_id;
            if(isset($recurrence)) {
                $popHistoric->recurrence_id = $recurrence->id;
            }
            $popHistoric->pop_id = $pop->id;
            $popHistoric->title = $request->title;
            $popHistoric->resume = $request->resume;
            $popHistoric->description = $request->description;
            $popHistoric->hours = $request->hours ? str_replace(":",".",$request->hours) : 0;
            $popHistoric->pdca = $request->pdca;
            $popHistoric->perfil = $request->perfil;
            $popHistoric->status_preenchimento = $request->status_preenchimento;
            $popHistoric->status_execucao = $request->status_execucao;
            if($request->start_date){
                $popHistoric->start_at = $start_at;
            }
            $popHistoric->save();

            $pop->active_version_id = $popHistoric->id;
            $pop->save();

        } catch(\Exception $e) {
            if(isset($recurrence)) {
                $recurrence->delete();
            }
            $pop->delete();
            return response()->json($e->getMessage(),406);
            //return back()->withInput()->with('action_error', 'Algo saiu errado ao criar o POP. Por favor tente novamente!');
        }

        try{
            if($request->functions){
                $pop->functions()->attach($request->functions);
            }
            if($request->process){
                $pop->processes()->attach($request->process);
            }

            if($request->files_uploaded && $request->files_uploaded != ''){
                $uploads_ids = explode(",", $request->files_uploaded);
                Upload::whereIn('id', $uploads_ids)
                ->update(['pop_id' => $pop->id]);
            }
        } catch(\Exception $e) {
            if(isset($recurrence)) {
                $recurrence->delete();
            }
            $pop->delete();
            $popHistoric->delete();
            return response()->json($e->getMessage(),406);
            //return back()->withInput()->with('action_error', 'Algo saiu errado ao criar o POP. Por favor tente novamente!');
        }

        return response()->json(["success"=>true],201);
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            // 'resume' => 'required|max:200',
            // 'description' => 'required',
            // 'pdca' => 'required',
            // 'perfil' => 'required',
            // 'functions' => 'required',
            // 'process' => 'required',
            // 'frequencia' => 'required',
        ]);

        $user_id = 1;

        if($request->start_date){
            $start_date = explode("/", $request->start_date);
            $start_at = $start_date[2].'-'.$start_date[1].'-'.$start_date[0].' 23:59:59';
        }

        if($request->frequencia){
            try{
                $rrule = json_decode($request->frequencia);

                $recurrence = new Recurrence();
                $recurrence->user_creator_id = $user_id;
                $recurrence->rrule = serialize([
                    'FREQ' => $rrule->freq,
                    'WHEN' => $rrule->values
                ]);
                if($request->start_date){
                    $recurrence->start_date = $start_at;
                }
                // $recurrence->end_date = $end_date[2].'-'.$end_date[1].'-'.$end_date[0].' 23:59:59';

                $recurrence->save();
            } catch(\Exception $e) {
                return response()->json($e, 500);
            }
        }

        try{
            $pop = new Pop();
            $pop->user_creator_id = $user_id;
            if(isset($recurrence)) {
                $pop->recurrence_id = $recurrence->id;
            }
            $pop->save();
        } catch(\Exception $e) {
            // return response()->json($e, 500);
            if(isset($recurrence)) {
                $recurrence->delete();
            }
            return response()->json($e, 500);
        }

        try{
            $popHistoric =  new PopHistoric();
            $popHistoric->user_creator_id = $user_id;
            if(isset($recurrence)) {
                $popHistoric->recurrence_id = $recurrence->id;
            }
            $popHistoric->pop_id = $pop->id;
            $popHistoric->title = $request->title;
            $popHistoric->resume = $request->resume;
            $popHistoric->description = $request->description;
            $popHistoric->hours = $request->hours ? str_replace(":",".",$request->hours) : 0;
            $popHistoric->pdca = $request->pdca;
            $popHistoric->perfil = $request->perfil;
            $popHistoric->status_preenchimento = $request->status_preenchimento;
            $popHistoric->status_execucao = $request->status_execucao;
            if($request->start_date){
                $popHistoric->start_at = $start_at;
            }
            $popHistoric->save();

            $pop->active_version_id = $popHistoric->id;
            $pop->save();

        } catch(\Exception $e) {
            if(isset($recurrence)) {
                $recurrence->delete();
            }
            $pop->delete();
            return response()->json($e, 500);
        }

        try{
            if($request->functions){
                $pop->functions()->attach($request->functions);
            }
            if($request->process){
                $pop->processes()->attach($request->process);
            }

            if($request->files_uploaded && $request->files_uploaded != ''){
                $uploads_ids = explode(",", $request->files_uploaded);
                //dd($uploads_ids);
                Upload::whereIn('id', $uploads_ids)
                ->update(['pop_id' => $pop->id]);
            }
            $request->request->add(['pop_id'=>$pop->id]);
            $response = new UploadController();
            $response->store($request);
        } catch(\Exception $e) {
            if(isset($recurrence)) {
                $recurrence->delete();
            }
            $pop->delete();
            $popHistoric->delete();
            return response()->json(['action_error'=> 'Algo saiu errado ao criar o POP. Por favor tente novamente!', 'Error'=>$e->getMessage()],500);
        }

        return response()->json(["success"=>true],201);
    }

    public function show($id)
    {
        $pop = Pop::find($id);
        if(!$pop){
            return response()->json('POP não encontrado!', 500);
        }

        $rec = null;
        if($pop->version->recurrence_id){
            $recurrence = Recurrence::find($pop->version->recurrence_id);
            $start_date = $pop->version->start_at;
            $rec = (object) array(
                'rule' => $recurrence->rrule,
                'start_date' => $start_date->format('d/m/Y')
            );
        }
        return response()->json([
            'pop' => $pop,
            'version' => $pop->version,
            'recurrence' => $rec,
            'functions' => $pop->functions,
            'processes' => $pop->processes,
            'uploads' => $pop->uploads
        ], 200);
    }

    public function edit($id)
    {
        $pop = Pop::find($id);

        if(!$pop){
            return redirect('pops')->with('action_error', 'POP não encontrado!');
        }

        $functions_ids = array();
        foreach($pop->functions as $fun){
            array_push($functions_ids, $fun->id);
        }

        $processes_ids = array();
        foreach($pop->processes as $proc){
            array_push($processes_ids, $proc->id);
        }

        $recurrence = null;
        if($pop->version->recurrence){
            $recurrence = (object) array(
                'start_date' => $pop->version->recurrence->start_date,
                'end_date' => $pop->version->recurrence->end_date,
                'rule' => (object) $pop->version->recurrence->rrule,
            );
        }

        $data_view = array(
            'data' => (object) [
                'pop' => $pop,
                'functions_ids' => $functions_ids,
                'processes_ids' => $processes_ids,
                'pop_recurrence' => $recurrence,
                'pdca' => $this->pdcaList,
                'perfil' => $this->perfilList,
                'status' => $this->statusList,
                'functions' => Functionm::all(),
                'process' => Process::all()
            ]
        );
        return response()->json($data_view,200);
    }

    public function update(Request $request, $id)
    {
        $pop = Pop::find($id);
        //dd($request->all());
        if(!$pop){
            return response()->json(['action_error'=>'Pop não encontrado'],404);
        }

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            // 'description' => 'required',
            // 'pdca' => 'required',
            // 'perfil' => 'required',
            // 'functions' => 'required',
            // 'process' => 'required',
            // 'frequencia' => 'required',
        ]);

        $user_id = 1;

        if($request->start_date){
            $start_date = explode("/", $request->start_date);
            $start_at = $start_date[2].'-'.$start_date[1].'-'.$start_date[0].' 23:59:59';
        }
        
        try{

            $rrule = $request->frequencia;
            $freq = $rrule['freq'];
            $value = $rrule['values'];
            if($request->frequencia){
                //if exist update recurrence - else create
                if($pop->recurrence){
                    $rrule = serialize([
                        'FREQ' => $freq,
                        'WHEN' => $value
                    ]);

                    $recurrence = Recurrence::find($pop->recurrence->id);
                    $recurrence->rrule = $rrule;
                    if($request->start_date){
                        $recurrence->start_date = $start_at;
                    }
                    $recurrence->save();
                }else{
                    $recurrence = new Recurrence();
                    $recurrence->user_creator_id = $user_id;
                    $recurrence->rrule = serialize([
                        'FREQ' => $freq,
                        'WHEN' => $value
                    ]);

                    if($request->start_date){
                        $recurrence->start_date = $start_at;
                    }

                    $recurrence->save();
                }
                
            }

            //functions and processes
            if($request->functions){
                $pop->functions()->sync($request->functions);
            }
            if($request->process){
                $pop->processes()->sync($request->process);
            }

            if(
                $request->title != $pop->version->title ||
                $request->description != $pop->version->description ||
                $request->pdca != $pop->version->pdca ||
                $request->perfil != $pop->version->perfil ||
                $request->status_preenchimento != $pop->version->status_preenchimento ||
                $request->status_execucao != $pop->version->status_execucao ||
                str_replace(":",".",$request->hours) != $pop->version->hours
            ){
                $popHistoric = new PopHistoric();
                $popHistoric->user_creator_id = $user_id;
                if(isset($recurrence)){
                    $popHistoric->recurrence_id = $recurrence->id;
                }
                $popHistoric->pop_id = $pop->id;
                $popHistoric->title = $request->title;
                $popHistoric->description = $request->description;
                $popHistoric->resume = $request->resume;
                $popHistoric->hours = $request->hours ? str_replace(":",".",$request->hours) : 0;
                $popHistoric->pdca = $request->pdca;
                $popHistoric->perfil = $request->perfil;
                $popHistoric->status_preenchimento = $request->status_preenchimento;
                $popHistoric->status_execucao = $request->status_execucao;
                if($request->start_date){
                    $popHistoric->start_at = $start_at;
                }
                $popHistoric->save();

                $pop->active_version_id = $popHistoric->id;
                if(isset($recurrence)){
                    $pop->recurrence_id = $recurrence->id;
                }
                $pop->save();
            }

            return response()->json(['success'=>'POP editado com sucesso!'],200);
        } catch(\Exception $e) {
            return response()->json(['action_error'=> 'Algo saiu errado. Por favor tente novamente!', 'error'=>$e->getMessage()],400);
        }
    }

    public function version(Request $request, $id)
    {
        $version = PopHistoric::find($id);

        if(!$version){
            return response()->json(['action_error'=>'Pop não encontrado!'],404);
        }

        $pop = Pop::find($version->pop_id);
        if(!$pop){
            return response()->json(['action_error'=>'Pop não encontrado!'],404);
        }

        try{
            $pop->active_version_id = $version->id;
            $pop->save();

            return response()->json(['success'=>'Versão alterada com sucesso!'], 200);
        } catch(\Exception $e) {
            return response()->json('Algo saiu errado. Por favor tente novamente!', 500);
        }
    }

    public function destroy($id)
    {
        try{
            Pop::find($id)->delete();
            return response()->json(['success'=>'Pop deletado com Sucessso!'],200);
        }catch(\Exception $e) {
            return response()->json($e->getMessage, 500);
        }
    }

    public function pdf($id)
    {
        $pop = Pop::find($id);

        if(!$pop){
            return response()-json(['action_error'=> 'POP não encontrado!']);
        }
        $recurrence = null;
        if($pop->recurrence_id){
            switch($pop->recurrence->rrule['FREQ']) {
                case 'diario':
                    $freqRule = 'A cada '.$pop->recurrence->rrule['WHEN'].' dias';
                    break;
    
                case 'semanal':
                    $days = '';
                    $c = 0;
                    foreach($pop->recurrence->rrule['WHEN']->day as $day){
                        $days = $days.$c > 0 ? ',' : ''.$day->label;
                        $c++; 
                    }
                    $freqRule = 'Em toda(o): '.$days.', a cada '.$pop->recurrence->rrule['WHEN']->eachWeeks.' semanas';
                    break;
    
                case 'mensal':
                    if($pop->recurrence->rrule['WHEN']->option === 'first') {
                        $freqRule = 'No dia '.$pop->recurrence->rrule['WHEN']->values->first->label.' de cada mês, a cada '.$pop->recurrence->rrule['WHEN']->values->eachMonths.' meses';
                    }else{
                        $freqRule = 'No(a) '.$pop->recurrence->rrule['WHEN']->values->first->label.' de cada mês, a cada '.$pop->recurrence->rrule['WHEN']->values->eachMonths.' meses';
                    }
                    break;
    
                case 'anual':
                    if($pop->recurrence->rrule['WHEN']->option === 'first') {
                        $freqRule = 'No dia '.$pop->recurrence->rrule['WHEN']->values->first->label.' de '.$pop->recurrence->rrule['WHEN']->values->second->label.'';
                    }else{
                        $freqRule = 'No(a) '.$pop->recurrence->rrule['WHEN']->values->first->label.' '.$pop->recurrence->rrule['WHEN']->values->second->label.' de '.$pop->recurrence->rrule['WHEN']->values->third->label;
                    }
                    break;
                default:
                    $freqRule = 'nada';
            }
            // print_r($pop->recurrence->rrule['FREQ']);
            // print_r($pop->recurrence->rrule['WHEN']);
            // echo "<br /><br /><br /><br />";
            // echo $freqRule;exit;
            $recurrence = (object) array(
                'rule' => $freqRule,
                'end_date' => $pop->recurrence->end_date->format('d/m/Y')
            );
        }
        
        $pdf = \PDF::loadView('pop.pdfs.pop', [
            'pop' => $pop,
            'recurrence' => $recurrence
        ]);
        $pdf->save(storage_path().'_filename.pdf');

        $pdf_name = Str::slug($pop->version->title, '-');
        return $pdf->download($pdf_name.'.pdf');
    }

    public function duplicate($id)
    {
        try{
            $pop = Pop::find($id);
            if(!$pop){
                return response()->json('POP não encontrado!', 500);
            }

            if($pop->recurrence_id){
                $recurrence = new Recurrence();
                $recurrence->user_creator_id = $pop->recurrence->user_creator_id;
                // $recurrence->rrule = $pop->recurrence->rrule;
                
                $recurrence->rrule = serialize([
                    'FREQ' => $pop->recurrence->rrule['FREQ'],
                    'WHEN' => $pop->recurrence->rrule['WHEN']
                ]);
                $recurrence->start_date = $pop->recurrence->start_date;
                $recurrence->end_date = $pop->recurrence->end_date;
                $recurrence->save();
            }

            $clone_pop = new Pop();
            $clone_pop->user_creator_id = $pop->user_creator_id;
            if($pop->recurrence_id)
                $clone_pop->recurrence_id = $recurrence->id;

            $clone_pop->save();

            $popHistoric =  new PopHistoric();
            $popHistoric->user_creator_id = $pop->user_creator_id;
            if($pop->recurrence_id)
                $popHistoric->recurrence_id = $recurrence->id;

            $popHistoric->pop_id = $clone_pop->id;
            $popHistoric->title = $pop->version->title.' - Cópia';
            $popHistoric->description = $pop->version->description;
            $popHistoric->hours = $pop->version->hours;
            $popHistoric->pdca = $pop->version->pdca;
            $popHistoric->perfil = $pop->version->perfil;
            $popHistoric->status_preenchimento = $pop->version->status_preenchimento;
            $popHistoric->status_execucao = $pop->version->status_execucao;
            $popHistoric->start_at = $pop->version->start_at;
            $popHistoric->save();

            $clone_pop->active_version_id = $popHistoric->id;
            $clone_pop->save();

            foreach($pop->functions as $func){
                $clone_pop->functions()->attach($func->id);
            }
            foreach($pop->processes as $process){
                $clone_pop->processes()->attach($process->id);
            }

            foreach($pop->uploads as $item){
                $upload = Upload::create(array(
                    'user_id'       => $item->user_id,
                    'pop_id'        => $clone_pop->id,
                    'title'         => $item->title,
                    'filename'      => $item->filename,
                    'external_url'  => $item->external_url,
                    'external_bucket'  => $item->external_bucket,
                    'external_endpoint'  => $item->external_endpoint,
                    'provider'  => $item->provider,
                    'mine'  => $item->mine,
                    'extension'  => $item->extension,
                    'size'  => $item->size
                ));
            }

            return response()->json(['success'=>'POP duplicado com sucesso!'],200);
        } catch(\Exception $e) {
            return response()->json(['action_error'=>'Houve um erro no processamento da sua requeisição.', 'Error'=>$e->getMessage()]);
        }
    }
}
