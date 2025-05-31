@extends('layouts.master')
@section('title', 'Customers Cridits')

@section('content')
<div class="container-fluid py-4">
    {{-- Header Section with updated styling --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h4 mb-1">Customer Management</h1>
                        <p class="text-muted mb-0">Total customers: <span class="fw-bold">{{ $customers->count() }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alerts with updated styling --}}
    @if(session('success'))
        <div class="alert border-start border-success border-4 bg-light mb-4" role="alert">
            <i class="fas fa-check-circle text-success me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert border-start border-danger border-4 bg-light mb-4" role="alert">
            <i class="fas fa-exclamation-circle text-danger me-2"></i>{{ session('error') }}
        </div>
    @endif

    {{-- Main Content Card --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table" id="customersTable">
                            <thead>
                                <tr class="bg-light">
                                    <th class="border-0">Name</th>
                                    <th class="border-0">Email</th>
                                    <th class="border-0">Credit Balance</th>
                                    <th class="border-0 text-end">Add Balance</th>
                                    <th class="border-0 text-end">Reset Balance</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $user)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                {{ $user->name }}
                                            </div>
                                        </td>
                                        <td class="align-middle">{{ $user->email }}</td>
                                        <td class="align-middle">
                                            <span class="px-2 py-1 bg-light rounded-pill">
                                                ${{ number_format($user->customer->credit, 2) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-end">
                                            @can('add_credit')
                                                <form action="{{ route('customers.add_credit', $user->customer->id) }}" 
                                                      method="post" 
                                                      class="d-flex align-items-center justify-content-end gap-2">
                                                    @csrf
                                                    <div class="input-group input-group-sm" style="width: 150px;">
                                                        <span class="input-group-text border-0 bg-light">$</span>
                                                        <input type="number" 
                                                               class="form-control border-0 bg-light" 
                                                               name="amount" 
                                                               min="0.01" 
                                                               step="0.01" 
                                                               placeholder="Amount"
                                                               required>
                                                    </div>
                                                    <button type="submit" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-plus-circle me-1"></i>Add
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                        <td class="align-middle text-end">
                                          @can('add_credit')
                                              <form action="{{ route('customers.reset_credit', $user->customer->id) }}" 
                                                    method="post" 
                                                    class="d-flex align-items-center justify-content-end gap-2">
                                                  @csrf
                                                  <button type="submit" class="btn btn-outline-primary btn-sm">
                                                      <i class="fas fa-plus-circle me-1"></i>Reset
                                                  </button>
                                              </form>
                                          @endcan
                                      </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <p class="text-muted mb-0">No customers found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
