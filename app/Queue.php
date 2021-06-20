<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Queue extends Model
{
    //
    protected $table = 'queues';
    protected $fillable = ['worker_id', 'machine_id', 'status'];

    const STATUS_ACTIVE = 1;
    const STATUS_REMOVE = 0;

    private $filters = [
        'limit' => 10,
        'offset' => 0
    ];

    private $pRowTotal = 0;


    public function Machines()
    {
        return $this->hasOne(Machines::class, 'id',  'machine_id');
    }

    public function Workers()
    {
        return $this->hasOne(Workers::class, 'id',  'worker_id');
    }

    public function setPaginationOffset($offset)
    {

        $this->filters['offset'] = $offset;

        return $this;
    }

    public function getPaginationRowTotal()
    {
        return $this->pRowTotal;
    }

    public function setPaginationLimit($limit)
    {
        $this->filters['limit'] = $limit;

        return $this;
    }


    public function getHistoryWorker($worker_id)
    {
        $paginationObject = $this->_paginationObject();
        $paginationObject
            ->where($this->table . '.worker_id', '=', $worker_id)
            ->limit($this->filters['limit'])
            ->offset($this->filters['offset']);

        $this->pRowTotal = $paginationObject->getCountForPagination();
        return $paginationObject->get();
    }


    /**
     * @param $machine_id
     * @return \Illuminate\Support\Collection
     */
    public function getHistoryMachine($machine_id)
    {
        $paginationObject = $this->_paginationObject();
        $paginationObject
            ->where($this->table . '.machine_id', '=', $machine_id)
            ->limit($this->filters['limit'])
            ->offset($this->filters['offset']);

        $this->pRowTotal = $paginationObject->getCountForPagination();
        return $paginationObject->get();
    }

    /**
     * @param $items \Illuminate\Support\Collection
     * @return array
     */
    public function getPageData($items)
    {
        $data = [];

        foreach ($items as $item) {

            $data[] = [
                'worker_name' => $item->worker_name
                , 'machine_name' => $item->machine_name
                , 'status' => $item->status == Queue::STATUS_ACTIVE
                    ? 'работает'
                    : 'закончил работу'
                , 'start_date' => $item->date_start
                , 'end_date' => ( $item->status == Queue::STATUS_ACTIVE)
                    ? '-'
                    : $item->date_end
            ];
        }

        return $data;
    }
    /**
     * @return \Illuminate\Database\Query\Builder|static
     */
    private function _paginationObject()
    {
        return DB::table($this->table)
            ->select(
                $this->table . '.id as id'
                , "machines.name as machine_name"
                , "workers.name as worker_name"
                , $this->table . '.created_at as date_start'
                , $this->table . '.updated_at as date_end'
                , $this->table . '.status as status'
            )
            ->leftJoin('machines', $this->table . '.machine_id', "machines.id")
            ->leftJoin('workers', $this->table . '.worker_id', "workers.id");
    }
}
