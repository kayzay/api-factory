<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workers extends Model
{
    //

    public function queue()
    {
        return $this->hasMany(Queue::class, 'worker_id', 'id')
            ->where("status", '=', Queue::STATUS_ACTIVE);
    }


}
