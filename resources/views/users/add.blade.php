@extends('layouts.master')
@section('title', 'Create User')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h4 class="mb-0">Create New User</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('users_store') }}" method="post">
                        @csrf

                        @if(session('error'))
                            <div class="alert border-start border-danger border-4 bg-light mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle text-danger me-2"></i>
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif

                        @foreach($errors->all() as $error)
                            <div class="alert border-start border-danger border-4 bg-light mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle text-danger me-2"></i>
                                    {{ $error }}
                                </div>
                            </div>
                        @endforeach

                        <div class="mb-4">
                            <label class="form-label text-muted">Name</label>
                            <input type="text" 
                                   class="form-control bg-light border-0" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Enter user name"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted">Email</label>
                            <input type="email" 
                                   class="form-control bg-light border-0" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Enter email address"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted">Password</label>
                            <input type="password" 
                                   class="form-control bg-light border-0" 
                                   name="password" 
                                   placeholder="Enter password"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted">Confirm Password</label>
                            <input type="password" 
                                   class="form-control bg-light border-0" 
                                   name="password_confirmation" 
                                   placeholder="Confirm password"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted">Roles</label> (<a href='#' id='clean_roles'>reset</a>)
                            <select multiple class="form-select bg-light border-0" id='roles' name="roles[]" required>
                                @foreach($roles as $role)
                                <option value='{{ $role->name }}'>
                                    {{ $role->name }}
                                </option>
                                @endforeach
                            </select>
                            <div class="form-text">Hold Ctrl/Cmd to select multiple roles</div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-2">Create User</button>
                            <a href="{{ route('users') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
