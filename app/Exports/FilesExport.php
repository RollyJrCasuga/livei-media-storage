<?php

namespace App\Exports;

use App\Models\File;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FilesExport implements 
    FromQuery, 
    WithMapping, 
    WithHeadings, 
    ShouldAutoSize, 
    Responsable, 
    WithEvents, 
    WithTitle
{
    use Exportable;

    /**
    * It's required to define the fileName within
    * the export class when making use of Responsable.
    */
    // private $fileName = 'files.xlsx';

    /**
    * Optional Writer Type
    */
    private $writerType = Excel::XLSX;

    /**
    * Optional header
    */
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
            'folder_id',
            'mime_type',
            'file_path',
            'file_size',
            'created_at',
            'updated_at',
            'tags',
            'link',
        ];
    }

    /**
    * @var File $file
    */
    public function map($file): array
    {
        $file_tags = $file->tags->pluck('name')->toArray();
        $tags = implode(', ', $file_tags);

        return [
            $file->id,
            $file->name,
            $file->folder_id,
            $file->mime_type,
            $file->file_path,
            $file->file_size,
            $file->created_at,
            $file->updated_at,
            $tags,
            url($file->file_path),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                /** @var Worksheet $sheet */
                foreach ($event->sheet->getColumnIterator('J') as $row) {
                    foreach ($row->getCellIterator() as $cell) {
                        if (str_contains($cell->getValue(), '://')) {
                            $cell->setHyperlink(new Hyperlink($cell->getValue(), 'Read'));

                             $event->sheet->getStyle($cell->getCoordinate())->applyFromArray([
                                'font' => [
                                    'color' => ['rgb' => '0000FF'],
                                    'underline' => 'single'
                                ]
                            ]);
                        }
                    }
                }
            },
        ];
    }

    public function query()
    {
        return File::query();
    }
    
    public function title():string{
        return $this->name;
    }
}