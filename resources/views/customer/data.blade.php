<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/i18n/id.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>

<div class="row my-2">
    <div class="col-md-12">
        <button type="button" class="btnAdd btn btn-sm btn-primary"><i class="fa fa-plus"></i> New Customer</button>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width="50">No</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Age</th>
                <th>Address</th>
                <th>City</th>
                <th width="160"></th>
            </tr>
        </thead>
        <tbody id="data-tb">
            @php $num = $customers->firstItem(); @endphp
            @foreach ($customers as $item)
                <tr>
                    <td class="text-center">{{ $num++ }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->telp }}</td>
                    <td>{{ $item->umur }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->city }}</td>
                    <td class="text-center">
                        <button type="button" class="btnEdit btn btn-sm btn-primary" data-id="{{ $item->id }}"><i class="fa fa-pencil"></i> Edit</button>
                        <form onsubmit="return confirm('Delete this data permanently?')" class="d-inline" action="{{route('customers.destroy', ['id' => $item->id ])}}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $customers->links() }}
</div>
<script>
$(function() {
    $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        
        getCustomer(url);
        window.history.pushState("", "", url);

        return false;
    });

    $('.btnAdd').click(function() {
        $.get("{{url('/customers/create')}}").done(function(content) {
            $('.modal-title').html('New Customer');
            $('.modal-body').html(content);
            $('#myModal').modal('show');

            $('.select2').select2()
            $('.select2-container').css('width', '100%');

            $('.btnSaveModal').click(function() {
                $.post("{{url('/customers')}}", $('.myform').serialize()).done(function (data) {
                    $('#myModal').modal('hide');
                    loadData("{{url('/customers/show')}}")
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
        $.get(encodeURI("{{url('/customers')}}/"+id+'/edit')).done(function(content) {
            $('.modal-title').html('Edit Customer');
            $('.modal-body').html(content);
            $('#myModal').modal('show');

            $('.select2').select2()
            $('.select2-container').css('width', '100%');

            $('.btnSaveModal').click(function() {
                $.post("{{url('/customers')}}/"+id, $('.myform').serialize()).done(function (data) {
                    $('#myModal').modal('hide');
                    loadData("{{url('/customers/show')}}")
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

    function getCustomer(url) {
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