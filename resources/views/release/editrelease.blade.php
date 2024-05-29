@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li style="color:red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
                <div class="">
                <form method="post" action="{{ route('release.update', $editreleases['id'])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                            <div class="card-body">
                                <table class="table table-bordered">
                                   <tr>
                                    <th>Release Title</th>
                                       <td><input class="form-control" id="name" name="name" type="text" value="{{$editreleases['name']}}" required /></td>
                                   </tr>
                                   <tr>
                                    <th>EAN</th>
                                       <td><input class="form-control" id="ean" name="ean" type="text" value="{{$editreleases['ean']}}" required /></td>
                                   </tr>
                                   <!-- <tr>
                                       <th>Type</th>
                                       <td colspan="3">
                                        <select class="form-control" name="release_type" id="release_type" >
                                        <option value="" >Type 1</option>
                                        <option value="">Type 2</option>
                                        </select>
                                       </td>
                                   </tr> -->
                                   <tr>
                                    <th>Publication date</th>
                                       <td><input class="form-control" id="publication_date" name="publication_date" type="text" value="{{$editreleases['publication_date']}}" required /></td>
                                   </tr>
                                   <tr>
                                       <th>Release Country</th>
                                       <td colspan="3">
                                        <select class="form-control" name="country" id="country">
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}" {{$editreleases['country']==$country->id ? 'selected': ''}}>{{$country->name}}</option>
                                        @endforeach
                                        </select>
                                       </td>
                                   </tr>
                                   <tr>
                                       <th>Release Region</th>
                                       <td colspan="3">
                                        <select class="form-control" name="region" id="region">
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" {{$editreleases['region']==$state->id ? 'selected': ''}}>{{$state->name}}</option>
                                        @endforeach
                                        </select>
                                       </td>
                                   </tr>
                                   <tr>
                                    <th>Price Band</th>
                                       <td colspan="3">
                                         <select class="form-control" name="price_band" id="price_band">
                                        <option value="100" {{$editreleases['price_band']=="100" ? 'selected': ''}}>100</option>
                                        <option value="200" {{$editreleases['price_band']=="200" ? 'selected': ''}}>200</option>
                                        <option value="300" {{$editreleases['price_band']=="300" ? 'selected': ''}}>300</option>
                                        <option value="400" {{$editreleases['price_band']=="400" ? 'selected': ''}}>400</option>
                                        <option value="500" {{$editreleases['price_band']=="500" ? 'selected': ''}}>500</option>
                                    </select>
                                       </td>
                                   </tr>
                                   <tr>
                                    <th>ABV</th>
                                       <td><input class="form-control" id="abv" name="abv" type="text" value="{{$editreleases['abv']}}" required /></td>
                                   </tr>
                                   <tr>
                                       <th>Release Story</th>
                                       <td> <textarea type="text" class="form-control" name="description" required>{{$editreleases['story']}}</textarea>
                                       </td>
                                   </tr>
                                   
                                   <tr >
                                       <th>Choose (Distillery/Merchants/Brands)  </th>
                                       <td colspan="3">
                                       <select class="form-control" name="other_option" id="other_option">
                                        <option value="Distillery" {{$editreleases['other_type']=="Distillery" ? 'selected': ''}}>Distillery</option>
                                        <option value="Merchant" {{$editreleases['other_type']=="Merchant" ? 'selected': ''}}>Merchant</option>
                                        <option value="Brand" {{$editreleases['other_type']=="Brand" ? 'selected': ''}}>Brand</option>
                                    </select>
                                       </td>
                                   </tr>
                                   <tr >
                                       <th>List of (Distillery/Merchants/Brands) </th>
                                       <td colspan="3">
                                       <select class="form-control" name="both_D_M" id="both_D_M">
                                        @foreach($other_types as $others)
                                        <option value="{{$others->id}}" {{$editreleases['category_id']==$others->id ? 'selected': ''}}>{{$others->name}}</option>
                                        @endforeach
                                        </select>
                                       </td>
                                   </tr>
                                 
                                   <tr>
                                       <th>Release Logo</th>
                                       <td><img src="{{ URL::to('/images')}}/{{$editreleases->logo}}" width="100px"><input class="form-control" id="releaselogo" name="releaselogo" type="file" value=""/></td>
                                   </tr>
                                   <tr>
                                       <th>Release Cover</th>
                                       <td><img src="{{ URL::to('/images')}}/{{$editreleases->cover}}" width="100px"><input class="form-control" id="releasecover" name="releasecover" type="file" value="" /></td>
                                   </tr>
                                   <tr>
                                       <th>Release gallery</th>
                                       <td><img src="{{ URL::to('/images')}}/{{$editreleases->gallery}}" width="100px"><input class="form-control" id="gallery" name="gallery" type="file" value=""/></td>
                                   </tr>
                                   <tr>
                                       <td colspan="4" style="text-align:center ;"><button type="submit" class="btn btn-primary btn-block" name="update">Update Release</button></td>

                                   </tr>
                                    </tbody>
                                </table>
                            </div>
                            </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        //$(".enable_disable").hide();
        var value=$("input#flexSwitchCheckDefault").val();
        if(value==1){
            $(".enable_disable").show();
        }else{
            $(".enable_disable").hide();
        }
        $("#flexSwitchCheckDefault").click(function () {
            if ($(this).is(":checked")) {
                $(".enable_disable").show();
                $("#flexSwitchCheckDefault").val('1');
            } else {
                $(".enable_disable").hide();
                $("#flexSwitchCheckDefault").val('0');
            }
        });
    })
     
</script>
@endsection
