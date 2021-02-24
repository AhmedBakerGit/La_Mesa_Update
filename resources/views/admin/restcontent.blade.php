@extends('layout.admin.master')
@section('title', $selRest->restName)
@section('parentPageTitle', 'Admin')

@section('content')

<div class="col-lg-12">
  <div class="card">
      <div class="body">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menuTab">Menu</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tableTab">Table</a></li>            
        </ul>
            
        <!-- Tab panes -->
        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane p-l-15 p-r-15 active" id="menuTab">
              <button type="button" class="btn btn-primary tab-upper-absolute-button" id="btn_restMenu">+ Add</button>
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
            <div class="tab-pane p-l-15 p-r-15" id="tableTab">
              <button type="button" class="btn btn-primary tab-upper-absolute-button" id="btn_addTable">+ Add</button>

              <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="dt_tables" style="width: 100%">
                <thead>
                  <tr class="text-center">
                    <th style="width: 30px">Number</th>
                    <th>Restaurant</th>
                    <th>Qr Code</th>
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
<!-- Modal -->
<div class="modal fade" id="modalMenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
          <input type="hidden" class="form-control" name="menu_id">
          <div class="form-row">
            <div class="form-group col-md-6">
                <label>Menu Name *</label>
                <input type="text" class="form-control" name="foodName" required>
            </div>
            <div class="form-group col-md-6">
              <label>Price *</label>
              <div class="input-group mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-dollar"></i></span>
                  </div>
                  <input type="text" class="form-control" name="foodPrice" placeholder="">
              </div>
            </div>
          </div>
          <div class="form-group ">
            <label>Food Image *</label>
            <div class="body">
                <input type="file" class="dropify" name="foodPicUrl" data-default-file="" data-allowed-file-extensions="jpg png">
            </div>
          </div>
          
          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="foodDescription" id="foodDescription" cols="30" rows="5"></textarea>
          </div>
          <div class="form-group">
            <label>Status *</label>
            <br />
            <select name="foodAvailable" class="form-control">
              <option value="1" selected>Available</option>
              <option value="0">Unavailable</option>
            </select>
              {{-- <label class="fancy-radio custom-color-green"><input name="foodAvailable" value="1" type="radio" checked required data-parsley-errors-container="#error-radio"><span><i></i>Available</span></label>
              <label class="fancy-radio custom-color-green"><input name="foodAvailable" value="0" type="radio" ><span><i></i>Unavailable</span></label>
              <p id="error-radio"></p> --}}
          </div>
          
          <button type="button" class="btn btn-primary btn-lg btn-block" onclick="dtMenus.submit()">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  var restaurant_id = @json($selRest->id);
</script>


@stop
