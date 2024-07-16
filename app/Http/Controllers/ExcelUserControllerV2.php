<?php

namespace App\Http\Controllers;

use App\Exports\ExportUserDetails;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport; // Import your Excel import class
use App\Imports\ImportUserData;
use App\Imports\UserImport;
use App\Models\UserDetails;
use App\Traits\ImportUserExcel;
use Exception;
use Illuminate\Auth\Events\Validated;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Collection;


class ExcelUserControllerV2 extends Controller
{
    use ImportUserExcel;

    private function verifyFile($fileName) {

        #Headers
            $arr = ['status' => true , "message" => "" ,  "data" => [] ,  "error" => []]; 
            $headings = (new HeadingRowImport)->toArray(storage_path('app/uploads/' . $fileName));
            $userDetailsStatus = $this->checkHeaders('user_details' , $headings[0][0]);
            $userDetailsLogStatus =  $this->checkHeaders('user_log_details' , $headings[1][0]);

            if($userDetailsStatus == false){
                return ['status' => false ,  "message" => "Validation Error" , "data" => [] , "error" => ["Invalid User Detail Sheet Header."]]; 
            }

            if($userDetailsLogStatus == false){
                return ['status' => false ,  "message" => "Validation Error" , "data" => [] ,  "error" => ["Invalid User Detail Log Sheet Header."]]; 
            }

        #Count & data
            $mincountUd = 1;
            $mincountUdl = 1;
            $collection =  (new ImportUserData())->toCollection(  storage_path('app/uploads/' . $fileName) );
            $countUd = $collection['user_details']->count();    
            $countUdl = $collection['user_log_details']->count();
            if($countUd < $mincountUd){
                return ['status' => false ,   "message" => "Validation Error" , "data" => [] ,  "error" => ["Atleast Count of {$mincountUd} users should be in User Detail Sheet."]]; 
            }

            if($countUdl < $mincountUdl){
                return ['status' => false ,    "message" => "Validation Error" , "data" => [] ,  "error" => ["Atleast Count of {$mincountUdl} users should be in User Detail Log Sheet."]]; 
            }
            
            $vdata = $this->validateFileData($collection['user_details'] , $this->getRules('user_details'));
            if($vdata['status'] == false){
                return $vdata; 
            }else{
                $arr['data']['user_details'] = $vdata['data'];
            }

            $vdata = $this->validateFileData($collection['user_log_details'] , $this->getRules('user_log_details') );
            if($vdata['status'] == false){
                return $vdata; 
            }else{
                $arr['data']['user_log_details'] = $vdata['data'];
            }

            return $arr;
    }


    public function upload(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx|max:2048', // max:2048 = 2MB
        ]);

        if ($request->file('excel_file')->isValid()) {
            try {

            $file = $request->file('excel_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName);

            $arr = $this->verifyFile($fileName);
            if($arr['status'] == false){
                return redirect()->back()->withErrors($arr['error']);
            }

            $import = (new ImportUserData())->import(  storage_path('app/uploads/' . $fileName) );

            // Process the uploaded Excel file
           // Excel::import($import->sheets(), storage_path('app/uploads/' . $fileName));

        } catch(Exception $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

            return redirect()->back()->with('success','Excel file uploaded and processed successfully.');
        }

        return redirect()->back()->withErrors(['Invalid Excel file upload.']);
    }


    public function export(){
        
        return (new ExportUserDetails)->download('users.xlsx');
    }


    public function list()  {
        $users = UserDetails::paginate(10);
        return view('list', ['users' => $users]);


    }

}