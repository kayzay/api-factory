<?php

use App\Machines;
use Illuminate\Database\Seeder;

class MachinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $machineList = ['44', '56', '23', '78', '102'];

        foreach ($machineList as $item) {
            (new Machines(['name' => $item]))->save();
        }
    }
}
