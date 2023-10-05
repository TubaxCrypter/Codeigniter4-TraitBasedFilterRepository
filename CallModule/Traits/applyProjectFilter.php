<?php

namespace App\Libraries\Filters\CallModule\Traits;

use CodeIgniter\Database\BaseBuilder;

trait applyProjectFilter
{
    public function applyProjectFilter($projectName)
    {
        // Builder klonu -> count Alırken sorgu etkilenebilir ve doğru sonuç alınmayabilir
        $cloneBuilder = clone $this->builder;
        $project = $this->db
            ->table('app_projects')
            ->like('name', $projectName)
            ->get()
            ->getRowArray();

        if ($project) {
            $cloneBuilder->where('module_calls_calls.project_id', $project['id']);
        }

        // Analiz çıktısını ekle
        $this->analysis['applyProjectFilter'] = [
            'processed' => true,
            'resultCount' => $cloneBuilder->countAllResults(), // Sorgu sonucu dönen kayıt sayısı
        ];
    }

}
