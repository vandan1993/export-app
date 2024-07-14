<?php

namespace App\Imports;

use App\Models\UserDetailsLogs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportUserLogDetails implements ToModel , WithHeadingRow , WithBatchInserts, WithChunkReading
{
    public function model(array $row)
    {

        return new  UserDetailsLogs([

            'user_id' => $row['user_id'],
            'action_performed' => $row['action_performed'],
            'status' => $row['status'],
            'user_logs_created_at' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['created_at'])->format('Y-m-d H:i:s'),
            'user_logs_updated_at' =>  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['updated_at'])->format('Y-m-d H:i:s'),
        ]);
    }


    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
    
}
