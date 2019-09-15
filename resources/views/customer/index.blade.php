@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Customer') }}</div>
                <div class="card-body" id="main-list">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        loadData("{{url('/customers/show')}}")
    });
</script>
@endsection