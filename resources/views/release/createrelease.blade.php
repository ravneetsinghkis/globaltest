@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="">
        <div class="" style="text-align: right;margin-bottom:20px;"><a href="/list-releases" class="btn btn-primary btn-sm text-gray-500">View All Releases</a></div>
        </div>
            <div class="card">
                <div class="card-header">{{ __('Create Release') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li style="color:red;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form  method="POST" action="{{ url('releases') }}" enctype="multipart/form-data" class="needs-validation">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Release Title *</label>
                                    <input class="form-control" type="text" id="name" name="name" value="" autofocus="" required>
                                    
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">EAN *</label>
                                    <input class="form-control" type="text" id="ean" name="ean" value="" autofocus="" required>
                                    
                                </div>
                               
                                <!-- <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Type</label>
                                        <select class="form-control" name="release_type" id="release_type" >
                                        <option value="">Type 1</option>
                                        <option value="">Type 2</option>
                                        </select>
                                    </div> -->
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Publication date *</label>
                                     <input class="form-control" type="date" id="publication_date" name="publication_date" value="" autofocus="" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Release Country *</label>
                                    <select class="form-control" name="country" id="country">
                                        @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Company Region *</label>
                                    <select class="form-control" name="region" id="region">
                                       
                                    </select>
                                </div>
                                 <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Price Band *</label>
                                    <select class="form-control" name="price_band" id="price_band">
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                        <option value="400">400</option>
                                        <option value="500">500</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">ABV *</label>
                                    <input class="form-control" type="text" id="abv" name="abv" value="" autofocus="" required>
                                   
                                </div>
                                <div class="mb-12 col-md-12">
                                    <label for="name" class="form-label">Release Story *</label>
                                    <textarea type="text" class="form-control" name="description" required></textarea>
                                   
                                </div>
                                 <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Choose (Distillery/Merchants/Brands) </label>
                                        <select class="form-control" name="other_option" id="other_option">
                                            <option value="Distillery">Distillery</option>
                                            <option value="Merchant">Merchant</option>
                                            <option value="Brand">Brand</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">List of (Distillery/Merchants) </label>
                                        <select class="form-control" name="both_D_M" id="both_D_M"  required>
                                        <option value=""></option>
                                        </select>
                                    </div>
                                
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Release Logo * </label>
                                    <input class="form-control" type="file" id="releaselogo" name="releaselogo" value="" accept="image/*" required autofocus="">
                                   
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Release Gallery * </label>
                                    <input class="form-control" type="file" id="gallery" name="gallery" value="" accept="image/*" required autofocus="">
                                   
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Release Cover *</label>
                                    <input class="form-control" type="file" id="releasecover" name="releasecover" value="" autofocus="" required>
                                    
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Release Social Media link</label>
                                    <input class="form-control" type="text" id="releasemedialink" name="releasemedialink" value="" autofocus="">
                                
                                </div>

                                <div class="mt-2">
                                    <button type="submit" class="button-create me-2 btn-primary">Save Releases</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
 

 $(document).ready(function(){
        $("#enable_disable").hide();
        $("#flexSwitchCheckDefault").click(function () {
            if ($(this).is(":checked")) {
                $("#enable_disable").show();
                $("#flexSwitchCheckDefault").val('1');
            } else {
                $("#enable_disable").hide();
                $("#flexSwitchCheckDefault").val('0');
            }
        });
    })
   
    $(document).ready(function(){
        var option_value = "Distillery";
      //alert('sss');
      $("#both_D_M").html('');
      $.ajax({
          url: "{{url('/fetch-merchants-distillery')}}",
          type: "POST",
          data: {
            id: option_value,
              _token: '{{csrf_token()}}'
          },
          dataType: 'json',
          success: function (result) {
            $('#both_D_M').html('');
              $.each(result.data, function (key, value) {
                  $("#both_D_M").append('<option value="' + value
                      .id + '">' + value.name + '</option>');
              });
          }
      });
    })

</script>
@endsection
