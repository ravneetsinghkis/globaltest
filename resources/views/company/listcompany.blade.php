@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="" style="text-align: left; margin-bottom:20px;"><h5> Company </h5></div>   
        <div class="" style="text-align: right; margin-bottom:20px;"><a href="/create-company" class="btn btn-primary btn-sm text-gray-500">Create New Company</a></div>
            <div class="card">
                <div class="">
                <table class="pb-3 table text-left w-full data_table">
                <thead class="bg-gray-800 p text-gray-200 thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Logo</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($product) > 0)
                    @foreach($product as $products)

                    <tr class="border-b">
                        <td>{{$products->name}}</td>
                        <td>{{ substr($products->description, 0, 20)."..." }}</td>
                        <td>@if($products->logo=="")
                            @else
                            <img src="{{ URL::to('/images')}}/{{$products->logo}}" height="50px" width="50px"/>
                            @endif</td>
                        <td>{{$products->email}}</td>
                        <td style="display: flex;"><a class="btn btn-primary btn-sm text-gray-500 m-1" href="/list-brands/?company_id={{$products->id}}">Brands</a><a class="btn btn-primary btn-sm text-gray-500 m-1" href="/list-distillery/?company_id={{$products->id}}">Distillery</a><a class="btn btn-primary btn-sm text-gray-500 m-1" href="/list-merchant/?company_id={{$products->id}}">Merchant</a><a class="btn btn-primary btn-sm text-gray-500 m-1" href="/edit-company/{{$products->id}}">Edit</a>
                        <form action="{{ route('company.destroy', $products->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return deleletconfig();" class="text-gray-500 btn btn-danger btn-sm m-1">Delete</button>
                        </form>
                        </td>
                    <tr>
                        @endforeach
                        @else
                    <tr class="text-center">
                        <td colspan="5">No Users record found</td>
                    </tr>
                    @endif

                </tbody>
            </table>
            <div class="pagination">
            {{ $product->links() }}
            </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  

   
    function deleletconfig(){
        var del = confirm("Are you sure you want to delete the company account ?");
        if (del == true) {
            alert("Company record status is deleted successfully")
        }
        return del;
    }
</script>
@endsection
