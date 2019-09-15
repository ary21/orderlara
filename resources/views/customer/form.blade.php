<div class="alert alert-danger" @if (count($errors) < 1) {{'style=display:none;'}} @endif>
    <ul class="alert-ul">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>

<form class="form myform" role="form" enctype="multipart/form-data" method="POST" action="@if (!empty($data)) {{ route('customers.update', ['id'=>$data->id]) }} @else {{ route('customers.store') }} @endif">
    {{ csrf_field() }}
    @isset($data) 
        {{ method_field('PUT') }}
    @endisset
    <div class="form-group">
        <label class="control-label" for="nama">Name</label>
        <input type="text" name="nama" id="nama" class="form-control" value="@isset($data){{ $data->nama }}@endisset" autofocus>
    </div>
    <div class="form-group">
        <label class="control-label" for="telp">Phone</label>
        <input type="text" name="telp" id="telp" class="form-control" value="@isset($data){{ $data->telp }}@endisset">
    </div>
    <div class="form-group">
        <label class="control-label" for="umur">Age</label>
        <input type="number" name="umur" id="umur" class="form-control" value="@isset($data){{ $data->umur }}@endisset">
    </div>
    <div class="form-group">
        <label class="control-label" for="id_city">City</label>
        <div class="col-md-12 pl-0">
            <select id="id_city" class="form-control select2" name="id_city">
                <option value="">Choose City</option>
                @foreach($citys as $city)
                    <option value="{{$city->id}}" @if (!empty($data)) @if ($data->id_city==$city->id) {{'selected'}} @endif @endif>{{$city->city}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label" for="alamat">Address</label>
        <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="5">@isset($data){{ $data->alamat }}@endisset</textarea>
    </div>
</form>