@extends('layout.admin.master')
@section('title', "Sales")
@section('parentPageTitle', 'Admin')


@section('content')

<div class="col-lg-12">
  <div class="card">
      <div class="body">
        <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="dt_sales" style="width: 100%">
          <thead>
              <tr class="text-center">
                <th style="width: 30px">ID</th>
                <th>Restaurant</th>
                <th>Menus</th>
                <th>Total Price</th>
                <th>Staff Type</th>
                <th>Staff Name</th>
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

<select name="restaurants" style="display: none">
  @foreach ($restaurants as $restaurant)
      <option value="{{ $restaurant->id }}">{{ $restaurant->restName }}</option>
  @endforeach
</select>

@stop
