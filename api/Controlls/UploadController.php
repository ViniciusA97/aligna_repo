<?php

namespace Api\Controlls;

use App\Upload;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use \Validator;

class UploadController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'user_id'=>'required' ,
                'pop_id'=>'required'
        ]);
        if($validate->fails()){ 
            return response()->json(['success'=>false,'error'=>'Campos requiridos faltando.'],401);
        }
        try{
            if(!$request->hasfile('files')){
                return response()->json(['error' => 'Something wrong. Please, try again!'], 500);
            }

            $website   = \Hyn\Tenancy\Facades\TenancyFacade::website();
            $directory_url = 'tenancy/tenants/'.$website->uuid.'/media';
            $files = $request->file('files');
            foreach($files as $file) {

                if($file->getSize() > 2000005){
                    return response()->json(['error' => 'O tamanho do arquivo não pode ser maior que 2MB.'], 500);
                }

                $path = Storage::putFile($directory_url, $file);
                $path_explode = explode("media/", $path);
                $filename = $path_explode[1];
                $originalFilename = $file->getClientOriginalName();
                $size = Storage::size($path);
                // $mineType = File::mimeType($file);
                $mineType = $file->getClientMimeType();
                $extension = $file->extension();
                $external_url = route('tenant.media', ['path' => $filename]);

                $data = array(
                    'user_id'       =>  $request->user_id,
                    'title'         => $originalFilename,
                    'filename'      => $filename,
                    'external_url'  => $external_url,
                    'external_bucket'  => $path,
                    'external_endpoint'  => route('tenant.media', ['path' => $filename]),
                    'provider'  => 'localhost',
                    'mine'  => $mineType,
                    'extension'  => $extension,
                    'size'  => $size,
                );

                if($request->pop_id){
                    $data['pop_id'] = $request->pop_id;
                }

                $upload = Upload::create($data);
            }
            return response()->json([
                'files' => array(
                    [
                        '_token' => $request->_token,
                        'id' => $upload->id,
                        'name' => $originalFilename,
                        'size' => $size,
                        'deleteType' => "DELETE",
                        'deleteUrl' => route('upload.delete', ['id' => $upload->id]),
                        'error' => "Failed to resize image (original, thumbnail)",
                        'type' => $mineType,
                        'url' => $external_url
                    ]
                )
            ], 200);
        } catch(\Exception $e) {
            return response()->json(['error' => 'Something wrong. Please, try again!'], 500);
        }
    }

    public function show(Upload $upload)
    {
        //
    }

    public function edit(Upload $upload)
    {
        //
    }

    public function update(Request $request, Upload $upload)
    {
        //
    }

    public function all(Request $request, Upload $upload)
    {
        return response()->json(['uploads'=>Upload::all()]);
    }

    public function destroy(Request $request, $id)
    {
        try{
            $upload = Upload::find($id);
            if(is_null($upload)){
                return response()->json([
                    'success'=>false,
                    'error'=>'Not found'
                ],404);
            }
            $upload->delete();
            return response()->json(['success'=>true],200);
        }catch(\Exception $e) {
            return response()->json($e, 500);
        }
    }
}
