@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/order/table.css') }}">
@endpush
@prepend('after-styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/order/table.css') }}">
@endprepend

@extends('layout.kitchen.master')
@section('title', 'Order')
@section('parentPageTitle', 'Kitchen')

@section('content-top-right')
<input type="button" class="btn btn-primary mt-4" id="btnNewOrderArrived" value="5 New Orders">
@endsection

@section('content')

<div class="row clearfix">

    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="header">
                <h2>Queuing</h2>
            </div>
            <div class="body" style="height: 525px; overflow-y: auto;">
                <ul id="left_ui" class="list-unstyled feeds_widget">
                    
                </ul>
            </div>
        </div>
    </div>

    <div id="right_ui" class="col-lg-8 col-md-12">
        
    </div>

</div>

<script>
    var restaurant_id = @json($user->restaurant_id);
</script>

@stop
