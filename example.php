<?php
    
    use App\Libraries\Filters\CallModule\FilterCallModule;
   $builder = $this->initializeBuilder();

   $filter = new FilterCallModule($this->db,$builder);

   $allowedColumns = [
       'id' => [
           'column' => 'module_calls_calls.id',
           'filter' => 'wherein',
           'type' => 'string',
           'splitter' => ','
       ],
       'call_title' => [
           'column' => 'call_title',
           'type' => 'string',
           'filter' => 'like'
       ],
       'interviewer_name' => [
           'column' => 'interviewer_name',
           'type' => 'string',
           'filter' => 'like'
       ],
       'interviewer_phone' => [
           'column' => 'interviewer_phone',
           'type' => 'string',
           'filter' => 'like'
       ],
       'inventory_serial' => [
           'column' => 'inventory_serial',
           'type' => 'string',
           'filter' => 'where'
       ],
       'staff_note' => [
           'column' => 'staff_note',
           'type' => 'string',
           'filter' => 'like'
       ],
       'srv_number' => [
           'column' => 'srv_number',
           'type' => 'string',
           'filter' => 'where'
       ],
       'branchName' => [
           'column' => 'branchName',
           'type' => 'string',
           'filter' => 'like'
       ],
       'address' => [
           'column' => 'address',
           'type' => 'string',
           'filter' => 'like'
       ],
       'contract_id' => [
           'column' => 'contract_id',
           'type' => 'string',
           'filter' => 'like'
       ],
       'private_identity' => [
           'column' => 'private_identity',
           'type' => 'string',
           'filter' => 'like'
       ],
       'call_status' => [
           'column' => 'call_status',
           'type' => 'string',
           'filter' => 'custom',
           'callback' => 'applyCallStatusFilter'
       ],
       'staff_id' => [
           'column' => 'module_calls_calls.staff_id',
           'type' => 'string',
           'filter' => 'custom',
           'callback' => 'applyStaffFilter'
       ],
       'project' => [
           'column' => 'app_project.name',
           'type' => 'string',
           'filter' => 'custom',
           'callback' => 'applyProjectFilter'
       ],
       'open_date' => [
           'column' => 'module_calls_calls.open_date',
           'filter' => 'custom',
           'callback' => 'applyDateFilterOpenDate'
       ],
       'close_date' => [
           'column' => 'module_calls_calls.close_date',
           'filter' => 'custom',
           'type' => 'array',
           'callback' => 'applyDateFilterCloseDate'
       ],
       'find_duplicate_inventory_serial' => [
           'column' => 'module_calls_calls.inventory_serial',
           'type' => 'string',
           'filter' => 'custom',
           'callback' => 'applyDuplicateInventorySerialFilter'
       ]
   ];


   $filter->setAllowedColumns($allowedColumns);
   $filter->applyFilters($searchParams);


   $offset = ($page - 1) * $perPage;
   $filter->limit($perPage, $offset);


//        $results = $filter->get()->getResultArray();
   $cloneBuilder = clone $filter;  // Filter'ı klonlayıp builder etkilenmeini önlüyoruz
   $results = $cloneBuilder->get()->getResultArray();

   $analysis = $filter->analysis();
   $totalRecords = $filter->getTotalRecords($searchParams);
   return [
       'results' => $results,
       'totalRecords' => $totalRecords,
       'analysis' => $analysis
   ];