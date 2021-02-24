
var billRef = firebase.firestore()
.collection("restaurants");

var columns = [
  {
    data: null,
    orderable: true,
    render: function(data, type, row) {
      return row.orderID;
    }
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row) {
      var h = '<p style="white-space: pre-wrap;">' + row.restName + '</p>';
      return h;
    }
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row){
      var h = "";
      var menus = row.menus;
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
      return row.orderPrice;
    }
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row) {
      return row.userType;
    }
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row) {
      if (row.userType === "manager" || row.userType === "cashier") {
        var h = '<p style="white-space: pre-wrap;">' + row.userName + '</p>';
        return h;
      }

      return "";
    }
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row) {
      switch (row.orderStatus) {
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
      var time = row.timeStamp.seconds;
      dateObj = new Date(time * 1000);
      var month = dateObj.getMonth() + 1; //months from 1-12
      var day = dateObj.getDate();
      var year = dateObj.getFullYear();
      var hours = dateObj.getHours();
      var minutes = dateObj.getMinutes();
      var seconds = dateObj.getSeconds();

      var newdate = year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;

      var h = '<p style="white-space: pre-wrap;">' + newdate + '</p>';
      return h;
    },
  },
];

function getRestaurants() {
  return new Promise((res, rej) => {
    var restaurants = [];
    $('select[name="restaurants"] option').each(async(index, elem) =>{
      var restID = $(elem).val();
      var restName = $(elem).html(); 
      restaurants.push({restID: restID, restName: restName})
    })

    return res(restaurants);
  })
}

async function loadTable() {

  var dataSet = [];

  // var restaurants = await getRestaurants();

  // console.log(restaurants);

  // for (var i = 0; i < restaurants.length; i++) {
  //   var querySnapshot = await billRef
  //       .doc(restaurants[i].restID)
  //       .collection("orders")
  //       .where("orderStatus", "==", 5)
  //       .orderBy('timeStamp')
  //       .get();

  //   if (querySnapshot.size != 0) {
  //     var docs = querySnapshot.docs;

  //     for (var j in docs) {
  //       var data = docs[j].data();
  //       console.log(data);
  //       data.restName = restaurants[i].restName;
  //       dataSet.push(data);
  //     }
  //   }
  // }

  // reloadTable(dataSet);

  await $('select[name="restaurants"] option').each(async(index, elem) =>{
    var restID = $(elem).val();
    var restName = $(elem).html(); 
    
    var querySnapshot = await billRef
        .doc(restID)
        .collection("orders")
        .where("orderStatus", "==", 5)
        .orderBy('timeStamp')
        .get();

    if (querySnapshot.size == 0) return;
    
    var docs = querySnapshot.docs;

    for (var i in docs) {
      var data = docs[i].data();
      data.restName = restName;
      dataSet.push(data);
    }
    
    reloadTable(dataSet);
  })

}

function reloadTable(dataSet) {
  $('#dt_sales').DataTable().clear().draw();
  $('#dt_sales').DataTable().rows.add(dataSet);
  $('#dt_sales').DataTable().columns.adjust().draw();
}

jQuery(function(){

  $('#dt_sales').dataTable({
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