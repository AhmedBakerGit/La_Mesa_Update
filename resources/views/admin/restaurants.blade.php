@extends('layout.admin.master')
@section('title', 'Restaurants')
@section('parentPageTitle', 'Admin')

@section('content-top-right')
<button type="button" class="btn btn-primary" id="btn_add">
  Add New Restaurant
</button>
@endsection

@section('content')

<div class="col-lg-12">
  <div class="card">
      <div class="body">
          <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="dt_restaurants">
                  <thead>
                      <tr class="text-center">
                        <th>No</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Telephone</th>
                        <th>Cellphone</th>
                        <th>Description</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody class="text-center" style="font-weight: normal">
                    @foreach ($restaurants as $item)
                      <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{$item->restName}}</td>
                        <td>{{$item->restAddress}}</td>
                        <td>{{$item->restTelephone}}</td>
                        <td>{{$item->restCellphone}}</td>
                        <td>{{$item->restDescription}}</td>
                        <td>
                          <button class="btn btn-sm btn-icon btn-pure btn-default on-default m-r-5 button-edit" data-toggle="tooltip" data-original-title="Edit" onclick="showEditModal(this)" data-id="{{ $item->id }}">
                            <i class="icon-pencil" aria-hidden="true"></i>
                          </button>
                          <button class="btn btn-sm btn-icon btn-pure btn-default on-default m-r-5 button-remove" data-toggle="tooltip" data-original-title="Delete" onclick="deleteRestaurant(this)" data-id="{{ $item->id }}" data-name="{{$item->restName}}">
                            <i class="icon-trash" aria-hidden="true"></i>
                          </button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalRestaurant" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalTitle"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action=" {{ route('admin.restaurants.submit') }}" validate class="form-auth-small">
          @csrf
          <input type="hidden" class="form-control" name="restaurant_id">
          <div class="form-group">
            <label>Restaurant Name</label>
            <input type="text" class="form-control" name="restName" required>
          </div>
          <div class="form-group">
              <label>Restaurant Address</label>
              <input type="text" class="form-control" name="restAddress" required>
          </div>
          <div class="form-row">
              <div class="form-group col-md-6">
                  <label>Telephone</label>
                  <input type="text" class="form-control" name="restTelephone">
              </div>
              <div class="form-group col-md-6">
                  <label>Cellphone</label>
                  <input type="text" class="form-control" name="restCellphone">
              </div>
          </div>
          <div class="form-group">
            <label>Restaurant Description</label>
            <textarea class="form-control" name="restDescription" style="height: 100px"></textarea>
          </div>
          
          <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

@stop
