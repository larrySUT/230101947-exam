@extends('layouts.master')
@section('title', 'Edit User')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h4 class="mb-0">Edit User Profile</h4>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('users_save', $user->id) }}" method="post">
                        @csrf
                        
                        @if($errors->any())
                            <div class="alert border-start border-danger border-4 bg-light mb-4">
                                @foreach($errors->all() as $error)
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        {{ $error }}
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="form-label text-muted">Name</label>
                            <input type="text" 
                                   class="form-control bg-light border-0" 
                                   name="name" 
                                   value="{{ $user->name }}" 
                                   required>
                        </div>

                        @can('admin_users')
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label text-muted mb-0">Roles</label>
                                    <button type="reset" class="btn btn-link btn-sm text-decoration-none p-0">
                                        <i class="fas fa-undo-alt me-1"></i>Reset
                                    </button>
                                </div>
                                <select multiple 
                                        class="form-select bg-light border-0" 
                                        name="roles[]"
                                        size="4">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $role->taken ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label text-muted mb-0">Direct Permissions</label>
                                    <button type="reset" class="btn btn-link btn-sm text-decoration-none p-0">
                                        <i class="fas fa-undo-alt me-1"></i>Reset
                                    </button>
                                </div>
                                <select multiple 
                                        class="form-select bg-light border-0" 
                                        name="permissions[]"
                                        size="6">
                                    @foreach($permissions as $permission)
                                        <option value="{{ $permission->name }}" {{ $permission->taken ? 'selected' : '' }}>
                                            {{ $permission->display_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endcan

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-undo me-2"></i>Reset All
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
