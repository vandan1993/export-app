<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport; // Import your Excel import class
use App\Imports\UserImport;
use Exception;
use Maatwebsite\Excel\HeadingRowImport;

class ExcelUserController extends Controller
{
    //

    private function getHeaders($case)
    {   
        $arr = [];
        switch ($case) {
            case 'user_details':
                $arr =  ["user_id" , "name" , "email_id" , "password" , "status" , "created_at" , "updated_at"];
                break;
            
            case 'user_details_log':
                $arr = ["user_id" , "action_performed" , "status" , "created_at" , "updated_at"];
                break;
        }

        return $arr;

    }

    private function checkHeaders($case , $header_row){
        $status = true;
        $headers = $this->getHeaders($case);
        foreach ($headers as $head) {
            if(!in_array($head , $header_row)){
                $status = false;
                break;
            }
        }

        return $status;
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

            // $v = (new UserImport)->sheets();
            // dd($v);
            $headings = (new HeadingRowImport)->toArray(storage_path('app/uploads/' . $fileName));

            $userDetailsStatus = $this->checkHeaders('user_details' , $headings[0][0]);

            $userDetailsLogStatus =  $this->checkHeaders('user_details_log' , $headings[1][0]);

            if($userDetailsStatus == false){
                return redirect()->back()->with('error', 'Invalid User Detail Sheet Header.');
            }

            if($userDetailsLogStatus == false){
                return redirect()->back()->with('error', 'Invalid User Detail Log Sheet Header.');
            }
            //$new_import = new UserImport();
            $import = (new UserImport())->toCollection(  storage_path('app/uploads/' . $fileName) );
            dd($import);
            //dd($import->sheets());

            // Process the uploaded Excel file
           // Excel::import($import->sheets(), storage_path('app/uploads/' . $fileName));

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            dd($failures);
            
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
            // Optionally, store file details in database or perform other actions
            // ...
        }catch(Exception $e){
            dd($e);
        }

            return redirect()->back()->with('success', 'Excel file uploaded and processed successfully.');
        }

        return redirect()->back()->with('error', 'Invalid Excel file upload.');
    }
}