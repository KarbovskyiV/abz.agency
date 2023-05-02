@extends('layouts.base')

@section('title', 'Edit')
@section('head', 'Positions')

@push('js')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
@endpush
@section('main')
    <div class="col-md-5">
        <div class="border p-3">
            <div class="fs-5 mb-3">Position edit</div>
            <form action="{{ route('positions.update', $position->id) }}" method="post">
                @method('PUT')
                @csrf

                <div class="form-group mb-3">
                    <label for="name" class="fw-bold mb-1">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $position->name }}"
                           placeholder="Albert Einstein">
                    <div id="nameLength" class="text-muted text-end"></div>
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <script>
                    const nameInput = document.getElementById('name');
                    const nameLength = document.getElementById('nameLength');

                    nameInput.addEventListener('input', () => {
                        const length = nameInput.value.length;
                        nameLength.textContent = `${length} / 256`;
                    });
                </script>

                <div class="form-group mb-3 d-flex justify-content-between">
                    <div>
                        <strong>Created at:</strong> {{ $position->created_at->format('d.m.Y') }}
                    </div>
                    <div>
                        <strong>Admin created ID:</strong> {{ $position->admin_created_id }}
                    </div>
                </div>

                <div class="form-group mb-3 d-flex justify-content-between">
                    <div>
                        <strong>Updated at:</strong> {{ $position->updated_at->format('d.m.Y') }}
                    </div>
                    <div>
                        <strong>Admin updated ID:</strong> {{ $position->admin_updated_id }}
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('positions.index') }}" class="btn btn-outline-secondary mx-2 w-25">Cancel</a>
                    <button class="btn btn-secondary mx-2 w-25">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
