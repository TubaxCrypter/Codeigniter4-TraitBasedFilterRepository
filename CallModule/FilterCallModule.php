<?php
namespace App\Libraries\Filters\CallModule;


use App\Libraries\Filters\CallModule\Traits\applyDateFilterCloseDate;
use App\Libraries\Filters\CallModule\Traits\applyDateFilterOpenDate;
use App\Libraries\Filters\CallModule\Traits\applyDuplicateInventorySerialFilter;
use App\Libraries\Filters\CallModule\Traits\applyCallStatusFilter;
use App\Libraries\Filters\CallModule\Traits\applyStaffFilter;
use App\Libraries\Filters\CallModule\Traits\applyProjectFilter;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\ConnectionInterface;


class FilterCallModule  {
    use applyDuplicateInventorySerialFilter,
        applyCallStatusFilter,
        applyStaffFilter,
        applyProjectFilter,
        applyDateFilterOpenDate,
        applyDateFilterCloseDate;


    protected $builder;

    protected $db;
    protected $allowedColumns = [];
    protected $analysis = [];
    public function __construct(ConnectionInterface $db, BaseBuilder $builder = null)
    {
        $this->db = $db;
        $this->builder = $builder;
    }


    public function setAllowedColumns($columns)
    {
        $this->allowedColumns = $columns;
    }

    public function applyFilters(array $searchParams)
    {
        foreach ($searchParams as $key => $value) {
            if (isset($this->allowedColumns[$key])) {
                $columnDetails = $this->allowedColumns[$key];
                $column = $columnDetails['column'];
                $filter = $columnDetails['filter'];

                if (isset($columnDetails['join'])) {
                    $this->builder->join($columnDetails['join'], $column, 'left');
                }

                switch ($filter) {
                    case 'like':
                        $this->builder->like($column, $value);
                        break;
                    case 'where':
                        $this->builder->where($column, $value);
                        break;
                    case 'wherein':
                        if (isset($columnDetails['splitter'])) {
                            $values = explode($columnDetails['splitter'], $value);
                            $this->builder->whereIn($column, $values);
                        }
                        break;
                    case 'orlike':
                        $this->builder->orLike($column, $value);
                        break;
                    case 'custom':
                        if (isset($columnDetails['callback']) && is_callable([$this, $columnDetails['callback']])) {
                            call_user_func([$this, $columnDetails['callback']], $value);
                        }
                        break;
                }
            }
        }
    }
    public function limit($perPage, $offset = 0)
    {
        $this->builder->limit($perPage, $offset);
    }
    public function getTotalRecords($searchParams) {
        $this->applyFilters($searchParams);
        return $this->builder->countAllResults();
    }

    public function get()
    {
        return $this->builder->get();
    }
    public function analysis(){
        return $this->analysis;
    }
    public function getBuilder()
    {
        return $this->builder;
    }
}
