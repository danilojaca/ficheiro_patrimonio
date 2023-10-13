<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'visualizar-permissao',
            'logs',
            'visualizar-inventario',
            'criar-inventario',
            'editar-inventario',
            'excluir-inventario',
            'relatorio',
            'visualizar-edificio',
            'criar-edificio',
            'editar-edificio',
            'excluir-edificio',
            'salas-edificio',
            'visualizar-unidade',
            'criar-unidade',
            'editar-unidade',
            'excluir-unidade',
            'salas-unidade',
            'unidades-permissao-utilizador',
            'salas-permissao-utilizador',
            'visualizar-categoria',
            'criar-categoria',
            'editar-categoria',
            'excluir-categoria',
            'descarregar',
            'visualizar-permissao-utilizador',
            'editar-permissao-utilizador',
            'mostrar-permissao-utilizador',
            'visualizar-permissao-perfis',
            'editar-permissao-perfis',
            'criar-permissao-perfis',
            'excluir-permissao-perfis',
            'mostrar-permissao-perfis',

         ];
      
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}