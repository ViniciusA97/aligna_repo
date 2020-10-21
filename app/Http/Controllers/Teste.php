<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
//hostname
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Artisan;
use Laravel\Passport\ClientRepository;
use \Validator;
use Laravel\Passport\Passport;

class Teste extends Controller
{
    //
    public function index() {
        // criar nova conta
        $website = new Website;
        $website->managed_by_database_connection = 'system';
        $website->uuid = 'aligna_stalo_cliente';
        app(WebsiteRepository::class)->create($website);

        $hostname = new Hostname;
        $hostname->fqdn = 'cliente.alignastalo.com';
        // $hostname->fqdn = 'sebrae.alignastalo.com';
        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);
        dd($website->hostnames); // Collection with $hostname
    }

    public function online(Request $request) {
        try{
            // criar nova conta
            $validate = Validator::make($request->all(), ['website'=>'required' ,'hostname'=>'required']);
            if($validate->fails()){ return response()->json(['error'=>'Hostname e websites são obrigatórios']);}
            $website = new Website;
            $website->managed_by_database_connection = 'system';

            $website->uuid = $request->website;//alignaco_customer

            //$website->password = '}wp%0aKvJM$t';
            app(WebsiteRepository::class)->create($website);

            $hostname = new Hostname;
            $hostname->fqdn = $request->hostname;//customer

            $hostname = app(HostnameRepository::class)->create($hostname);
            app(HostnameRepository::class)->attach($hostname, $website);
            //dd($website->hostnames); // Collection with $hostname
            $this->configOauth();
            return response()->json($website, 200);
        }catch(\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function configOauth(){
        $config = app(\Hyn\Tenancy\Database\Connection::class)->configuration();
        //dd($config);
        //dd($config);
        $return = Artisan::call('passport:install');
        return response()->json(['data'=>$return]);

    }

}
