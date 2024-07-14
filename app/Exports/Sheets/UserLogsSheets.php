<?php
namespace App\Exports\Sheets;

use App\Models\UserDetails;
use App\Models\UserDetailsLogs;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class UserLogsSheets implements FromQuery , WithTitle , WithHeadings
{

    public function headings(): array
    {
        return [
            'email id', 'count of successful login', 'count of unsuccessful login,' ,'count of successful logout' , 'count of unsuccessful logout' 
        ];
    }

    /**
     * @return array
     * 

     */
    public function query()
    {        
        return DB::table('user_details as u')
        ->join('user_details_logs as udl' , 'u.user_id' ,'udl.user_id')
        ->groupBy('udl.user_id')
        ->orderBy('udl.user_id')
        ->selectRaw("u.email ,
        COUNT(CASE WHEN action_performed = 'login' and udl.status = 'successful' THEN 1 END) AS apls,
        COUNT(CASE WHEN action_performed = 'login' and udl.status = 'failed' THEN 1 END) AS aplf,
        COUNT(CASE WHEN action_performed = 'logout' and udl.status = 'successful' THEN 1 END) AS aplos,
        COUNT(CASE WHEN action_performed = 'logout' and udl.status = 'failed' THEN 1 END) AS aplof");
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Users_Details_Logs';
    }
}
