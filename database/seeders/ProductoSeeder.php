<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productos')->insert([
            'nombre' => "lenovo XXXX",
            'descripcion' => "laptop lenovo",
            'precio' =>  3800, 
            'stock' => 20
            
        ]);
        DB::table('productos')->insert([
            'nombre' => "hp XXXX",
            'descripcion' => "laptop hp",
            'precio' =>  2800, 
            'stock' => 30
            
        ]);
        DB::table('productos')->insert([
            'nombre' => "dell XXXX",
            'descripcion' => "laptop dell",
            'precio' =>  2500, 
            'stock' => 10
            
        ]);
    }
}
