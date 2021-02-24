@extends('layout.cashier.master')
@section('title', 'Orders')
@section('parentPageTitle', 'Cashier')

@section('content-top-right')
<input type="button" class="btn btn-primary mt-4" id="btnAddNewOrder" value="Add New Order">
@endsection

@section('content')

<div class="col-lg-12">
  <div class="card">
      <div class="body">
        <center>
            <input type="button" class="btn btn-primary mt-1 mb-2" id="btnNewOrderArrived" value="5 new orders">
        </center>
          <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="dt_orders" style="width: 100%">
                  <thead>
                      <tr class="text-center">
                        <th style="width: 30px">ID</th>
                        <th>Table Number</th>
                        <th>Menus</th>
                        <th>Total Price</th>
                        <th>User Type</th>
                        <th>Status</th>
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

<!-- Modal -->
<div class="modal fade" id="modalOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalTitle"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form validate class="form-auth-small">
            <input type="hidden" class="form-control" name="orderId">

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Tables</label>
                    <select name="tables" class="form-control">
                        @foreach ($tables as $table)
                        <option value="{{ $table->tableNum }}">{{ $table->tableNum }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <label>Menus</label>
                <select name="menus" class="form-control">
                    @foreach ($menus as $menu)
                    <option data-id="{{ $menu->id }}" data-foodname="{{ $menu->foodName }}" data-foodprice="{{ $menu->foodPrice }}" 
                            data-fooddescription="{{ $menu->foodDescription }}" data-foodpicurl="{{ $menu->foodPicUrl }}" 
                            data-foodavailable="{{ $menu->foodAvailable }}" value="{{ $menu->id }}">{{ $menu->foodName }}</option>
                    @endforeach

                </select>
            </div>
            
            <div class="d-flex justify-content-between" style="margin-top: 15px">
                <label class="form-control" style="width: 50px; border: 0px ">Img</label>
                <label class="form-control" style="border: none">foodName</label>
                <label class="form-control" style="border: none">Price</label>
                <label class="form-control" style="border: none">Quantity</label>
                <label class="form-control px-0" style="width: 40px; border: none;">Del</label>
            </div>
            <div id="cart_menu_wrapper" style="width: 100%; height: 200px; overflow-y: auto;">
                
            </div>
            <div class="form-row">
                <label style="margin-left: 150px">Total Price: &nbsp; &nbsp; </label><label name="orderPrice" style="font-weight: bold"></label>
            </div>
            <button type="button" class="btn btn-primary btn-lg btn-block mt-3" >Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="modalCancelOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form validate class="form-auth-small">
              <span for="">Order ID: &nbsp;</span><label name="orderId"></label>
            <input type="hidden" class="form-control" name="orderId">

            <div class="form-row">
                <label>Manager Name *</label>
                <input name="name" type="text" class="form-control">
            </div>
        
            <div class="form-row mt-3">
                <label>Manager Password *</label>
                <input name="password" type="password" class="form-control">
            </div>

            <button type="button" class="btn btn-primary btn-lg btn-block mt-3" >Okay</button>
          </form>
        </div>
      </div>
    </div>
</div>

<script>
  var restaurant_id = @json($user->restaurant->id);
  var staff_name = @json($user->name);
</script>

@stop
