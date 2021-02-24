<?php

namespace App\Exports;

use App\Exports\FilesExport;
use App\Exports\FoldersExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MainExport implements WithMultipleSheets
{
    private $sheets;

    public function sheets(): array{
        $sheets = [
            new FilesExport('files'),
            new FoldersExport('folders')
        ];
        return $sheets;
    }
}
