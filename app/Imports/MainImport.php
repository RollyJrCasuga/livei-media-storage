<?php

namespace App\Imports;

use App\Imports\FilesImport;
use App\Imports\FoldersImport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class MainImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'files' => new FilesImport(),
            // 'folders' => new FoldersImport(),
        ];
        
    }
}
