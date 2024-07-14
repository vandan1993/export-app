<!-- layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
    <!-- Include CSS, JavaScript, or other assets -->
</head>
<body>

<div id="app">
        <!-- Sidebar -->
        <aside class="sidebar">
            <ul>
                <li><a href="/">Dashboard</a></li>
                <li><a href="/list">List Page</a></li>
                <!-- Add more sidebar links as needed -->
            </ul>
        </aside>

        <!-- Main Content -->
        <div id="main">

            
            <!-- Page Content -->
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>    
</body>
</html>
