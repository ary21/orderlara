<link href="{{ asset('vendor/bootstrap-datepicker/css/datepicker.css') }}" rel="stylesheet">
<script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

<form class="form myform" role="form" enctype="multipart/form-data" method="POST" action="@if (!empty($data)) {{ route('orders.update', ['id'=>$data->id]) }} @else {{ route('orders.store') }} @endif">
<div>    
    <div class="alert alert-danger" @if (count($errors) < 1) {{'style=display:none;'}} @endif>
        <ul class="alert-ul">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    {{ csrf_field() }}
    @isset($data) 
        {{ method_field('PUT') }}
    @endisset
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 float-left">
        <div class="form-group">
            <label class="control-label" for="code">Order Code</label>
            <input type="text" name="code" id="code" class="form-control" value="@isset($data){{ $data->code }}@endisset" autofocus>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 float-left">
        <div class="form-group">
            <label class="control-label" for="date">Date</label>
            <input type="text" name="date" id="date" class="form-control datepicker" value="@if(!empty($data)){{ $data->date }}@else{{date('Y-m-d')}}@endif" >
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 float-left">
        <div class="form-group">
            <label class="control-label" for="id_customer">Customer</label>
            <div class="col-md-12 pl-0">
                <select id="id_customer" class="form-control select2" name="id_customer">
                    <option value="">Choose Customer</option>
                    @foreach($customers as $customer)
                        <option value="{{$customer->id}}" @if (!empty($data)) @if ($data->id_customer==$customer->id) {{'selected'}} @endif @endif>{{$customer->nama}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 float-left">
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
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 float-left">
        <div class="table-responsive">
            <table class="table table-stripped">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Sub Total</th>
                        <th width="75"></th>
                    </tr>
                </thead>
                <tbody id="listOrder">
                    @php $num = 1; @endphp
                    @if (!empty($data))
                        @php $items = json_decode($data->items) @endphp
                        @foreach ($items as $item)
                            <tr id="list-{{$num}}">
                                <td><input type="text" name="items[{{$num}}][item]" id="item-{{$num}}" value="{{$item->item}}" class="form-control"></td>
                                <td><input type="number" name="items[{{$num}}][qty]" id="qty-{{$num}}" value="{{$item->qty}}" onkeyup="CalRow({{$num}})" min="1" class="form-control qtys"></td>
                                <td><input type="number" name="items[{{$num}}][price]" id="price-{{$num}}" value="{{$item->price}}" onkeyup="CalRow({{$num}})" class="form-control prices"></td>
                                <td><input type="number" id="sub-{{$num}}" class="form-control subs" value="{{$item->qty * $item->price}}" readonly></td>
                                <td align="center" class="pl-1 pr-1">
                                    @if ($num!=1)
                                        <button type="button" class="btn btn-sm btn-danger" onclick="DeleteList({{$num}})" title="Delete"><i class="fa fa-trash"></i></button>&nbsp;
                                    @endif
                                    <button type="button" class="btn btn-sm btn-primary" onclick="AddList()" title="Add New List"><i class="fa fa-plus"></i></button>
                                </td>
                            </tr>
                            @php $num++; @endphp
                        @endforeach
                    @else
                        <tr id="list-1">
                            <td><input type="text" name="items[1][item]" id="item-1" class="form-control"></td>
                            <td><input type="number" name="items[1][qty]" id="qty-1" onkeyup="CalRow(1)" min="1" value="1" class="form-control qtys"></td>
                            <td><input type="number" name="items[1][price]" id="price-1" onkeyup="CalRow(1)" class="form-control prices"></td>
                            <td><input type="number" id="sub-1" class="form-control subs" readonly></td>
                            <td align="center" class="pl-1 pr-1">
                                <button type="button" class="btn btn-sm btn-primary" onclick="AddList()" title="Add New List"><i class="fa fa-plus"></i></button>
                            </td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td><b>Grand Total</b></td>
                        <td><input type="text" name="totalqty" id="totalQty" class="form-control" value="@isset($data){{ $data->totalqty }}@endisset" readonly></td>
                        <td></td>
                        <td><input type="text" name="totalgrand" id="totalGrand" class="form-control" value="@isset($data){{ $data->totalgrand }}@endisset" readonly></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btnCloseModal btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btnSaveModal btn btn-primary">Submit</button>
</div>
</form>
<script>
    var num = {{$num}};

    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    $('#id_customer').change(function() {
        $.get(encodeURI("{{url('/orders/getcustomer')}}/"+$(this).val())).done(function(res) { 
            $('#id_city').val(res.id_city);
        });
    });

    function AddList() {
        num++;
        var newlist = '<tr id="list-'+num+'">'+
            '<td><input type="text" name="items['+num+'][item]" id="item-'+num+'" class="form-control"></td>'+
            '<td><input type="number" name="items['+num+'][qty]" id="qty-'+num+'" onkeyup="CalRow('+num+')" min="1" value="1" class="form-control qtys"></td>'+
            '<td><input type="number" name="items['+num+'][price]" id="price-'+num+'" onkeyup="CalRow('+num+')" class="form-control prices"></td>'+
            '<td><input type="number" id="sub-'+num+'" class="form-control subs" readonly></td>'+
            '<td align="center" class="pl-1 pr-1">'+
                '<button type="button" class="btn btn-sm btn-danger" onclick="DeleteList('+num+')" title="Delete"><i class="fa fa-trash"></i></button>&nbsp;'+
                '<button type="button" class="btn btn-sm btn-primary" onclick="AddList()" title="Add New List"><i class="fa fa-plus"></i></button>'+
            '</td>'+
            '</tr>';

        $('#listOrder').append(newlist);
    };

    function DeleteList(lnum) {
        $('#list-'+lnum).remove();

        SumList();
    };

    function CalRow(lnum) {
        var qty = eval($('#qty-'+lnum).val());
        var price = eval($('#price-'+lnum).val());

        if (qty == undefined) qty = 0;
        if (price == undefined) price = 0;

        var sub = qty * price;

        $('#sub-'+lnum).val(sub);

        SumList();
    };

    function SumList() {
        var sumQtys = 0;
        $('.qtys').each(function(){
            var Qtys = parseFloat(this.value);
            if (Qtys == undefined) Qtys = 0;
            if (Qtys == NaN) Qtys = 0;
            
            console.log(Qtys);
            sumQtys += Qtys;
        });

        $('#totalQty').val(sumQtys);

        var sumSubs = 0;
        $('.subs').each(function(){
            var Subs = parseFloat(this.value);
            if (Subs == undefined) Subs = 0;
            
            sumSubs += Subs;
        });

        $('#totalGrand').val(sumSubs);
    };
</script>