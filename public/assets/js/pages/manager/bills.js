
var columns = [
  {
    data: null,
    orderable: true,
    render: function(data, type, row) {
      return row.data().orderID;
    }
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row) {
      return row.data().tableNum;
    }
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row){
      var h = "";
      var menus = row.data().menus;
      menus.forEach(menu => {
        h += "<li>" + menu.st_foodName + ":   " + menu.dFoodPrice + " X " + menu.nCartedCount + " = " + menu.dFoodPrice * menu.nCartedCount + "</li>";
      });
      
      return h;
    },
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row) {
      return row.data().orderPrice;
    }
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row) {
      return row.data().userType;
    }
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row) {
      switch (row.data().orderStatus) {
        case 0: return "Queuing";
        case 1: return "Cancel";
        case 2: return "Preparing";
        case 3: return "Served";
        case 4: return "Bill Requested";
        case 5: return "Billed";
      }
    }
  },
  
  {
    data: null,
    orderable : false,
    render: function(data, type, row){
      var time = row.data().timeStamp.seconds;
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
];

function loadTable() {
  orderDBRef
    .where("orderStatus", "==", 5)
    .orderBy('timeStamp', 'desc')
    .get()
    .then(function(querySnapshot) {
      
      var dataSet = [];
      
      querySnapshot.forEach(function(doc) {
          // doc.data() is never undefined for query doc snapshots
          // console.log(doc.id, " => ", doc.data());
          dataSet.push(doc);
      });

      reloadTable(dataSet);
    })
    .catch(function(error) {
        console.log("Error getting documents: ", error);
    });
}

function reloadTable(dataSet) {
  $('#dt_bills').DataTable().clear().draw();
  $('#dt_bills').DataTable().rows.add(dataSet);
  $('#dt_bills').DataTable().columns.adjust().draw();
}

jQuery(function(){

  $('#dt_bills').dataTable({
    responsive: true,
    processing: true,
    // serverSide: false,
    // pageLength: 10,
    order: [], //Initial no order.
    columns: columns,
    data: []
  });
  
  loadTable();
});