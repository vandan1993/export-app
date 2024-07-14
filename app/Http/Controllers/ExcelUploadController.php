<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport; // Import your Excel import class

class ExcelUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx|max:2048', // max:2048 = 2MB
        ]);

        if ($request->file('excel_file')->isValid()) {
            $file = $request->file('excel_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads', $fileName);

            // Process the uploaded Excel file
            Excel::import(new ExcelImport, storage_path('app/uploads/' . $fileName));

            // Optionally, store file details in database or perform other actions
            // ...

            return redirect()->back()->with('success', 'Excel file uploaded and processed successfully.');
        }

        return redirect()->back()->with('error', 'Invalid Excel file upload.');
    }
}
