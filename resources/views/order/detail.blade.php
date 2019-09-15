<form class="form">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 float-left">
        <div class="form-group">
            <label class="control-label" for="code">Order Code</label>
            <input type="text" id="code" class="form-control" value="{{ $data->code }}" disabled>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 float-left">
        <div class="form-group">
            <label class="control-label" for="date">Date</label>
            <input type="text" id="date" class="form-control" value="{{ $data->date }}"  disabled>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 float-left">
        <div class="form-group">
            <label class="control-label" for="id_customer">Customer</label>
            <input type="text" id="id_customer" class="form-control" value="{{ $data->nama }}" disabled>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 float-left">
        <div class="form-group">
            <label class="control-label" for="id_city">City</label>
            <input type="text" id="id_city" class="form-control" value="{{ $data->city }}" disabled>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 float-left">
        <div class="table-responsive">
            <table class="table table-stripped">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th width="130">Qty</th>
                        <th width="130">Price</th>
                        <th width="130">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $items = json_decode($data->items); @endphp
                    @foreach ($items as $item)
                        <tr>
                            <td>{{$item->item}}</td>
                            <td>{{$item->qty}}</td>
                            <td>{{$item->price}}</td>
                            <td>{{$item->qty * $item->price}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right"><b>Grand Total</b></td>
                        <td><input type="text" id="totalQty" class="form-control" value="{{ $data->totalqty }}" disabled></td>
                        <td></td>
                        <td><input type="text" id="totalGrand" class="form-control" value="{{ $data->totalgrand }}" disabled></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</form>