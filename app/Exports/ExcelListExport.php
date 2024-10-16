<?php

namespace App\Exports;

use App\Models\ExcelList;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ExcelListExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ExcelList::select("id", "name")->get();
    }

    public function headings(): array
    {
      return ["ID", "Name"];
    }
}
