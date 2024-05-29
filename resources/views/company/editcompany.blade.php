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
                <div class="row" style="margin:10px 20px; text-align:center;">
                <div class="col-md-3">  
                <a href="/create-brand?company_id={{$editproductCatalog['id']}}" class="btn btn-primary btn-sm text-gray-500" >Add Brand</a>
            </div>
            <div class="col-md-3">  
                <a href="/create-distillery?company_id={{$editproductCatalog['id']}}" class="btn btn-primary btn-sm text-gray-500" >Add Distillery</a>
            </div>
            <div class="col-md-3">  
                <a href="/create-merchant?company_id={{$editproductCatalog['id']}}" class="btn btn-primary btn-sm text-gray-500" >Add Merchant</a>
            </div>
                </div>
                <form method="post" action="{{ route('company.update', $editproductCatalog['id'])}}"  enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                            <div class="card-body">
                                <table class="table table-bordered">
                                   <tr>
                                    <th>Title *</th>
                                       <td><input class="form-control" id="name" name="name" type="text" value="{{$editproductCatalog['name']}}" required /></td>
                                   </tr>
                                   <tr>
                                       <th>Your Establishment Year *</th>
                                       <td>
                                        <select class="form-control" id="establishment" name="establishment"  required>
                                            {{ $now = date('Y') }}
                                            @for ($i = 1970; $i <= $now; $i++)
                                                <option value="{{ $i }}" {{$editproductCatalog['establishment']== $i ?'selected': '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </td>
                                   </tr>
                                   <tr>
                                       <th>Company Description *</th>
                                       <td><input class="form-control" id="description" name="description" type="text" value="{{$editproductCatalog['description']}}"  required /></td>
                                   </tr>
                                   <tr>
                                       <th>Company Email</th>
                                       <td colspan="3">{{$editproductCatalog['email']}}</td>
                                   </tr>
                                   
                                   <tr>
                                       <th>Company Country *</th>
                                       <td colspan="3">
                                        <select class="form-control" name="country_id" id="country">
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}" {{$editproductCatalog['country_id']==$country->id ? 'selected': ''}}>{{$country->name}}</option>
                                        @endforeach
                                        </select>
                                       </td>
                                   </tr>
                                   <tr>
                                       <th>Company Region *</th>
                                       <td colspan="3">
                                        <select class="form-control" name="region" id="region">
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" {{$editproductCatalog['region']==$state->id ? 'selected': ''}}>{{$state->name}}</option>
                                        @endforeach
                                        </select>
                                       </td>
                                   </tr>
                                   <tr>
                                       <th>Company Representative Name *</th>
                                       <td><input class="form-control" id="representative_name" name="representative_name" type="text" value="{{$editproductCatalog['representative_name']}}"  required /></td>
                                   </tr>
                                   <tr>
                                       <th>Company Representative Contact</th>
                                       <td><input class="form-control" id="representative_contact" name="representative_contact" type="text" value="{{$editproductCatalog['representative_contact']}}"/></td>
                                   </tr>
                                   <tr>
                                       <th>Company Person Name *</th>
                                       <td><input class="form-control" id="person_name" name="person_name" type="text" value="{{$editproductCatalog['person_name']}}"  required /></td>
                                   </tr>
                                   <tr>
                                       <th>Company Person Info</th>
                                       <td><input class="form-control" id="person_info" name="person_info" type="text" value="{{$editproductCatalog['person_info']}}" /></td>
                                   </tr>
                                   <tr>
                                       <th>Company Logo</th>
                                       <td><img src="{{ URL::to('/images')}}/{{$editproductCatalog->logo}}" width="100px"><input class="form-control" id="logo" name="logo" type="file" value=""/></td>
                                   </tr>
                                   <tr>
                                       <th>Company Social Links</th>
                                       <td><input class="form-control" id="medialink" name="medialink" type="text" value="{{$editproductCatalog['company_social']}}"   /></td>
                                   </tr>
                                  
                                   <tr>
                                       <td colspan="4" style="text-align:center ;"><button type="submit" class="btn btn-primary btn-block" name="update">Update Company</button></td>

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
function storeCompanyId(companyId) {
     localStorage.setItem('company_id', companyId);   
}
$(document).ready(function () {
  $('#country').on('change', function () {
      var idCountry = this.value;
      //alert('sss');
      $("#state").html('');
      $.ajax({
          url: "{{url('/fetch-states')}}",
          type: "POST",
          data: {
              country_id: idCountry,
              _token: '{{csrf_token()}}'
          },
          dataType: 'json',
          success: function (result) {
            $('#region').html('');
              $.each(result.states, function (key, value) {
                  $("#region").append('<option value="' + value
                      .id + '">' + value.name + '</option>');
              });
          }
      });
  });
});
</script>
@endsection
