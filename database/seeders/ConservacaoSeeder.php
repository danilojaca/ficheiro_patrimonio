<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Conservacao;

class ConservacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conservacoes = [
            "Muito Bom",
            "Bom",
            "Razoavel",
            "Mau",
            "Avariado",
            "Indefinido",
            "Abatido" 
        ];

        foreach ($conservacoes as $conservacao) {
            Conservacao::create(['conservacao' => $conservacao]);
       }
    }
}
