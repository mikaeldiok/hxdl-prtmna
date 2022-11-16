<?php

namespace Modules\Vehicle\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Vehicle\Entities\Core;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon as Carbon;

class VehicleCoreDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        Schema::disableForeignKeyConstraints();

        $faker = \Faker\Factory::create();

        // Add the master administrator, user id of 1df
        $vehiclecores = [
            [
                'vehicle_core_code'              => "major",
                'vehicle_core_name'              => "Jurusan",
                'vehicle_core_value'             => "jurusan1,jurusan2,jurusan3,--bisa ditambah",
            ],
            [
                'vehicle_core_code'              => "recruitment_status",
                'vehicle_core_name'              => "Status Rekrutan",
                'vehicle_core_value'             => "status1,status2,--custom,status3",
            ],
            [
                'vehicle_core_code'              => "skills",
                'vehicle_core_name'              => "Status Rekrutan",
                'vehicle_core_value'             => "skill1,skill2,skill3,--bisa ditambah",
            ],
            [
                'vehicle_core_code'              => "certificate",
                'vehicle_core_name'              => "Status Rekrutan",
                'vehicle_core_value'             => "cert1,cert2,cert3,--bisa ditambah",
            ],
        ];

        foreach ($vehiclecores as $vehiclecore_data) {
            $vehiclecore = Core::firstOrCreate($vehiclecore_data);
        }

        Schema::enableForeignKeyConstraints();
    }
}
