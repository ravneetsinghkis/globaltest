@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="" style="text-align: left; margin-bottom:20px;"><h5> Distilleries </h5></div> 
        <div class="" style="text-align: right; margin-bottom:20px;"><a href="/create-distillery" class="destroy-session btn btn-primary btn-sm text-gray-500">Create New Distillery</a></div>
            <div class="card">
                <div class="">
                <table class="pb-3 table text-left w-full data_table">
                <thead class="bg-gray-800 p text-gray-200 thead-dark">
                    <tr>
                        <th> Name</th>
                        <th> Story</th>
                        <th> Company</th>
                        <th> Establishment</th>
                        <th> Logo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($distillerylist) > 0)
                    @foreach($distillerylist as $distillery)

                    <tr class="border-b">
                        <td>{{ substr($distillery->distillery_name, 0, 20)."..." }}</td>
                        <td>{{ substr($distillery->distillery_story, 0, 25)."..." }}</td>
                        <td> {{$distillery->company_name}}</td>
                        <td>{{$distillery->distillery_establishment}}</td>
                        <td>@if($distillery->distillery_logo=="")
                        @else
                        <img src="{{ URL::to('/images')}}/{{$distillery->distillery_logo}}" height="50px" width="50px"/>
                        @endif</td>
                        <td ><div style="display: flex;"><a class="btn btn-primary btn-sm text-gray-500 m-1" href="/list-brands/?distillery_id={{ $distillery->distillery_id }}">Brand</a><a class="btn btn-primary btn-sm text-gray-500 m-1" href="/edit-distillery/{{$distillery->distillery_id}}">Edit</a>
                        <form action="{{ route('distillery.destroy', $distillery->distillery_id) }}" method="POST" class="m-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return deleletconfig();" class="text-gray-500 btn btn-danger btn-sm">Delete</button>
                        </form>
</div>
                        </td>
                    <tr>
                        @endforeach
                        @else
                    <tr class="text-center">
                        <td colspan="7">No Distillery record found</td>
                    </tr>
                    @endif

                </tbody>
            </table>
            <div class="pagination">
            {{ $distillerylist->links() }}
</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  

   
    function deleletconfig(){
        var del = confirm("Are you sure you want to delete the Distillery account ?");
        if (del == true) {
            alert("Distillery record status is deleted successfully")
        }
        return del;
    }
</script>
@endsection
