@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Products') }} <a class="btn btn-primary" href="{{ route('products.index') }}" style="float: right"> Back</a> </div>

                <div class="card-body">
                <form action="@if(isset($product)) {{route('products.update', $product)}} @else {{ route('products.store') }} @endif" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        @csrf
                        @if(isset($product))
                          @method('PUT')
                        @endif
                        <label for="category">Category *</label><br>
                        <select class="form-control" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', @$product->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>

                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <label for="name">Name *</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', @$product->name) }}"/>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <label for="price">Price *</label>
                        <input type="text" class="form-control" name="price" value="{{ old('price', @$product->price) }}"/>
                        @error('price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <input type="file" class="form-control" name="image" id="image"/>
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @if(Route::currentRouteName() == "products.edit")
                          <img src="{{ asset('images/'.$product->image)}}" class="img-thumbnail" width="100" />
                        @endif
                    </div>
                    <br>
                  <button type="submit" class="btn btn-block btn-primary">{{ (isset($product)) ? 'Update Product' : 'Add Product' }}</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

