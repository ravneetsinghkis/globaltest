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
                <form method="post" action="{{ route('merchant.update', $editbrands['id'])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                            <div class="card-body">
                                <table class="table table-bordered">
                                   <tr>
                                    <th> Name</th>
                                       <td><input class="form-control" id="name" name="name" type="text" value="{{$editbrands['name']}}" required /></td>
                                   </tr>
                                   <tr>
                                       <th> Distillery Legend</th>
                                       <td><input class="form-control" id="description" name="description" type="text" value="{{$editbrands['story']}}"  required /></td>
                                   </tr>
                                   <tr>
                                       <th>Establishment Year</th>
                                       <td>  <select class="form-control" id="establishment" name="establishment"  required>
                                            {{ $now = date('Y') }}
                                            @for ($i = 1970; $i <= $now; $i++)
                                                <option value="{{ $i }}" {{$editbrands['establishment']== $i ?'selected': '' }}>{{ $i }}</option>
                                            @endfor
                                        </select></td>
                                   </tr>
                                   
                                   <tr>
                                       <th> Company</th>
                                       <td colspan="3">
                                        <select class="form-control" name="company">
                                        @foreach($productCatalog as $catelog)
                                            <option value="{{$catelog->id}}" {{$editbrands['company_id']==$catelog->id ? 'selected': ''}}>{{$catelog->name}}</option>
                                        @endforeach
                                        </select>
                                       </td>
                                   </tr>
                                    <tr>
                                       <th> Country</th>
                                       <td colspan="3">
                                        <select class="form-control" name="country_id" id="country">
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}" {{$editbrands['country']==$country->id ? 'selected': ''}}>{{$country->name}}</option>
                                        @endforeach
                                        </select>
                                       </td>
                                   </tr>
                                   <tr>
                                       <th> Region </th>
                                       <td colspan="3">
                                        <select class="form-control" name="region" id="region">
                                        @foreach($states as $state)
                                            <option value="{{$state->id}}" {{$editbrands['region']==$state->id ? 'selected': ''}}>{{$state->name}}</option>
                                        @endforeach
                                        </select>
                                       </td>
                                   </tr>
                                   <tr>
                                       <th> Logo</th>
                                       <td><img src="{{ URL::to('/images')}}/{{$editbrands->logo}}" width="100px"><input class="form-control" id="logo" name="logo" type="file" value=""/></td>
                                   </tr>
                                   <tr>
                                       <th> Cover</th>
                                       <td><img src="{{ URL::to('/images')}}/{{$editbrands->cover}}" width="100px"><input class="form-control" id="cover" name="cover" type="file" value="" /></td>
                                   </tr>
                                   <tr>
                                       <th> Social Media Link</th>
                                       <td><input class="form-control" type="text" id="brandmedialink" name="brandmedialink" value="{{$editbrands->socialmedia_link}}" autofocus=""></td>
                                   </tr>
                                   <tr>
                                       <td colspan="4" style="text-align:center ;"><button type="submit" class="btn btn-primary btn-block" name="update">Update Merchant</button></td>

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

@endsection
