@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Products') }}</div>

                <div class="card-body">
                    {{-- @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif --}}

                    <h2>Product List</h2>
                    <a class="btn btn-success" href="{{ route('products.create') }}" style="float: right"> Create New Product</a>
                    <br><br>
                    <table class="table table-bordered">
                        <tr>
                            <th>Sr No</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($products as $key => $product)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $product->name }}</td>
                                <td><img src="{{ asset('images/'.$product->image)}}" alt="Image" width="50" height="50" /></td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{ route('products.show', $product->id) }}">Show</a>
                                    <a class="btn btn-primary btn-sm" href="{{ route('products.edit',$product->id) }}">Edit</a>
                                    <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$product->id}}')">Delete</a>
                                    <form id="delete-product-{{$product->id}}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    {{ $products->links('pagination::bootstrap-4') }} <!-- Display pagination links -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript">
	function confirmDelete(id){
        let choice = confirm("Are you sure, You want to delete this record ?")
        if(choice){
          document.getElementById('delete-product-'+id).submit();
        }
    }
</script>
