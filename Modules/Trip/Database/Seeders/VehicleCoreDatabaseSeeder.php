<?php

namespace Modules\Trip\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Trip\Entities\Core;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon as Carbon;

class TripCoreDatabaseSeeder extends Seeder
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
        $tripcores = [
            [
                'trip_core_code'              => "major",
                'trip_core_name'              => "Jurusan",
                'trip_core_value'             => "jurusan1,jurusan2,jurusan3,--bisa ditambah",
            ],
            [
                'trip_core_code'              => "recruitment_status",
                'trip_core_name'              => "Status Rekrutan",
                'trip_core_value'             => "status1,status2,--custom,status3",
            ],
            [
                'trip_core_code'              => "skills",
                'trip_core_name'              => "Status Rekrutan",
                'trip_core_value'             => "skill1,skill2,skill3,--bisa ditambah",
            ],
            [
                'trip_core_code'              => "certificate",
                'trip_core_name'              => "Status Rekrutan",
                'trip_core_value'             => "cert1,cert2,cert3,--bisa ditambah",
            ],
        ];

        foreach ($tripcores as $tripcore_data) {
            $tripcore = Core::firstOrCreate($tripcore_data);
        }

        Schema::enableForeignKeyConstraints();
    }
}
