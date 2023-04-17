@extends('layouts.base')

@section('title', 'Create')

@section('main')
    <div class="col-md-5">
        <div class="border p-3">
            <div class="fs-5 mb-3">Add employee</div>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <label for="photo" class="fw-bold mb-1">Photo</label>
                    <input type="file" class="form-control-file" id="photo" name="photo" style="display: none;">
                    <div>
                        <label class="btn btn-outline-secondary w-50" for="photo">Browse</label>
                    </div>
                    <div class="text-muted">
                        File format jpg, png up to 5MB, the minimum size of 300x300px
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="name" class="fw-bold mb-1">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Albert Einstein"
                           required>
                    <div id="nameLength" class="text-muted text-end"></div>
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
                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="+380 (50) 458 15 47"
                           required>
                    <div class="text-muted text-end">Required format +380 (xx) XXX XX XX</div>
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="fw-bold mb-1">Email</label>
                    <input type="email" id="email" name="email" class="form-control"
                           placeholder="alberteinstein@gmail.com" required>
                </div>

                <div class="form-group mb-3">
                    <label for="position" class="fw-bold mb-1">Position</label>
                    <div>
                        <select id="position" name="position">
                            @foreach($positions as $position)
                                <option value="{{ $position->name }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="salary" class="fw-bold mb-1">Salary, $</label>
                    <input type="number" id="salary" name="salary" class="form-control" placeholder="500,000" required>
                </div>

                <div class="form-group mb-3">
                    <label for="head" class="fw-bold mb-1">Head</label>
                    <input type="text" class="form-control" id="head" name="head" placeholder="Frederick Banting"
                           required>
                </div>

                <div class="form-group mb-3">
                    <label for="date_of_employment" class="fw-bold mb-1">Date of Employment</label>
                    <input type="date" class="form-control" id="date_of_employment" name="date_of_employment"
                           required>
                </div>

                <div class="text-end">
                    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary mx-2 w-25">Cancel</a>
                    <a href="{{ route('employees.store') }}" class="btn btn-secondary mx-2 w-25">Save</a>
                </div>
            </form>
        </div>
    </div>
@endsection
