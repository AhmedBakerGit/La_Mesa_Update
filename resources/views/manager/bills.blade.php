@extends('layout.manager.master')
@section('title', 'Bills')
@section('parentPageTitle', 'Manager')

@section('content')

<div class="col-lg-12">
  <div class="card">
      <div class="body">
          <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="dt_bills" style="width: 100%">
                  <thead>
                      <tr class="text-center">
                        <th style="width: 30px">ID</th>
                        <th>Table Number</th>
                        <th>Menus</th>
                        <th>Total Price</th>
                        <th>User Type</th>
                        <th>Status</th>
                        <th>Time</th>
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
    var restaurant_id = {{$user->restaurant_id }};
</script>

@stop
