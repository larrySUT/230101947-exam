@extends('layouts.master')
@section('title', 'Products')
@section('content')
<div class="row mt-2">
    <div class="col col-10">
        <h1>Products</h1>
    </div>
    <div class="col col-2">
        @can('add_products')
        <a href="{{route('products_edit')}}" class="btn btn-success form-control">Add Product</a>
        @endcan
    </div>
</div>
<form>
    <div class="row">
        <div class="col col-sm-2">
            <input name="keywords" type="text"  class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
        </div>
        <div class="col col-sm-2">
            <input name="min_price" type="numeric"  class="form-control" placeholder="Min Price" value="{{ request()->min_price }}"/>
        </div>
        <div class="col col-sm-2">
            <input name="max_price" type="numeric"  class="form-control" placeholder="Max Price" value="{{ request()->max_price }}"/>
        </div>
        <div class="col col-sm-2">
            <select name="order_by" class="form-select">
                <option value="" {{ request()->order_by==""?"selected":"" }} disabled>Order By</option>
                <option value="name" {{ request()->order_by=="name"?"selected":"" }}>Name</option>
                <option value="price" {{ request()->order_by=="price"?"selected":"" }}>Price</option>
                <option value="stock" {{ request()->order_by=="stock"?"selected":"" }}>Stock</option>
            </select>
        </div>
        <div class="col col-sm-2">
            <select name="order_direction" class="form-select">
                <option value="" {{ request()->order_direction==""?"selected":"" }} disabled>Order Direction</option>
                <option value="ASC" {{ request()->order_direction=="ASC"?"selected":"" }}>ASC</option>
                <option value="DESC" {{ request()->order_direction=="DESC"?"selected":"" }}>DESC</option>
            </select>
        </div>
        <div class="col col-sm-1">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <div class="col col-sm-1">
            <button type="reset" class="btn btn-danger">Reset</button>
        </div>
    </div>
</form>

@if(session('error'))
<div class="alert alert-danger mt-3">
    {{ session('error') }}
</div>
@endif

@foreach($products as $product)
    <div class="card mt-2">
        <div class="card-body">
            <div class="row">
                <div class="col col-sm-12 col-lg-4">
                    <img src="{{asset("images/$product->photo")}}" class="img-thumbnail" alt="{{$product->name}}" width="100%">
                </div>
                <div class="col col-sm-12 col-lg-8 mt-3">
                    <div class="row mb-2">
                        <div class="col-8">
                            <h3>{{$product->name}}</h3>
                        </div>
                        <div class="col col-2">
                            @can('edit_products')
                            <a href="{{route('products_edit', $product->id)}}" class="btn btn-success form-control">Edit</a>
                            @endcan
                        </div>
                        <div class="col col-2">
                            @can('delete_products')
                            <a href="{{route('products_delete', $product->id)}}" class="btn btn-danger form-control">Delete</a>
                            @endcan
                        </div>
                    </div>

                    <p>{{$product->description}}</p>
                    <div class="card bg-light border-0 mt-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="me-4">
                                            <h4 class="mb-0 text-primary">${{$product->price}}</h4>
                                        </div>
                                        <div class="vr mx-3"></div>
                                        <div>
                                            @if($product->stock > 0)
                                                <div class="d-flex align-items-center">
                                                    <div class="px-2 py-1 bg-success-subtle rounded-pill">
                                                        <i class="fas fa-box text-success me-1"></i>
                                                        <span class="text-success">{{$product->stock}} in stock</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="px-2 py-1 bg-danger-subtle rounded-pill">
                                                    <i class="fas fa-times-circle text-danger me-1"></i>
                                                    <span class="text-danger">Out of stock</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @auth
                                        @if(auth()->user()->hasRole('Customer') && $product->stock > 0)
                                            <form action="{{ route('products.purchase', $product->id) }}" method="post" class="d-flex justify-content-end">
                                                @csrf
                                                <div class="input-group" style="max-width: 200px;">
                                                    <input type="number" 
                                                           class="form-control border-end-0" 
                                                           name="quantity" 
                                                           min="1" 
                                                           max="{{ $product->stock }}" 
                                                           value="1" 
                                                           required>
                                                    <button class="btn btn-primary px-4" type="submit">
                                                        <i class="fas fa-shopping-cart me-2"></i>Buy
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
