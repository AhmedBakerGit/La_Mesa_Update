@extends('layout.kitchen.master')
@section('title', 'Menu')
@section('parentPageTitle', 'Kitchen')

@section('content')

<div class="col-lg-12">
  <div class="card">
      <div class="body">
            
        <!-- Tab panes -->
        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane p-l-15 p-r-15 active" id="menuTab">
              <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="menu_tables" style="width: 100%">
                <thead>
                  <tr class="text-center">
                    <th style="width: 30px">Number</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="text-center" style="font-weight: normal">
                </tbody>
              </table>
            </div>            
        </div>      
      </div>
  </div>
</div>

<script>
  var restaurant_id = @json($selRest->id);
</script>


@stop