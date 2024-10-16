<?php

namespace App\Imports;

use App\Models\ExcelList;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ExcelListImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ExcelList([
            'name'=> $row['name']
        ]);
    }

    public function rules():array
    {
      return [
        'name'=>'required',
      ];
    }
}
