<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserDetailImport implements ToCollection , WithHeadingRow 
{
    public function collection(Collection $rows)
    {
        $rows = $this->prepareDataForValidation($rows);
        
        $validator = Validator::make($rows->toArray(), [
            '*.user_id' => 'required|numeric|unique:user_details,user_id',
             '*.email_id' => 'required|unique:user_details,email_id',
             '*.password' => 'required|string',
             '*.status' => 'required|string',
             '*.created_at' => 'required|date_format:Y-m-d H:i:s',
             '*.updated_at' => 'required|date_format:Y-m-d H:i:s',
        ])->validate();

        

    }



    private function prepareDataForValidation(Collection $rows)
    {
        return $rows->map(function ($row) {
            // Example: Transform and prepare each row for validation
            
                $row['created_at'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['created_at'])->format('Y-m-d H:i:s');
                $row['updated_at'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['updated_at'])->format('Y-m-d H:i:s');
                // Add more columns as needed
                return $row;
        });
        
    }
/*
    public function prepareForValidation($data, $index)
    {
        //Fix that Excel's numeric date (counting in days since 1900-01-01)
        $data['created_at'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['created_at'])->format('Y-m-d H:i:s');
        $data['updated_at'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['updated_at'])->format('Y-m-d H:i:s');
        //...
    }


    public function rules(): array
    {
        return [

             // Above is alias for as it always validates in batches
             '*.user_id' => 'required|numeric|unique:user_details,user_id',
             '*.email_id' => 'required|unique:user_details,email_id',
             '*.password' => 'required|numeric',
             '*.status' => 'required|string',
             '*.created_at' => 'required|date_format:Y-m-d H:i:s',
             '*.updated_at' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
*/


}
