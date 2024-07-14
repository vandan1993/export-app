<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\YourModel; // Import your model

class ExcelImport implements ToModel
{
    public function model(array $row)
    {
        // Define how each row should be imported into your model
        return new YourModel([
            'text' => $row[0],
            'duplex' => $row[1],
            "updated_at" => date("Y-m-d H:i:s"),
            "created_at" => date("Y-m-d H:i:s"),
            // Map Excel columns to your model attributes
        ]);
    }
}
