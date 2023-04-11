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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.13/dist/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            let table = $('#employees-table').DataTable({
                'processing': true,
                'serverSide': true,
                'ajax': "{{ route('api.employees.index') }}",
                'columns': [
                    {
                        data: 'photo',
                        render: function (data, type, full, meta) {
                            return '<img src="' + data + '" alt="' + full.name + '" width="50"/>';
                        }
                    },
                    {data: 'name'},
                    {data: 'position'},
                    {
                        data: 'date_of_employment',
                        render: function (data) {
                            let date = new Date(data);
                            let day = ('0' + date.getDate()).slice(-2);
                            let month = ('0' + (date.getMonth() + 1)).slice(-2);
                            let year = date.getFullYear();
                            return day + '.' + month + '.' + year;
                        }
                    },
                    {data: 'phone_number'},
                    {data: 'email'},
                    {data: 'salary'},
                    {
                        data: null,
                        render: function (data, type, row) {
                            return '<button class="btn btn-sm btn-outline-secondary mr-1 edit-btn"><i class="fas fa-pencil-alt"></i></button>' +
                                '<button class="btn btn-sm btn-outline-secondary mr-1 delete-btn"><i class="fas fa-trash"></i></button>';
                        }
                    },
                ]
            });

            $('#employees-table tbody').on('click', '.delete-btn', function () {
                let row = table.row($(this).closest('tr')).data();
                Swal.fire({
                    title: 'Remove employee',
                    text: "Are you sure you want to remove employee " + row.name + "?",
                    showCancelButton: true,
                    showCloseButton: true,
                    reverseButtons: true,
                    cancelButtonColor: '#cec9c9',
                    confirmButtonColor: 'gray',
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Remove',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('employees.destroy', ':id') }}".replace(':id', row.id),
                            type: 'DELETE',
                            data: {
                                id: row.id,
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                Swal.fire(
                                    'Deleted!',
                                    'The employee has been deleted.',
                                    'success'
                                );
                                table.draw();
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                });
            });
        });
    </script>

    <title>Document</title>

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
                    <button class="btn btn-dark text-white bi bi-people-fill">&nbsp;Employees</button>
                </li>
                <li class="list-group-item bg-dark text-white">
                    <button class="btn btn-dark text-white bi bi-book">&nbsp;Positions</button>
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
                <div class="card-header fs-3 d-flex justify-content-between align-items-center">
                    <span>Employees</span>
                    <form action="#" method="post">
                        <button name="add_employee" class="btn btn-xs btn-secondary">Add employee</button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="fs-5 mb-2">Employees list</div>
                    <table id="employees-table" class="table table-striped">
                        <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Date of employment</th>
                            <th>Phone number</th>
                            <th>Email</th>
                            <th>Salary</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
