
var baseUrl = window.location.origin + '/ajax/manager/staff/';

var columns = [
  {
    data: 'id',
    orderable: true,
    // render: function(data, type, row){

    // }
  },
  {
    data: 'name',
    orderable : false
  },
  {
    data: 'role',
    orderable : false,
  },
  {
    data: 'contact',
    orderable : false
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row){
      var h = "";
      h += '<button class="btn btn-sm btn-icon btn-pure btn-default on-default m-r-5 button-edit" data-toggle="tooltip" data-original-title="Edit" onclick="dtStaff.showEditModal(this)" data-id="'+ row.id + '">';
      h += '<i class="icon-pencil" aria-hidden="true"></i></button>';
    
      h += '<button class="btn btn-sm btn-icon btn-pure btn-default on-default m-r-5 button-remove" data-toggle="tooltip" data-original-title="Delete" onclick="dtStaff.deleteStaff(this)" data-id="'+ row.id + '" data-name="'+ row.name +'">';
      h += '<i class="icon-trash" aria-hidden="true"></i></button>';

      return h;
    },
  },
];

var dtStaff = {
  iniMainTable: function(){
    $('#dt_staff').dataTable({
      responsive: true,
      processing: true,
      serverSide: false,
      pageLength: 10,
      // order: [[3, 'asc']], //Initial no order.
      columns: columns,
      "language": {
        "emptyTable": "No Staff Data",
        "zeroRecords": "No marched staff data.",
        },
      ajax: {
        url: baseUrl + 'getAll'
      }
    });
  },
  showEditModal: function(cObj) {
    var id = $(cObj).data("id");
    
    params = {
      id: id
    };

    apiComm.PostApiCall(baseUrl+'getOne', 'dtStaff.editStaff', params);
  },
  editStaff: function(res) {
    if (res.status == 1) {
      dtStaff.clearModalConent();

      var modal = $('#modalStaff');
      modal.find(".modal-title").html(res.data.name);
      modal.find("input[name='staff_id']").val(res.data.id);
      modal.find("input[name='f_name']").val(res.data.f_name);
      modal.find("input[name='l_name']").val(res.data.l_name);
      modal.find("select[name='role']").val(res.data.role_id);
      modal.find("input[name='contact']").val(res.data.contact);

      modal.modal('show');
    }
  },
  submit: function() {
    var modal = $('#modalStaff');
    var name = modal.find("input[name='f_name']").val() + " " + modal.find("input[name='l_name']").val();
    if (!modal.find("input[name='f_name']").val() || !modal.find("input[name='l_name']").val() || !modal.find("input[name='password']").val() ||
       !modal.find("select[name='role']").val()) {
      alert("Please fill the required fields!");
      return;
    }
      
    var params = {
      id: modal.find("input[name='staff_id']").val(),
      f_name: modal.find("input[name='f_name']").val(),
      l_name: modal.find("input[name='l_name']").val(),
      name: name,
      password: modal.find("input[name='password']").val(),
      restaurant_id: modal.find("select[name='restaurant']").val(),
      role_id: modal.find("select[name='role']").val(),
      contact: modal.find("input[name='contact']").val()
    };
    
    apiComm.PostApiCall(baseUrl+'submit', 'dtStaff.submit_callback', params);
  },
  submit_callback: function(res) {
    $('#modalStaff').modal('hide');

    if (res.status == 1) {
      $('#dt_staff').DataTable().ajax.reload();
    } else {
      alert(res.msg)
    }
  },
  deleteStaff: function(cObj) {
    var id = $(cObj).data("id");
    var name = $(cObj).data("name");

    swal({
      title: "Are you sure delete staff " +  name +"?",
      // text: "Are you sure delete Restaurant?",
      type: "warning",
      showCancelButton: !0,
      confirmButtonText: "Yes",
      cancelButtonText: "Cancel",
      reverseButtons: !0
    }, function (event) {
      if (event) {
        var params = {
          id: id
        };

        apiComm.PostApiCall(baseUrl+"delete", 'dtStaff.deleteCallback', params);
      }
    });
  },
  deleteCallback: function(res) {
    $('#dt_staff').DataTable().ajax.reload();
  },
  clearModalConent: function() {
    var modal = $('#modalStaff');
    modal.find(".modal-title").html("");
    modal.find("input[name='staff_id']").val("");
    modal.find("input[name='f_name']").val("");
    modal.find("input[name='l_name']").val("");
    modal.find("input[name='password']").val("");
    modal.find("select[name='restaurant']").val("");
    modal.find("select[name='role']").val("");
    modal.find("input[name='contact']").val("");
  }
};

jQuery(function(){

  dtStaff.iniMainTable();

  $('#btn_add').on('click', function() {
    console.log('button click===')
    var modal = $('#modalStaff');

    dtStaff.clearModalConent();
    modal.find(".modal-title").html("Add New Staff");

    modal.modal('show');
  })

});