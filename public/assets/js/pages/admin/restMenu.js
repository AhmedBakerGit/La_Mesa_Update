
var baseMenuUrl = window.location.origin + '/ajax/admin/restcontent/' + restaurant_id + "/";
var baseImgUrl = window.location.origin + '/';

var MenuColumns = [
  {
    data: 'id',
    orderable: true,
  },
  {
    data: 'foodName',
    orderable : false
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row){
      var h = "";
      if (row.foodPicUrl){
        h += '<img style="width: 30px; height: 30px" src="' + baseImgUrl + row.foodPicUrl + '" alt="">';
      }
      return h;
    },
  },
  {
    data: 'foodPrice',
    orderable : false
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row){
      var h = '<p style="white-space: pre-wrap;">' + row.foodDescription + '</p>';
      return h;
    },
  },
  
  {
    data: null,
    orderable : false,
    render: function(data, type, row){
      var h = "";
      if(row.foodAvailable == 0) h = "Unavailable";
      else h = "Available";

      return h;
    },
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row){
      var h = "";
      h += '<button class="btn btn-sm btn-icon btn-pure btn-default on-default m-r-5 button-edit" data-toggle="tooltip" data-original-title="Edit" onclick="dtMenus.showEditModal(this)" data-menu_id="'+ row.id + '">';
      h += '<i class="icon-pencil" aria-hidden="true"></i></button>';
    
      h += '<button class="btn btn-sm btn-icon btn-pure btn-default on-default m-r-5 button-remove" data-toggle="tooltip" data-original-title="Delete" onclick="dtMenus.deleteMenus(this)" data-menu_id="'+ row.id + '" data-foodName="'+ row.foodName +'">';
      h += '<i class="icon-trash" aria-hidden="true"></i></button>';

      return h;
    },
  },
];

var dtMenus = {
  iniMainTable: function(){
    $('#menu_tables').dataTable({
      responsive: true,
      processing: true,
      serverSide: false,
      pageLength: 10,
      // order: [[3, 'asc']], //Initial no order.
      columns: MenuColumns,
      ajax: {
        url: baseMenuUrl + 'getMenuAll'
      }
    });
  },
  addMenu: function() {
    apiComm.PostApiCall(baseMenuUrl+'menuSubmit', 'dtMenus.addMenu_callback');
  },
  addMenu_callback: function(data) {
    $('#menu_tables').DataTable().ajax.reload();
  },
  showEditModal: function(cObj) {
    var menu_id = $(cObj).data("menu_id");
    params = {
      menu_id: menu_id
    };

    apiComm.PostApiCall(baseMenuUrl+'getMenuOne', 'dtMenus.editOneMenu', params);
  },
  editOneMenu: function(res) {
    if (res.status == 1) {
      dtMenus.clearModalConent();

      var modal = $('#modalMenu');
      modal.find(".modal-title").html(res.data.foodName);
      modal.find("input[name='menu_id']").val(res.data.id);
      modal.find("input[name='foodName']").val(res.data.foodName);
      modal.find("input[name='foodPrice']").val(res.data.foodPrice);
      modal.find("select[name='foodAvailable']").val(res.data.foodAvailable);
      modal.find("textarea[name='foodDescription']").val(res.data.foodDescription);
      if(res.data.foodPicUrl) {
        if(modal.find('.dropify-render img').length == 0)
        {
          modal.find('.dropify-render').html('<img src="">');
        }
        modal.find('.dropify-render img').prop('src', baseImgUrl + res.data.foodPicUrl);
        modal.find('.dropify-preview').show();
      }
      modal.find("input[name='foodPicUrl']").data("default-file", baseImgUrl + res.data.foodPicUrl);
      modal.modal('show');
    }
  },
  submit: function() {
    var modal = $('#modalMenu');
    var foodName = modal.find("input[name='foodName']").val();
    if (!modal.find("input[name='foodName']").val() || !modal.find("input[name='foodPrice']").val() || !modal.find("select[name='foodAvailable']").val()) {
      alert("Please fill the required fields!");
      return;
    }
    var menuFormData = new FormData();
    menuFormData.append('menu_id', modal.find("input[name='menu_id']").val());
    menuFormData.append('foodName', modal.find("input[name='foodName']").val());
    menuFormData.append('foodPrice', modal.find("input[name='foodPrice']").val());
    menuFormData.append('foodAvailable', modal.find("select[name='foodAvailable']").val());
    menuFormData.append('foodDescription', modal.find("textarea[name='foodDescription']").val());
    menuFormData.append('foodPicUrl', modal.find("input[name='foodPicUrl']").prop('files')[0]);
    
    apiComm.PostApiCall(baseMenuUrl+'menuSubmit', 'dtMenus.submit_callback', menuFormData, null, 'false', 'false');
  },
  submit_callback: function(res) {
    $('#modalMenu').modal('hide');

    if (res.status == 1) {
      $('#menu_tables').DataTable().ajax.reload();
    } else {
      alert(res.msg)
    }
  },
  deleteMenus: function(cObj) {
    var menu_id = $(cObj).data("menu_id");
    var foodName = $(cObj).data("foodname");

    swal({
      title: "Are you sure delete Menu " +  foodName +"?",
      // text: "Are you sure delete Restaurant?",
      type: "warning",
      showCancelButton: !0,
      confirmButtonText: "Yes",
      cancelButtonText: "Cancel",
      reverseButtons: !0
    }, function (event) {
      if (event) {
        var params = {
          menu_id: menu_id
        };

        apiComm.PostApiCall(baseMenuUrl+"deleteMenu", 'dtMenus.deleteCallback', params);
      }
    });
  },
  deleteCallback: function(res) {
    $('#menu_tables').DataTable().ajax.reload();
  },
  clearModalConent: function() {
    var modal = $('#modalMenu');
    modal.find(".modal-title").html("");
    modal.find("input[name='menu_id']").val("");
    modal.find("input[name='foodName']").val("");
    modal.find("input[name='foodPrice']").val("");
    modal.find("select[name='foodAvailable']").val("1");
    modal.find("textarea[name='foodDescription']").val("");
    modal.find('.dropify-render img').prop('src', "");
    modal.find('.dropify-preview').hide();
    modal.find("input[name='foodPicUrl']").data("default-file", "");
    modal.find("input[name='foodPicUrl']").val("");
  }
};

jQuery(function(){
  dtMenus.iniMainTable();
  $('.dropify').dropify();

    var drEvent = $('#dropify-event').dropify();
    drEvent.on('dropify.beforeClear', function(event, element) {
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });

    drEvent.on('dropify.afterClear', function(event, element) {
        alert('File deleted');
    });

    $('.dropify-fr').dropify({
        messages: {
            default: 'Glissez-déposez un fichier ici ou cliquez',
            replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
            remove: 'Supprimer',
            error: 'Désolé, le fichier trop volumineux'
        }
    });

  $('#btn_restMenu').on('click', function() {
    console.log('-------')
      var modal = $('#modalMenu');
  
      dtMenus.clearModalConent();
      modal.find(".modal-title").html("Add New Menu");
  
      modal.modal('show');
  })
});