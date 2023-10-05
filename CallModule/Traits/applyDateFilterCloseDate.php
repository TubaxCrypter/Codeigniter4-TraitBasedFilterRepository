<?php

namespace App\Libraries\Filters\CallModule\Traits;

use DateTime;

trait applyDateFilterCloseDate {
    public function applyDateFilterCloseDate($searchParams) {
        $dateKey = 'close_date';

        if ($searchParams) {
            $start = DateTime::createFromFormat('d.m.Y', $searchParams['start'])->format('Y-m-d');
            $end = DateTime::createFromFormat('d.m.Y', $searchParams['end'])->format('Y-m-d');

            $this->builder->where("$dateKey IS NOT NULL")
                ->where("$dateKey != ''")
                ->where("DATE($dateKey) >= ", $start)
                ->where("DATE($dateKey) <= ", $end);



            $this->analysis['applyDateFilterCloseDate'] = [
                'processed' => true,
                'resultCount' => ['start' => $start , 'end' => $end],
            ];
        }
    }
}
