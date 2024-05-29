@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="" style="text-align: left; margin-bottom:20px;"><h5> Releases </h5></div> 
        <div class="" style="text-align: right; margin-bottom:20px;"><a href="/create-release" class="btn btn-primary btn-sm text-gray-500">Create New Release</a></div>
            <div class="card">
                <div class="">
                <table class="pb-3 table text-left w-full data_table">
                <thead class="bg-gray-800 p text-gray-200 thead-dark">
                    <tr>
                        <th width="15%"> Name</th>
                        <th width="15%"> Story</th>
                        <th width="10%"> Company</th>
                        <th width="10%"> Type</th>
                        <th width="10%"> Distillery</th>
                        <th width="10%"> Merchant</th>
                        <th width="10%"> Brand</th>
                       <!--  <th width="10%">Release Publication Date</th> -->
                        <th width="10%"> Logo</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($releaselist) > 0)
                    @foreach($releaselist as $key=> $releases)
                    <tr class="border-b">
                        <td>{{ $releases->release_name}}</td>
                        <td>{{ substr($releases->release_story, 0, 20)."..." }}</td>
                        <td>{{$releases->company_name}}</td>
                        <td>{{$releases->other_type}}</td>
                        <td> 
                                @if(isset($releases->other_type))
                                    @if($releases->other_type=="Distillery")
                                        {{$releases->type_name}}
                                        @else
                                        N/A 
                                    @endif
                                @endif
                           </td>
                        <td>   @if(isset($releases->other_type))
                                    @if($releases->other_type=="Merchant")
                                        {{$releases->type_name}}
                                        @else
                                        N/A
                                    @endif
                                @endif</td>
                                <td>   @if(isset($releases->other_type))
                                    @if($releases->other_type=="Brand")
                                    {{$releases->type_name}}
                                    @else
                                    N/A
                                    @endif
                                @endif</td>
                      <!--   <td>{{$releases->publication_date}}</td> -->
                        <td>
                            @if($releases->release_logo=="")
                        @else
                        <img src="{{ URL::to('/images')}}/{{$releases->release_logo}}" height="50px" width="50px"/>
                        @endif</td>
                        <td><div style="display: flex;"><a class="btn btn-primary btn-sm text-gray-500 m-1" href="/edit-release/{{$releases->release_id}}">Edit</a>
                        <form action="{{ route('release.destroy', $releases->release_id) }}" method="POST">
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
                        <td colspan="8">No Release record found</td>
                    </tr>
                    @endif

                </tbody>
            </table>
            <div class="pagination">
            {{$releaselist->links()}}
            </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  

   
    function deleletconfig(){
        var del = confirm("Are you sure you want to delete the Catalog account ?");
        if (del == true) {
            alert("catlog record status is deleted successfully")
        }
        return del;
    }
</script>
@endsection
