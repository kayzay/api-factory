<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Machines extends Model
{
    //
    protected $table = 'machines';

    public function queue()
    {
        return $this->hasMany(Queue::class, 'machine_id', 'id')
            ->where("status", '=', Queue::STATUS_ACTIVE);
    }


    public function getCanUseMachines()
    {
        return DB::table($this->table)
            ->select($this->table .'.id', $this->table .'.name')
            ->leftJoin('queues', function ($join){
                    $join->on( $this->table . '.id', '=', "queues.machine_id")
                        ->where("queues.status", '!=', Queue::STATUS_REMOVE);
            })
            ->where("queues.status", '!=', Queue::STATUS_ACTIVE)
            ->orWhereNull("queues.status")
            ->get();
    }
}
