<?php

namespace App\Imports;

use App\Models\UserDetails;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportUserDetails implements ToModel , WithHeadingRow ,  WithBatchInserts, WithChunkReading
{
    public function model(array $row)
    {
        return new UserDetails([
            'user_id' => $row['user_id'],
            'email' => $row['email_id'],
            'name' => $row['name'],
            'password' => Hash::make('password'),
            'status' => $row['status'],
            'user_created_at' =>  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['created_at'])->format('Y-m-d H:i:s'),
            'user_updated_at' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['updated_at'])->format('Y-m-d H:i:s'),
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
