<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\YourModel; // Import your model
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;

HeadingRowFormatter::default('none');


class UserImport implements   WithMultipleSheets
{
    use Importable;

    public function sheets(): array
    {
        $a = [
            'user_details' => new UserDetailImport(),
            'user_log_details' => new UserLogImport(),
        ];

        return $a;
    }

    
    
    // public function model(array $row)
    // {
    //     dd($row);
    //    // return [];
    //     // Define how each row should be imported into your model
        
    //     // return [];
    //     return new YourModel([
    //         'text' => $row[0],
    //         'duplex' => $row[1],
    //         "updated_at" => date("Y-m-d H:i:s"),
    //         "created_at" => date("Y-m-d H:i:s"),
    //         // Map Excel columns to your model attributes
    //     ]);
    // }
}
