<?php

namespace App\Exports;

use App\Models\Folder;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FoldersExport implements 
    FromQuery, 
    WithMapping, 
    WithHeadings, 
    ShouldAutoSize, 
    Responsable, 
    WithTitle
{
    use Exportable;
    
    private $writerType = Excel::XLSX;

    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    public function __construct($name){
        $this->name = $name;
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'folder_path',
            'parent_id',
            'created_at',
            'updated_at',
        ];
    }

    /**
    * @var Folder $folder
    */
    public function map($folder): array
    {
        
        return [
            $folder->id,
            $folder->name,
            $folder->folder_path,
            $folder->parent_id,
            $folder->created_at,
            $folder->updated_at,
        ];
    }

    public function query()
    {
        return Folder::query();
    }

    public function title():string{
        return $this->name;
    }
}
