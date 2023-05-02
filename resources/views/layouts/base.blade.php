<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.13/dist/sweetalert2.min.css">

    @stack('js')

    <title>@yield('title')</title>

</head>
<body>

<div class="container-fluid bg-dark px-0" style="overflow-x: hidden;">
    <div class="row">
        <div class="col-md-2">
            <ul class="list-group bg-white">
                <li class="list-group-item bg-dark text-white">
                    <button class="btn btn-dark text-white fs-4">List</button>
                </li>
                <li class="list-group-item bg-dark text-white">
                    <a href="{{ route('employees.index') }}" class="btn btn-dark text-white bi bi-people-fill">&nbsp;Employees</a>
                </li>
                <li class="list-group-item bg-dark text-white">
                    <a href="{{ route('positions.index') }}" class="btn btn-dark text-white bi bi-book">&nbsp;Positions</a>
                </li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="d-flex justify-content-end bg-secondary">
                <form action="#" method="post">
                    <button name="logout" class="btn btn-xs btn-secondary bi bi-box-arrow-right"></button>
                </form>
            </div>
            <div class="card">
                <div class="fs-3 d-flex justify-content-between align-items-center" style="margin-left: 15px;">
                    <span>@yield('head')</span>
                    @yield('button')
                </div>
                <div class="card-body">
                    @yield('main')
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
