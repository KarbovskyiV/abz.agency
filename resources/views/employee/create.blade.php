@extends('layouts.base')

@section('title', 'Create')
@section('head', 'Employees')

@section('main')
    <div class="col-md-5">
        <div class="border p-3">
            <div class="fs-5 mb-3">Add employee</div>
            <form action="{{ route('employees.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="photo" class="fw-bold mb-1">Photo</label>
                    <input type="file" class="form-control-file" id="photo" name="photo" style="display: none;">
                    <div>
                        <div class="my-2">
                            <img id="photo-preview" src="#" alt="Preview"
                                 style="display: none; min-width: 300px; min-height: 300px;">
                        </div>
                        <label class="btn btn-outline-secondary w-50" for="photo">Browse</label>
                    </div>
                    <div class="text-muted">
                        File format jpg, png up to 5MB, the minimum size of 300x300px
                    </div>
                    @if ($errors->has('photo'))
                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                    @endif
                </div>

                <script>
                    document.querySelector('#photo').addEventListener('change', function (e) {
                        const reader = new FileReader();
                        reader.onload = function () {
                            const preview = document.querySelector('#photo-preview');
                            preview.onload = function () {
                                if (this.width < 300 || this.height < 300) {
                                    alert('The photo must be at least 300x300 pixels.');
                                    document.querySelector('#photo').value = '';
                                    preview.style.display = 'none';
                                } else {
                                    preview.style.display = 'block';
                                }
                            }
                            preview.src = reader.result;
                        }
                        reader.readAsDataURL(e.target.files[0]);
                    });
                </script>

                <div class="form-group mb-3">
                    <label for="name" class="fw-bold mb-1">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}"
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
                           value="{{ old('phone_number') }}">
                    <div class="text-muted text-end">Required format +380 (xx) XXX XX XX</div>
                    @if ($errors->has('phone_number'))
                        <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="fw-bold mb-1">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}"
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
                                    value="{{ $position->name }}" {{ old('position') === $position->name ? 'selected' : '' }}>
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
                    <input type="number" id="salary" name="salary" class="form-control" value="{{ old('salary') }}"
                           placeholder="500,000">
                    @if ($errors->has('salary'))
                        <span class="text-danger">{{ $errors->first('salary') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="head" class="fw-bold mb-1">Head</label>
                    <input type="text" id="head" name="head" class="form-control" value="{{ old('head') }}"
                           placeholder="Frederick Banting">
                    @if ($errors->has('head'))
                        <span class="text-danger">{{ $errors->first('head') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="date_of_employment" class="fw-bold mb-1">Date of Employment</label>
                    <input type="date" class="form-control" id="date_of_employment" name="date_of_employment">
                    @if ($errors->has('date_of_employment'))
                        <span class="text-danger">{{ $errors->first('date_of_employment') }}</span>
                    @endif
                </div>

                <div class="text-end">
                    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary mx-2 w-25">Cancel</a>
                    <button class="btn btn-secondary mx-2 w-25">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
