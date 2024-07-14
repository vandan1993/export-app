<?php
namespace App\Exports\Sheets;

use App\Models\UserDetails;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class UserSheets implements FromQuery , WithTitle , WithHeadings
{
    public function headings(): array
    {
        return [
            'user_id', 'name', 'email id' ,'password' , 'status' , 'created_at' , 'updated_at'
        ];
    }

    /**
     * @return array
     */
    public function query()
    {
        return UserDetails::query()
                ->select('user_id' , 'email' , 'name' . 'password' ,'status' , 'user_created_at' , 'user_updated_at');
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Users';
    }
}
