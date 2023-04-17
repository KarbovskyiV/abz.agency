@extends('layouts.base')

@section('title', 'Document')

@push('js')
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
@endpush

@section('button')
    <a href="{{ route('employees.create') }}" class="btn btn-xs btn-secondary">Add employee</a>
@endsection

@section('main')
    <div class="border p-3">
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
@endsection
