@extends('layout.manager.master')
@section('title', "Users")
@section('parentPageTitle', 'Manager')

@section('content-top-right')
<button type="button" class="btn btn-primary" id="btn_add">
  Add New Staff
</button>
@endsection

@section('content')

<div class="col-lg-12">
  <div class="card">
      <div class="body">
        <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="dt_staff" style="width: 100%">
          <thead>
            <tr class="text-center">
              <th style="width: 30px">No</th>
              <th>Name</th>
              <th>Role</th>
              <th>Contact</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="text-center" style="font-weight: normal">
          </tbody>
        </table>
      </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalStaff" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
          <input type="hidden" class="form-control" name="staff_id">
          <div class="form-row">
            <div class="form-group col-md-6">
                <label>First Name *</label>
                <input type="text" class="form-control" name="f_name" required>
            </div>
            <div class="form-group col-md-6">
                <label>Last Name *</label>
                <input type="text" class="form-control" name="l_name" required>
            </div>
          </div>
          <div class="form-group">
            <label>Password *</label>
            <input type="password" class="form-control" name="password" required>
          </div>
          <div class="form-row">
              <div class="form-group col-md-6">
                  <label>Role *</label>
                  <select name="role" class="form-control">
                    <option value="" selected></option>
                    <option value="2">Cashier</option>
                    <option value="3">Kitchen</option>
                  </select>
              </div>
          </div>
          <div class="form-group">
            <label>Contact</label>
            <input type="text" class="form-control" name="contact">
          </div>
          
          <button type="button" class="btn btn-primary btn-lg btn-block" onclick="dtStaff.submit()">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

@stop
