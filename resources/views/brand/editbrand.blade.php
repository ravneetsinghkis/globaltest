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
                <form method="post" action="{{ route('brand.update', $editbrands['id'])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                            <div class="card-body">
                                <table class="table table-bordered">
                                   <tr>
                                    <th>Brand Name</th>
                                       <td><input class="form-control" id="name" name="name" type="text" value="{{$editbrands['name']}}" required /></td>
                                   </tr>
                                   <tr>
                                       <th>Brand Story</th>
                                       <td><input class="form-control" id="description" name="description" type="text" value="{{$editbrands['story']}}"  required /></td>
                                   </tr>
                                   <tr>
                                       <th>Brand Establishment Year</th>
                                       <td><select class="form-control" id="establishment" name="establishment"  required>
                                            {{ $now = date('Y') }}
                                            @for ($i = 1970; $i <= $now; $i++)
                                                <option value="{{ $i }}" {{$editbrands['establishment']== $i ?'selected': '' }}>{{ $i }}</option>
                                            @endfor
                                        </select></td>
                                   </tr>
                                   
                                   <tr>
                                       <th>Brand Company</th>
                                       <td colspan="3">
                                        <select class="form-control" name="company">
                                        @foreach($productCatalog as $catelog)
                                            <option value="{{$catelog->id}}" {{$editbrands['company_id']==$catelog->id ? 'selected': ''}}>{{$catelog->name}}</option>
                                        @endforeach
                                        </select>
                                       </td>
                                   </tr>
                                    <tr>
                                       <th>Brand Country</th>
                                       <td colspan="3">
                                        <select class="form-control" name="country_id" id="country">
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}" {{$editbrands['country']==$country->id ? 'selected': ''}}>{{$country->name}}</option>
                                        @endforeach
                                        </select>
                                       </td>
                                   </tr>
                                   <tr>
                                       <th>Brand Region</th>
                                       <td colspan="3">
                                        <select class="form-control" name="region" id="region">
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" {{$editbrands['region']==$state->id ? 'selected': ''}}>{{$state->name}}</option>
                                        @endforeach
                                        </select>
                                       </td>
                                   </tr>
                                   <tr>
                                       <th>Enable/Disable</th>
                                       <td colspan="3">
                                       <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_selected" id="flexSwitchCheckDefault" value="{{$editbrands['is_selected']}}" {{$editbrands['is_selected']=="1"?'checked':''}}>
                                            <label class="form-check-label" for="flexSwitchCheckDefault">(Distillery/Merchants)</label>
                                        </div>
                                       </td>
                                   </tr>
                                   @if($editbrands['is_selected']==1)
                                   <tr class="enable_disable">
                                       <th>Choose (Distillery/Merchants)  </th>
                                       <td colspan="3">
                                       <select class="form-control" name="other_option" id="other_option">
                                        <option value="Distillery" {{$editbrands['other_type']=="Distillery" ? 'selected': ''}}>Distillery</option>
                                        <option value="Merchant" {{$editbrands['other_type']=="Merchant" ? 'selected': ''}}>Merchant</option>
                                    </select>
                                       </td>
                                   </tr>
                                   <tr class="enable_disable">
                                       <th>List of (Distillery/Merchants) </th>
                                       <td colspan="3">
                                       <select class="form-control" name="both_D_M" id="both_D_M">
                                        @foreach($other_types as $others)
                                        <option value="{{$others->id}}" {{$editbrands['brand_DM']==$others->id ? 'selected': ''}}>{{$others->name}}</option>
                                        @endforeach
                                        </select>
                                       </td>
                                   </tr>
                                   @else
                                   <tr class="enable_disable">
                                       <th>Choose (Distillery/Merchants)  </th>
                                       <td colspan="3">
                                       <select class="form-control" name="other_option" id="other_option">
                                        <option value="Distillery" {{$editbrands['other_type']=="Distillery" ? 'selected': ''}}>Distillery</option>
                                        <option value="Merchant" {{$editbrands['other_type']=="Merchant" ? 'selected': ''}}>Merchant</option>
                                    </select>
                                       </td>
                                   </tr>
                                   <tr class="enable_disable">
                                       <th>List of (Distillery/Merchants) </th>
                                       <td colspan="3">
                                       <select class="form-control" name="both_D_M" id="both_D_M">
                                        @foreach($other_types as $others)
                                        <option value="{{$others->id}}" {{$editbrands['brand_DM']==$others->id ? 'selected': ''}}>{{$others->name}}</option>
                                        @endforeach
                                        </select>
                                       </td>
                                   </tr>
                                   @endif
                                   <tr>
                                       <th>Brand Logo</th>
                                       <td><img src="{{ URL::to('/images')}}/{{$editbrands->logo}}" width="100px"><input class="form-control" id="brandlogo" name="brandlogo" type="file" value=""/></td>
                                   </tr>
                                   <tr>
                                       <th>Brand Cover</th>
                                       <td><img src="{{ URL::to('/images')}}/{{$editbrands->cover}}" width="100px"><input class="form-control" id="brandcover" name="brandcover" type="file" value="" /></td>
                                   </tr>
                                   <tr>
                                    <th>Brand Gallery</th>
                                    <td><div class="col-lg-3" style="display:flex;">
                                    @if(!empty($editbrands->gallery))
                                        <?php
                                         $photos = json_decode($editbrands->gallery, true);
                                            $i = 1;
                                            foreach ($photos as $photo) {
                                            ?>
                                                <div>
                                                    <a href="{{ url('/images/') }}<?php echo $photo; ?>" target="_blank"><img src="{{ url('/images/') }}/<?php echo $photo; ?>" style="width:100px!important;height:100px;padding-right: 2px;"></a>
                                                </div>
                                                <?php
                                                $i++;
                                            } ?>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Upload Multiple Images </label>
                                    <input class="form-control" type="file" id="brandgallery" name="brandgallery[]" value="" autofocus="" multiple="">
                                    
                                </div></td>
                                    </tr>
                                   <tr>
                                       <td colspan="4" style="text-align:center ;"><button type="submit" class="btn btn-primary btn-block" name="update">Update Brand</button></td>

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
