@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="">
        <div class="" style="text-align: right; margin-bottom:20px;"><a href="/list-company" class="btn btn-primary btn-sm text-gray-500">View All Companies</a></div>
       
        </div>
            <div class="card">
                <div class="card-header">{{ __('Company') }}</div>

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

                    <form  method="POST" action="{{ url('company') }}" enctype="multipart/form-data" class="needs-validation">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Title *</label>
                                    <input class="form-control" type="text" id="name" name="name" value="" autofocus="" required>
                                    <div class="invalid-tooltip">gfgn</div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Your Establishment Year *</label>
                                    <select class="form-control" name="establishment" id="establishment" required>
                                    {{ $now = date('Y') }}
                                    @for ($i = 1970; $i <= $now; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    </select>
                    
                                    <div class="invalid-tooltip">gfgn</div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Company Description *</label>
                                    <input class="form-control" type="text" id="description" name="description" value="" autofocus="" required>
                                    <div class="invalid-tooltip">gfgn</div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Company Country *</label>
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
                                    <label for="name" class="form-label">Company Representative name *</label>
                                    <input class="form-control" type="text" id="representative_name" name="representative_name" value="" autofocus="" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Company Representative contact</label>
                                    <input class="form-control" type="text" id="representative_contact" name="representative_contact" pattern="[1-9]{1}[0-9]{9}" value="" autofocus="">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Contact Person Name *</label>
                                    <input class="form-control" type="text" id="person_name" name="person_name" value="" autofocus="" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Contact Person Info</label>
                                    <input class="form-control" type="text" id="person_info" name="person_info"  value="" autofocus="">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Company Email *</label>
                                    <input class="form-control" type="text" id="email" name="email" value="" autofocus="" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Company Logo *</label>
                                    <input class="form-control" type="file" id="companylogo" name="companylogo" value="" accept="image/*" autofocus="">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Company Social Links </label>
                                    <input class="form-control" type="text" id="medialink" name="medialink" value="" autofocus="">
                                </div>
                                
                                <div class="mt-2">
                                    <button type="submit" class="button-create me-2 btn-primary">Save Company</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
