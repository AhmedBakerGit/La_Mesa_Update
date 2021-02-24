@extends('layout.cashier.master')
@section('title', 'Request')
@section('parentPageTitle', 'Cashier')

@section('content')

<div class="col-lg-12">
  <div class="card">
      <div class="body">
        <center>
            <input type="button" class="btn btn-primary mt-1 mb-2" id="btnRequestArrived" value="5 new requests">
        </center>
          <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="dt_request" style="width: 100%">
                  <thead>
                      <tr class="text-center">
                        <th style="width: 30px">ID</th>
                        <th>Table</th>
                        <th>Request Detail</th>
                        <th>Time</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody class="text-center">
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>

<script>
    var restaurant_id = {{$user->restaurant->id}};
</script>

@stop
