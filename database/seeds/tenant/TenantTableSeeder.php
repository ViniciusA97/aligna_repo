<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
            'role'=>'Administrador'
        ]);
        DB::table('functionms')->insert([
            ['title' => 'Função 1'],
            ['title' => 'Função 2'],
            ['title' => 'Função 3'],
            ['title' => 'Função 4'],
            ['title' => 'Função 5']
        ]);
        DB::table('processes')->insert([
            ['title' => 'Processo 1', 'color' => '#333333'],
            ['title' => 'Processo 2', 'color' => '#ff5500'],
            ['title' => 'Processo 3', 'color' => '#005533'],
            ['title' => 'Processo 4', 'color' => '#ff9922'],
            ['title' => 'Processo 5', 'color' => '#bb52f1']
        ]);
        DB::table('setor')->insert([
            'name'=>'TI',
            'descricao'=>'Apenas um seed para testes'
        ]);
        DB::table('cargo')->insert([
            'name'=>'Desenvolvedor',
            'resumo'=>'Apenas um seed para testes',
            'descricao'=>'Apenas um seed para testes'
        ]);
    }
}
