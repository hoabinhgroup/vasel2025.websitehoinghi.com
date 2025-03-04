<?php

namespace Modules\Base\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;

Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

class BaseExport implements FromArray, ShouldAutoSize, WithEvents
{
	
	protected $repository;
	
	
	public function __construct(array $repository)
    {
        $this->repository = $repository;
    }
	
   public function array(): array
    {
        return $this->repository;
    }
    
    public function registerEvents(): array
{
        return [
            AfterSheet::class => [self::class, 'afterSheet']
        ];
}

	public static function afterSheet(AfterSheet $event){

//Range Columns
	$event->sheet->styleCells(
            'A1:P1',
            [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => '#000000']
                ],
				'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  15,
                            'bold'      =>  true,
                            'color' => ['argb' => 'FFFFFF'],
                        ]
            ]
        );
        
        //$event->sheet->setColumnFormat(array('E'=>'@'));
     
}


}
