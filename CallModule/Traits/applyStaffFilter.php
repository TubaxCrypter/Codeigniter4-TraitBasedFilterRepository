<?php namespace App\Libraries\Filters\CallModule\Traits;
trait applyStaffFilter
{
    public function applyStaffFilter($value)
    {
        if ($value) {
            preg_match_all('/\[(\d+)\]/', $value, $matches);
            $staffIds = $matches[1];
            $this->builder->whereIn('module_calls_calls.staff_id', $staffIds);

            // Builder'ın bir kopyasını al
            $cloneBuilder = clone $this->builder;
            $resultCount = $cloneBuilder->countAllResults(); // Kopya üzerinde sayım işlemi

            $this->analysis['applyStaffFilter'] = [
                'processed' => true,
                'staffIdsUsed' => $staffIds, // Kullanılan personel ID'leri
                'resultCount' => $resultCount
            ];
        } else {
            $this->analysis['applyStaffFilter'] = [
                'processed' => false
            ];
        }
    }


}