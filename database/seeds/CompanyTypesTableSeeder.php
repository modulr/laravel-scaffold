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
                'type' => 'Empresa Importadora',
                'acronym' => 'EI'
            ],
            [
                'type' => 'Empresa Exportadora',
                'acronym' => 'EE'
            ],
            [
                'type' => 'Ag. Aduanal Importadora',
                'acronym' => 'AI'
            ],
            [
                'type' => 'Ag. Aduanal Exportadora',
                'acronym' => 'AE'
            ],
            [
                'type' => 'Coordinadora Importadora',
                'acronym' => 'CI'
            ],
            [
                'type' => 'Coordinadora Exportadora',
                'acronym' => 'CE'
            ]
        ]);
    }
}
