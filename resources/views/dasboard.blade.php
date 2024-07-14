@extends('layouts.app')

@section('title', 'Dasboard')



@section('content')
    
    <div>

    <div class="">
        <a   class="btn btn-primary" href="{{route('download.user.excel')}}"> Export </a> 
    </div>
    
    <div class="sub_section">
        @if(Session::get('error')!= null)
            <div>
                <ul>
                    <li style="color: red;">{{Session::get('error')}}</li>
                </ul>
            </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger" style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (Session::get('success')!= null)
        <div class="alert alert-success" style="color: green;">
            <ul>
                
                    <li>{{ Session::get('success') }}</li>
            </ul>
        </div>
        @endif
    
        <h3>Import User Data</h3>
        <form method="POST" action="{{ route('upload.user.excel') }}" enctype="multipart/form-data">
            @csrf
            <div style="padding: 20px 5px; border:2px solid">
                <input  type="file" id="excel_file" name="excel_file" accept=".xls,.xlsx">
                <button class="btn btn-primary" type="submit" class ="upload_button">Upload</button>
            </div>
            

           
        </form>
    </div>

    </div>

    
@endsection

