
var baseMenuUrl = window.location.origin + '/ajax/kitchen/';
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
      if(row.foodPicUrl)
      h += '<img style="width: 30px; height: 30px" src="' + baseImgUrl + row.foodPicUrl + '" alt="">';
      else h = "";

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
      h += 'Change Available</button>';

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
  showEditModal: function(cObj) {
    var menu_id = $(cObj).data("menu_id");
    params = {
      menu_id: menu_id
    };

    apiComm.PostApiCall(baseMenuUrl+'changeAvailable', 'dtMenus.changeMenu_callback', params);
  },
  changeMenu_callback: function(res) {
    if (res.status == 1) {
      $('#menu_tables').DataTable().ajax.reload();
    } else {
      alert(res.msg)
    }
  }
};

jQuery(function(){
  dtMenus.iniMainTable();
});