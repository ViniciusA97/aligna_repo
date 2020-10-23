<?php

namespace App\Http\Controllers;

use App\Upload;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
                    'user_id'       => 1,
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

    public function destroy(Request $request, $id)
    {
        try{
            Upload::find($id)->delete();
        }catch(\Exception $e) {
            return response()->json($e, 500);
        }
    }
}
