<?php namespace App\Libraries\Filters\CallModule\Traits;

use DateTime;

trait applyDateFilterOpenDate{
    public  function applyDateFilterOpenDate($searchParams){
        $dateKey = 'open_date';
        if ($searchParams) {
            $start = DateTime::createFromFormat('d.m.Y', $searchParams['start'])->format('Y-m-d');
            $end = DateTime::createFromFormat('d.m.Y', $searchParams['end'])->format('Y-m-d');
            $this->builder->where("DATE($dateKey) BETWEEN '$start' AND '$end'");
            $this->analysis['applyDateFilterOpenDate'] = [
                'processed' => true,
                'resultCount' => ['start' => $start , 'end' => $end],
            ];
        }
    }
}