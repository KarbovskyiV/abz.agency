@extends('layouts.base')

@section('title', 'Edit')
@section('head', 'Employees')

@push('js')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
@endpush
@section('main')
    <div class="col-md-5">
        <div class="border p-3">
            <div class="fs-5 mb-3">Employee edit</div>
            <form action="{{ route('employees.update', $employee->id) }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group mb-3">
                    <label for="photo" class="fw-bold mb-1">Photo</label>
                    <div class="my-2">
                        @if ($employee->photo)
                            @if (str_starts_with($employee->photo, 'http'))
                                <!-- Photo with absolute URL -->
                                <img src="{{ $employee->photo }}" alt="{{ $employee->name }}" width="300" height="300">
                            @else
                                <!-- Local photo -->
                                <img src="{{ Storage::url('photos/' . $employee->photo) }}" alt="{{ $employee->name }}"
                                     width="300" height="300">
                            @endif
                        @else
                            <!-- Placeholder image -->
                            <img src="{{ asset('img/placeholder.png') }}" alt="Placeholder" width="300" height="300">
                        @endif
                    </div>
                    <input type="file" class="form-control-file" id="photo" name="photo"
                           style="display: none;">
                    <div>
                        <label class="btn btn-outline-secondary w-50" for="photo">Upload photo</label>
                    </div>
                    <div class="text-muted">
                        File format jpg, png up to 5MB, the minimum size of 300x300px
                    </div>
                    @if ($errors->has('photo'))
                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="name" class="fw-bold mb-1">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $employee->name }}"
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

                <div class="form-group mb-3">
                    <label for="phone" class="fw-bold mb-1">Phone</label>
                    <input type="tel" id="phone_number" name="phone_number" class="form-control"
                           placeholder="+380 (50) 458 15 47"
                           value="{{ $employee->phone_number }}">
                    <div class="text-muted text-end">Required format +380 (xx) XXX XX XX</div>
                    @if ($errors->has('phone_number'))
                        <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="fw-bold mb-1">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $employee->email }}"
                           placeholder="alberteinstein@gmail.com">
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="position" class="fw-bold mb-1">Position</label>
                    <div>
                        <select id="position" name="position">
                            @foreach($positions as $position)
                                <option
                                    value="{{ $position->name }}" {{ $employee->position->name === $position->name ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('position'))
                        <span class="text-danger">{{ $errors->first('position') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="salary" class="fw-bold mb-1">Salary, $</label>
                    <input type="number" id="salary" name="salary" class="form-control" value="{{ $employee->salary }}"
                           placeholder="500,000">
                    @if ($errors->has('salary'))
                        <span class="text-danger">{{ $errors->first('salary') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="head" class="fw-bold mb-1">Head</label>
                    <input type="text" id="head" name="head" class="form-control"
                           value="{{ $employee->supervisor?->name }}"
                           placeholder="Frederick Banting">
                    @if ($errors->has('head'))
                        <span class="text-danger">{{ $errors->first('head') }}</span>
                    @endif
                </div>

                <script>
                    $(function () {
                        let heads_name = {!! json_encode($heads_name) !!};
                        $("#head").autocomplete({
                            source: heads_name
                        });
                    });
                </script>

                <div class="form-group mb-3">
                    <label for="date_of_employment" class="fw-bold mb-1">Date of Employment</label>
                    <input type="text" class="form-control" id="date_of_employment" name="date_of_employment"
                           value="{{ $employee->date_of_employment->format('d.m.Y') }}">
                    @if ($errors->has('date_of_employment'))
                        <span class="text-danger">{{ $errors->first('date_of_employment') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3 d-flex justify-content-between">
                    <div>
                        <strong>Created at:</strong> {{ $employee->created_at->format('d.m.Y') }}
                    </div>
                    <div>
                        <strong>Admin created ID:</strong> {{ $employee->admin_created_id }}
                    </div>
                </div>

                <div class="form-group mb-3 d-flex justify-content-between">
                    <div>
                        <strong>Updated at:</strong> {{ $employee->updated_at->format('d.m.Y') }}
                    </div>
                    <div>
                        <strong>Admin updated ID:</strong> {{ $employee->admin_updated_id }}
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary mx-2 w-25">Cancel</a>
                    <button class="btn btn-secondary mx-2 w-25">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
