<?php

namespace App\Console;

use Api\User\Models\User;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateTenantCommand extends Command
{
    protected $signature = 'tenant:create {name} {email}';
    protected $description = 'Creates a tenant with the provided name and email address e.g. php artisan tenant:create boise boise@example.com';
    private $uuid = null;

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        if ($this->tenantExists($name, $email)) {
            $this->error("A tenant with name '{$name}' and/or '{$email}' already exists.");
            return;
        }
        $hostname = $this->registerTenant($name, $email);
        app(Environment::class)->hostname($hostname);
        // we'll create a random secure password for our to-be admin
        $password = str_random();
        #$this->addAdmin($name, $email, $password);
        $this->oauthClient();
        $this->info("Tenant '{$name}' is created and is now accessible at {$hostname->fqdn}");
        $this->info("Admin {$email} can log in using password {$password}");
    }
    private function tenantExists($name, $email)
    {
        $baseUrl = config('app.url_base');
        $fqdn = "{$name}.{$baseUrl}";
        return Hostname::where('fqdn', $fqdn)->exists();
    }
    private function registerTenant($name, $email)
    {


        // associate the customer with a website
        $website = new Website;
        $wb = app(WebsiteRepository::class)->create($website);
        $this->uuid = $wb->uuid;

        $this->info('new uuid create for user: ' . $this->uuid);
        // associate the website with a hostname
        $hostname = new Hostname;
        $baseUrl = config('app.url_base');
        $hostname->fqdn = "{$name}.{$baseUrl}";
        app(HostnameRepository::class)->attach($hostname, $website);

        return $hostname;
    }

    private function oauthClient(){
        $this->info("Inicio inserção oauth");

        $oauth_clients = DB::connection('system')->table('oauth_clients')->get();

        foreach ($oauth_clients as $item) {

            $this->info("Inserindo OAuth {$item->name}");

            DB::connection('mysql')->insert(
                'insert into ' . $this->uuid . '.oauth_clients 
                 (user_id, name, secret, redirect, personal_access_client, password_client, revoked) 
                  values (?, ?, ?, ?, ?, ?, ?)', [
                $item->user_id,
                $item->name,
                $item->secret,
                $item->redirect,
                $item->personal_access_client,
                $item->password_client,
                $item->revoked
            ]);
        }
    }

    private function addAdmin($name, $email, $password)
    {
        $admin = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'confirmed' => true
        ]);
//        $admin->guard_name = 'api';
//        $admin->assignRole('admin');
        return $admin;
    }
}
