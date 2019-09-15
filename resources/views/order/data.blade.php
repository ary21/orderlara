<div class="row my-2">
    <div class="col-md-12">
        <button type="button" class="btnAdd btn btn-sm btn-primary"><i class="fa fa-plus"></i> New Order</button>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width="50">No</th>
                <th>Order Code</th>
                <th>Date</th>
                <th>Name</th>
                <th>City</th>
                <th>Total</th>
                <th width="230"></th>
            </tr>
        </thead>
        <tbody id="data-tb">
            @php $num = $orders->firstItem(); @endphp
            @foreach ($orders as $item)
                <tr>
                    <td class="text-center">{{ $num++ }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->city }}</td>
                    <td>{{ $item->totalgrand }}</td>
                    <td class="text-center">                        
                        <button type="button" class="btnDetail btn btn-sm btn-primary" data-id="{{ $item->id }}"><i class="fa fa-search-plus"></i> Detail</button>
                        <button type="button" class="btnEdit btn btn-sm btn-primary" data-id="{{ $item->id }}"><i class="fa fa-pencil"></i> Edit</button>
                        <form onsubmit="return confirm('Delete this data permanently?')" class="d-inline" action="{{route('orders.destroy', ['id' => $item->id ])}}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}
</div>

<script>
    $(function() {
        $('body').on('click', '.pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            
            getOrder(url);
            window.history.pushState("", "", url);
    
            return false;
        });

        $('.btnAdd').click(function() {
            $.get("{{url('/orders/create')}}").done(function(content) {
                $('.modal-dialog').addClass('modal-lg');
                $('.modal-footer').hide();
                $('.modal-title').html('New Order');
                $('.modal-body').html(content);
                $('#myModal').modal('show');

                $('#code').focus();

                $('.myform').submit(function(e){
                    e.preventDefault(); 

                    $.post("{{url('/orders')}}", $('.myform').serialize()).done(function (data) {
                        $('#myModal').modal('hide');
                        $('.modal-footer').show();
                        loadData("{{url('/orders/show')}}")
                    }).fail(function(xhr, status, error) {
                        $('.alert-ul').html('');
                        $('.alert').show();
                        var er = xhr.responseJSON.errors;
                        $.each(er, function(i, item) {
                            console.log(item[0]);
                            $('.alert-ul').append('<li>'+item[0]+'</li>');
                        });
                    });
                });
            });
        });
        
        $('.btnEdit').click(function() {
            var id = $(this).data('id');
            $.get(encodeURI("{{url('/orders')}}/"+id+'/edit')).done(function(content) {
                $('.modal-dialog').addClass('modal-lg');
                $('.modal-footer').hide();
                $('.modal-title').html('Edit Order');
                $('.modal-body').html(content);
                $('#myModal').modal('show');

                $('.myform').submit(function(e){
                    e.preventDefault(); 
                    
                    $.post("{{url('/orders')}}/"+id, $('.myform').serialize()).done(function (data) {
                        $('#myModal').modal('hide');
                        $('.modal-footer').show();
                        loadData("{{url('/orders/show')}}")
                    }).fail(function(xhr, status, error) {
                        $('.alert-ul').html('');
                        $('.alert').show();
                        var er = xhr.responseJSON.errors;
                        $.each(er, function(i, item) {
                            console.log(item[0]);
                            $('.alert-ul').append('<li>'+item[0]+'</li>');
                        });
                    });
                });
            });
        });
        
        $('.btnDetail').click(function() {
            var id = $(this).data('id');
            $.get(encodeURI("{{url('orders/details')}}/"+id)).done(function(content) {
                $('.modal-dialog').addClass('modal-lg');
                $('.modal-title').html('Detail Order');
                $('.modal-body').html(content);
                $('#myModal').modal('show');
                $('.btnSaveModal').hide();
            });
        });

        function getOrder(url) {
            $.ajax({
                url : url  
            }).done(function (data) {
                $('#main-list').html(data);  
            }).fail(function () {
                alert('Data could not be loaded.');
            });
        }
    });
</script> 