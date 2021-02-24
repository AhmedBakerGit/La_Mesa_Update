
var columns = [
  {
    data: 'requestID',
    orderable: true,
  },
  {
    data: 'tableNum',
    orderable: true,
  },
  {
    data: 'requestDetail',
    orderable : false,
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row){
      var time = row.timeStamp.seconds;
      dateObj = new Date(time * 1000);
      var month = dateObj.getMonth() + 1; //months from 1-12
      var day = dateObj.getDate();
      var year = dateObj.getFullYear();
      var hours = dateObj.getHours();
      var minutes = dateObj.getMinutes();
      var seconds = dateObj.getSeconds();

      var newdate = year + "-" + month + "-" + day + " / " + hours + ":" + minutes + ":" + seconds;

      return newdate;
    },
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row){
      
      var h = "";
    
      h += '<button class="btn btn-sm btn-icon btn-pure btn-default on-default m-r-5 button-remove" data-toggle="tooltip" data-original-title="Delete" onclick="markAsRead(this)" data-ref="'+ row.requestID + '">';
      h += 'Mark As Read</button>';

      return h;
    },
  },
];

function loadRequestTable() {
  requestDBRef
    .orderBy('timeStamp', 'desc').limit(500)
    .get()
    .then(function(querySnapshot) {
      
      var dataSet = [];
      
      querySnapshot.forEach(function(doc) {
          // doc.data() is never undefined for query doc snapshots
          dataSet.push(doc.data());
      });

      reloadRequestTable(dataSet);
    })
    .catch(function(error) {
        console.log("Error getting documents: ", error);
    });
}

function reloadRequestTable(dataSet) {
  $('#dt_request').DataTable().clear().draw();
  $('#dt_request').DataTable().rows.add(dataSet);
  $('#dt_request').DataTable().columns.adjust().draw();
}

$('#btnRequestArrived').on('click', function() {
  nNewRequest = 0;
  updateUiNewRequestWrapper();
  $('#newRequestCount').html("");
  loadRequestTable();
  // window.location.href = window.location.origin + "/manager/request";
})

function updateUiNewRequestWrapper() {
  if(nNewRequest > 0) {
    $('#btnRequestArrived').css('visibility', 'visible');
  } else {
    $('#btnRequestArrived').css('visibility', 'hidden');
  }

  $('#btnRequestArrived').val(nNewRequest + " new requests");
}

async function markAsRead(cObj) {
  var requestID = $(cObj).data('ref');

  // update data
  await requestDBRef.doc(requestID).delete();
  loadRequestTable();

  nNewRequest = 0;
  updateUiNewRequestWrapper();
  $('#newRequestCount').html("");
}

jQuery(function(){

  $('#dt_request').dataTable({
    responsive: true,
    processing: true,
    // serverSide: false,
    // pageLength: 10,
    order: [], //Initial no order.
    columns: columns,
    data: []
  });
  
  updateUiNewRequestWrapper();

  loadRequestTable();
});
