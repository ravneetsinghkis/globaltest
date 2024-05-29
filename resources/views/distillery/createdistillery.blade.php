@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="mb-3" style="text-align: right;"><a href="/list-distillery" class="destroy-session btn btn-primary btn-sm text-gray-500">View All Distilleries</a></div>
        
            <div class="card">
                <div class="card-header">{{ __('Create Distillery') }}</div>

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
                    <form  method="POST" action="{{ url('distillery') }}" enctype="multipart/form-data" class="needs-validation">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Title *</label>
                                    <input class="form-control" type="text" id="name" name="name" value="" autofocus="" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Establishment Year *</label>
                                    <select class="form-control" name="establishment" id="establishment" required>
                                    {{ $now = date('Y') }}
                                    @for ($i = 1970; $i <= $now; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label"> Country *</label>
                                    <select class="form-control" name="country" id="country">
                                        @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label"> Region *</label>
                                    <select class="form-control" name="region" id="region">
                                       
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label"> Company *</label>
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
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Distillery Legend * </label>
                                    <input class="form-control" type="text" id="description" name="description" value="" autofocus="" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label"> Logo *</label>
                                    <input class="form-control" type="file" id="brandlogo" name="brandlogo" value="" accept="image/*" autofocus="">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label"> Cover *</label>
                                    <input class="form-control" type="file" id="brandcover" name="brandcover" value="" autofocus="" required>
                                    
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label"> Social Media link</label>
                                    <input class="form-control" type="text" id="brandmedialink" name="brandmedialink" value="" autofocus="" >
                                
                                </div>

                                <div class="mt-2">
                                    <button type="submit" class="button-create me-2 btn-primary">Save Distillery</button>
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
