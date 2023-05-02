@extends('layouts.base')

@section('title', 'Document')
@section('head', 'Employees')

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.13/dist/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

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
                            if (!data) {
                                return 'Photo missing';
                            }
                            if (typeof data === 'string' && data.startsWith('http')) {
                                // If it's a remote URL, return an <img> element with the URL as the src attribute
                                return '<img src="' + data + '" alt="' + full.name + '" width="50" height="50"/>';
                            } else {
                                // If it's a local file, generate the full URL to the photo using the asset() helper function
                                let url = "{{ asset('storage/photos/:filename') }}".replace(':filename', data);

                                // Return an <img> element with the photo URL as the src attribute
                                return '<img src="' + url + '" alt="' + full.name + '" width="50" height="50"/>';
                            }
                        }
                    },
                    {data: 'name'},
                    {
                        data: 'position.name',
                        render: function (data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'date_of_employment',
                        render: function (data) {
                            return moment.utc(data.date).format('DD.MM.YYYY');
                        }
                    },
                    {data: 'phone_number'},
                    {data: 'email'},
                    {
                        data: 'salary',
                        render: function (data) {
                            return '$' + Number(data).toLocaleString('en-US');
                        }
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return '<a href="{{ route("employees.edit", ":id") }}'.replace(':id', row.id) + '" class="btn btn-sm btn-outline-secondary mr-1 edit-btn"><i class="fas fa-pencil-alt"></i></a>' +
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
