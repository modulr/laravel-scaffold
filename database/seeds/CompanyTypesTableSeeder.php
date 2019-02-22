<?php

use Illuminate\Database\Seeder;

class CompanyTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_types')->insert([
            [
                'type' => 'Empresa Importadora'
            ],
            [
                'type' => 'Empresa Exportadora'
            ],
            [
                'type' => 'Ag. Aduanal Importadora'
            ],
            [
                'type' => 'Ag. Aduanal Exportadora'
            ],
            [
                'type' => 'Coordinadora Importadora'
            ],
            [
                'type' => 'Coordinadora Exportadora'
            ]
        ]);
    }
}
