<?php namespace App\Libraries\Filters\CallModule\Traits;

trait applyCallStatusFilter {
    public function applyCallStatusFilter($value) {
        if ($value) {
            // Stringi ayrıştırarak ID'leri ve durum adları
            $statuses = explode(',', $value);
            $statusIds = [];
            foreach ($statuses as $status) {
                preg_match('/\[(\d+)\](\w+)/', $status, $matches);
                if (isset($matches[1])) {
                    $statusIds[] = $matches[1];
                }
            }
            // ID'leri kullanarak filtreleme
            if (!empty($statusIds)) {
                $this->builder->whereIn('call_status', $statusIds);
            }
        }
    }
}
