
var baseTableUrl = window.location.origin + '/ajax/admin/restcontent/' + restaurant_id + "/";
var baseImgUrl = window.location.origin + '/';

var tableColumns = [
  {
    data: 'tableNum',
    orderable: true,
  },
  {
    data: 'restName',
    orderable : false
  },
  // {
  //   data: 'qrImgUrl',
  //   orderable : false
  // },
  {
    data: null,
    orderable : false,
    render: function(data, type, row){
      var h = "";
      h += '<img style="width: 30px; height: 30px" src="' + baseImgUrl + row.qrImgUrl + '" alt="">';

      return h;
    },
  }
];

var dtTables = {
  iniMainTable: function(){
    $('#dt_tables').dataTable({
      responsive: true,
      processing: true,
      serverSide: false,
      pageLength: 10,
      // order: [[3, 'asc']], //Initial no order.
      columns: tableColumns,
      ajax: {
        url: baseTableUrl + 'getTable'
      }
    });
  },
  addTable: function() {
    console.log("button is clicked");
    apiComm.PostApiCall(baseTableUrl+'addTable', 'dtTables.addTable_callback');
  },
  addTable_callback: function(data) {
    console.log(data);
    $('#dt_tables').DataTable().ajax.reload();
  }
};

jQuery(function(){

  dtTables.iniMainTable();

  $('#btn_addTable').on('click', function() {
    dtTables.addTable();
  })

});