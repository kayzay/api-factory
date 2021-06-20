<?php

use App\Workers;
use Illuminate\Database\Seeder;

class WorkersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workerList = [
            "Андрей",
            "Сергей",
            "Михаил",
            "Стас",
            "Артем",
            "Татьяна",
            "Евгений",
            "Катя",
            "Борис",
        ];


        foreach ($workerList as $item) {
            (new Workers(["name" => $item]))->save();
        }
    }
}
