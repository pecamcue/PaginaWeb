<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('categorias')->insert([
            [
                'id' => 1,
                'nombre' => 'Gafas de sol',
                'slug' => 'gafas-de-sol',
            ],
            [
                'id' => 2,
                'nombre' => 'Gafas graduadas',
                'slug' => 'gafas-graduadas',
            ],
            [
                'id' => 3,
                'nombre' => 'Lentes de contacto',
                'slug' => 'lentes-de-contacto',
            ],
            [
                'id' => 4,
                'nombre' => 'Accesorios',
                'slug' => 'accesorios',
            ],
            [
                'id' => 5,
                'nombre' => 'Pilas',
                'slug' => 'pilas',
            ],
            [
                'id' => 6,
                'nombre' => 'Liquidos',
                'slug' => 'liquidos',
            ],
        ]);
       
    }
}
