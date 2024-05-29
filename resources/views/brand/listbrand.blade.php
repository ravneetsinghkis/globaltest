@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="" style="text-align: left; margin-bottom:20px;"><h5> Brands </h5></div>   
        <div class="" style="text-align: right; margin-bottom:20px;"><a href="/create-brand" class="destroy-session btn btn-primary btn-sm text-gray-500">Create New Brand</a></div>
            <div class="card">
                <div class="">
                <table class="pb-3 table text-left w-full data_table">
                <thead class="bg-gray-800 p text-gray-200 thead-dark">
                    <tr>
                        <th width="10%"> Name</th>
                        <th width="20%"> Story</th>
                        <th width="10%"> Company</th>
                        <th width="10%"> Distillery</th>
                        <th width="10%"> Merchant</th>
                        <th width="10%"> Establishment</th>
                        <th width="10%"> Logo</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($brandlist) > 0)
                    @foreach($brandlist as $key=>$brands)
                    <tr class="border-b">
                        <td>{{$brands->brand_name}}</td>
                        <td>{{ substr($brands->brand_story, 0, 20)."..." }}</td>
                        <td>{{$brands->company_name}}</td>
                        <td> @if(isset($D_Merchant['data']))
                                @foreach($D_Merchant['data'] as $dm)
                                    @if(isset($dm['dm_type'][$key]))
                                        @if($dm['dm_type'][$key]=="Distillery")
                                            {{$dm['dm_name'][$key]}}
                                        @else
                                        N/A
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if(isset($D_Merchant['data'])) 
                                @foreach($D_Merchant['data'] as $dm)
                                    @if(isset($dm['dm_type'][$key]))
                                        @if($dm['dm_type'][$key]=="Merchant")
                                            {{$dm['dm_name'][$key]}}
                                        @else
                                        N/A
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td>{{$brands->brand_establishment}}</td>
                        <td>@if($brands->brand_logo=="")
                        @else
                        <img src="{{ URL::to('/images')}}/{{$brands->brand_logo}}" height="50px" width="50px"/>
                        @endif</td>
                        <td><div  style="display: flex;"><a class="btn btn-primary btn-sm text-gray-500 m-1" href="/edit-brand/{{$brands->brand_id}}">Edit</a>
                        <form action="{{ route('brand.destroy', $brands->brand_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return deleletconfig();" class="text-gray-500 btn btn-danger btn-sm m-1">Delete</button>
                        </form>
</div>
                        </td>
                    <tr>
                        @endforeach
                        @else
                    <tr class="text-center">
                        <td colspan="8">No Brand record found</td>
                    </tr>
                    @endif

                </tbody>
            </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function deleletconfig(){
    var del = confirm("Are you sure you want to delete this brand ?");
    if (del == true) {
        alert("Brand record status is deleted successfully")
    }
    return del;
}
</script>
@endsection
