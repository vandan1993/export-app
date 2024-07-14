<?php
namespace App\Exports;

use App\Exports\Sheets\UserLogsSheets;
use App\Exports\Sheets\UserSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportUserDetails implements WithMultipleSheets
{
    use Exportable;

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new UserSheets;
        $sheets[] = new UserLogsSheets;

        return $sheets;
    }
}
