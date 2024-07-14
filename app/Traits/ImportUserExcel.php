<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

trait ImportUserExcel
{
    private function getHeaders($case)
    {   
        $arr = [];
        switch ($case) {
            case 'user_details':
                $arr =  ["user_id" , "name" , "email_id" , "password" , "status" , "created_at" , "updated_at"];
                break;
            
            case 'user_log_details':
                $arr = ["user_id" , "action_performed" , "status" , "created_at" , "updated_at"];
                break;
        }

        return $arr;

    }

    private function checkHeaders($case , $header_row){
        $status = true;
        $headers = $this->getHeaders($case);
        if(empty($headers)){
            $status  = false;
        }
        foreach ($headers as $head) {
            if(!in_array($head , $header_row)){
                $status = false;
                break;
            }
        }

        return $status;
    }

    private function getRules($case){
        if($case == "user_details"){
               return  [
                    '*.user_id' => 'required|numeric|unique:user_details,user_id',
                    '*.email_id' => 'required|unique:user_details,email_id',
                    '*.password' => 'required|string',
                    '*.status' => 'required|string',
                    '*.created_at' => 'required|date_format:Y-m-d H:i:s',
                    '*.updated_at' => 'required|date_format:Y-m-d H:i:s',
               ];
        }else if($case == "user_log_details"){
           return [
               '*.user_id' => 'required|numeric', //exists:user_details,user_id
               '*.action_performed' => 'required|in:logout,login',
               '*.status' => 'required|in:successful,failed',
               '*.created_at' => 'required|date_format:Y-m-d H:i:s',
               '*.updated_at' => 'required|date_format:Y-m-d H:i:s',
           ];
        }
   }


   private function validateFileData(Collection $collection , array $rules){

    $arr = ['status' => true, "message" => "Success" , "data" => [] , "error" => []];
    $rows = $this->prepareDataForValidation($collection);
    $validator = Validator::make($rows->toArray(), $rules);
    
    if($validator->fails()){
         return ['status' => false , "message" => "Validation Error" , "data" => [] , "error" => $validator->errors()->all()];
    }

    $validatedData = $validator->validated();
    $arr['data'] = $validatedData;

    return $arr;
    //dd($validator);

}

private function prepareDataForValidation(Collection $rows)
{
    return $rows->map(function ($row) {
        // Example: Transform and prepare each row for validation
        
            $row['created_at'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['created_at'])->format('Y-m-d H:i:s');
            $row['updated_at'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['updated_at'])->format('Y-m-d H:i:s');
            // Add more columns as needed
            return $row;
    });
    
}
    
}

