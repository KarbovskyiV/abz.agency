@extends('layouts.base')

@section('title', 'Create')
@section('head', 'Positions')

@section('main')
    <div class="col-md-5">
        <div class="border p-3">
            <div class="fs-5 mb-3">Add position</div>
            <form action="{{ route('positions.store') }}" method="post">
                @csrf

                <div class="form-group mb-3">
                    <label for="name" class="fw-bold mb-1">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}"
                           placeholder="Leading specialist of the Control Department">
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

                <div class="text-end">
                    <a href="{{ route('positions.index') }}" class="btn btn-outline-secondary mx-2 w-25">Cancel</a>
                    <button class="btn btn-secondary mx-2 w-25">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
