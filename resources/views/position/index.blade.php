@extends('layouts.base')

@section('title', 'Document')
@section('head', 'Positions')

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
                'ajax': "{{ route('api.positions.index') }}",
                'columns': [
                    {data: 'name'},
                    {
                        data: 'updated_at',
                        render: function (data) {
                            return moment.utc(data.date).format('DD.MM.YYYY');
                        }
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return '<a href="{{ route("positions.edit", ":id") }}'.replace(':id', row.id) + '" class="btn btn-sm btn-outline-secondary mr-1 edit-btn"><i class="fas fa-pencil-alt"></i></a>' +
                                '<button class="btn btn-sm btn-outline-secondary mr-1 delete-btn"><i class="fas fa-trash"></i></button>';
                        }
                    },
                ]
            });

            $('#employees-table tbody').on('click', '.delete-btn', function () {
                let row = table.row($(this).closest('tr')).data();
                Swal.fire({
                    title: 'Remove position',
                    text: "Are you sure you want to remove position " + row.name + "?",
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
                            url: "{{ route('positions.destroy', ':id') }}".replace(':id', row.id),
                            type: 'DELETE',
                            data: {
                                id: row.id,
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data) {
                                Swal.fire(
                                    'Deleted!',
                                    'The position has been deleted.',
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
    <a href="{{ route('positions.create') }}" class="btn btn-xs btn-secondary">Add position</a>
@endsection

@section('main')
    <div class="border p-3">
        <div class="fs-5 mb-2">Position list</div>
        <table id="employees-table" class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Last update</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
