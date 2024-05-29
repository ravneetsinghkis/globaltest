@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="">
            
        <div class="" style="text-align: right;margin-bottom:20px;"><a href="/list-brands" class="btn btn-primary btn-sm text-gray-500">View All Brands</a></div>
        </div>
            <div class="card">
                <div class="card-header">{{ __('Create Brand') }}</div>

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

                    <form  method="POST" action="{{ url('brands') }}" enctype="multipart/form-data" class="needs-validation">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Brand Title *</label>
                                    <input class="form-control" type="text" id="name" name="name" value="" autofocus="" required>
                                    
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Brand Story *</label>
                                    <input class="form-control" type="text" id="description" name="description" value="" autofocus="" required>
                                   
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Brand Establishment Year *</label>
                                    <select class="form-control" id="establishment" name="establishment"  required>
                                            {{ $now = date('Y') }}
                                            @for ($i = 1970; $i <= $now; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Brand Country *</label>
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
                                    <label for="name" class="form-label">Choose Company *</label>
                                   <select class="form-control" name="company" id="company" 
                                    @if(isset(request()->company_id)) style="pointer-events: none;" @endif>
                                    @foreach($productCatalog as $companyname)
                                    <option value="{{ $companyname->id }}" 
                                        @if(request('company_id') == $companyname->id) selected @endif>
                                        {{ $companyname->name }}
                                    </option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Enable/Disable  </label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_selected" id="flexSwitchCheckDefault" value="0">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">(Distillery/Merchants)</label>
                                    </div>
                                </div>
                                <div class="row" id="enable_disable">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Choose (Distillery/Merchants) </label>
                                        <select class="form-control" name="other_option" id="other_option">
                                            <option value="Distillery">Distillery</option>
                                            <option value="Merchant">Merchant</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">List of (Distillery/Merchants) </label>
                                        <select class="form-control" name="both_D_M" id="both_D_M" >
                                        <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Brand Logo * </label>
                                    <input class="form-control" type="file" id="brandlogo" name="brandlogo" value="" accept="image/*" required autofocus="">
                                   
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Brand Cover *</label>
                                    <input class="form-control" type="file" id="brandcover" name="brandcover" value="" autofocus="" required>
                                    
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Brand Galleries (Upload Multiple Images) </label>
                                    <input class="form-control" type="file" id="brandgallery" name="brandgallery[]" value="" autofocus="" multiple>
                                    
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Brand Social Media link</label>
                                    <input class="form-control" type="text" id="brandmedialink" name="brandmedialink" value="" autofocus="">
                                
                                </div>

                                <div class="mt-2">
                                    <button type="submit" class="button-create me-2 btn-primary">Save Brands</button>
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
