<?php

namespace Database\Seeders;

use App\Imports\FundingOrganizationImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class FundingOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new FundingOrganizationImport, 'funding_org.xlsx');
    }
}
