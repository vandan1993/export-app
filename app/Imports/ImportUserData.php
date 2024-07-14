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

class ImportUserData implements   WithMultipleSheets
{
    use Importable;

    public function sheets(): array
    {
        $a = [
            'user_details' => new ImportUserDetails(),
            'user_log_details' => new ImportUserLogDetails(),
        ];

        return $a;
    }

}