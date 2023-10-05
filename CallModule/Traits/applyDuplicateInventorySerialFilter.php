<?php
namespace App\Libraries\Filters\CallModule\Traits;

trait applyDuplicateInventorySerialFilter {
    public function ApplyDuplicateInventorySerialFilter($value) {
        if ($value) {
            switch ($value) {
                case 'match':
                    $inventorySerialsQuery = $this->builder
                        ->select('inventory_serial')
                        ->groupBy('inventory_serial')
                        ->having('COUNT(inventory_serial) >', 1)
                        ->get();

                    $inventorySerials = array_column($inventorySerialsQuery->getResultArray(), 'inventory_serial');
                    $this->builder->whereIn('module_calls_calls.inventory_serial', $inventorySerials);
                    break;

                case 'not_match':
                    $inventorySerialsQuery = $this->builder
                        ->select('inventory_serial')
                        ->groupBy('inventory_serial')
                        ->having('COUNT(inventory_serial) =', 1)
                        ->get();

                    $inventorySerials = array_column($inventorySerialsQuery->getResultArray(), 'inventory_serial');
                    $this->builder->whereIn('module_calls_calls.inventory_serial', $inventorySerials);
                    break;

                case 'equal':
                case 'greater_than':
                case 'less_than':
                    // Burada $searchParams değişkenini kullanacaksanız bu değişken tanımlı değil.
                    // Bu nedenle bu kısmı düzenlemeniz veya fonksiyona ek bir parametre olarak $searchParams'ı geçirmeniz gerekiyor.
                    // Bilgi için bu kısmı yorum satırı haline getiriyorum.
                    /*
                    if (isset($searchParams['inventory_serial_value'])) {
                        $comparisonValue = $searchParams['inventory_serial_value'];
                        switch ($value) {
                            case 'equal':
                                $this->builder->where('module_calls_calls.inventory_serial', $comparisonValue);
                                break;
                            case 'greater_than':
                                $this->builder->where('module_calls_calls.inventory_serial >', $comparisonValue);
                                break;
                            case 'less_than':
                                $this->builder->where('module_calls_calls.inventory_serial <', $comparisonValue);
                                break;
                        }
                    }
                    */
                    break;
            }
            $this->builder->orderBy('module_calls_calls.inventory_serial', 'ASC');
        }
    }
}
