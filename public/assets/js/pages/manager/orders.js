
var baseImgUrl = window.location.origin + '/';

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
      // var h = new Date(row.data().timeStamp.toDate()).toDateString();
    },
  },
  {
    data: null,
    orderable : false,
    render: function(data, type, row){
      var h = "";
    
      if (row.data().orderStatus == 0) {
        h += '<button class="btn btn-sm btn-icon btn-pure btn-default on-default m-r-5 button-edit" data-toggle="tooltip" data-original-title="Edit" onclick="editOrder(this)" data-ref="'+ row.id + '">';
        h += '<i class="icon-pencil" aria-hidden="true"></i></button>';

        h += '<button class="btn btn-sm btn-icon btn-pure btn-default on-default m-r-5 button-remove" data-toggle="tooltip" data-original-title="Delete" onclick="cancelOrder(this)" data-ref="'+ row.id + '">';
        h += '<i class="icon-trash" aria-hidden="true"></i></button>';
      }

      if (row.data().orderStatus == 4) {
        h += '<button class="btn btn-sm btn-icon btn-pure btn-default on-default m-r-5 button-remove" data-toggle="tooltip" data-original-title="Delete" onclick="billFinish(this)" data-ref="'+ row.id + '" data-tablenum="' + row.data().tableNum + '">';
        h += '<i class="fa fa-credit-card" aria-hidden="true"></i></button>';
      }

      return h;
    },
  },
];

function loadTable() {
  orderDBRef
    .where("orderStatus", "<", 5)
    .orderBy("orderStatus")
    .orderBy('timeStamp', 'desc').limit(500)
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
  $('#dt_orders').DataTable().clear().draw();
  $('#dt_orders').DataTable().rows.add(dataSet);
  $('#dt_orders').DataTable().columns.adjust().draw();
}

$('#btnNewOrderArrived').on('click', function() {
  nNewOrder = 0;
  updateUINewOrderWrapper();
  $('#newOrderCount').html("");
  loadTable();
  // window.location.href = window.location.origin + "/cashier/orders";
})

function updateUINewOrderWrapper() {
  if(nNewOrder > 0) {
    $('#btnNewOrderArrived').css('visibility', 'visible');
  } else {
    $('#btnNewOrderArrived').css('visibility', 'hidden');
  }

  $('#btnNewOrderArrived').val(nNewOrder + " new orders");
}

$('#btnAddNewOrder').on('click', function() {
  var modal = $('#modalOrder');

  clearModalConent();
  modal.find(".modal-title").html("Add New Order");

  modal.modal('show');
})

function editOrder(cObj) {
  var orderID = $(cObj).data('ref');

  orderDBRef
    .doc(orderID)
    .get()
    .then(function(doc) {
      
      // querySnapshot.forEach(function(doc) {
      //     // doc.data() is never undefined for query doc snapshots
      //     // console.log(doc.id, " => ", doc.data());
      //     dataSet.push(doc);
      // });

      if (doc.exists) {
        var order = doc.data();

        var modal = $('#modalOrder');
  
        clearModalConent();
  
        modal.find(".modal-title").html('Edit Order: "'+ orderID + '"');
        modal.find('input[name="orderId"]').val(orderID)
        modal.find('form select[name="tables"]').val("" + order.tableNum);
        modal.find('form select[name="tables"]').css("pointer-events","none");
  
        // draw orders
        order.menus.forEach((menu) => {
          html = `<div name="menu" class="d-flex justify-content-between my-2">
                  <input type="hidden" name="menu_id" class="form-control" value="`+ menu.nFoodId +`">
                  <img src="`+ menu.st_foodPicUrl +`" width="50" height="50" alt="">
                  <input type="hidden" name="foodPicUrl" class="form-control" value="`+ menu.st_foodPicUrl +`" readonly>
                  <input type="text" name="foodName" class="form-control" value="`+ menu.st_foodName +`" readonly>
                  <input type="number" name="foodPrice" class="form-control" value="`+ menu.dFoodPrice +`" readonly>
                  <input type="number" name="foodQuantity" class="form-control" onblur="setOrderPrice()" value="` + menu.nCartedCount + `">
                  <a href="javascript:void(0);" class="delete-selectedFood btn btn-outline-danger py-0" style="line-height: 50px;"><i class="icon-trash"></i></a>
              </div>`
          $('form #cart_menu_wrapper').append(html)
        })

        setOrderPrice();

        modal.modal('show');
  
      } else {
        alert("No doc exists");
      }
      
    })
    .catch(function(error) {
        console.log("Error getting documents: ", error);
    });
}

function cancelOrder(cObj) {
  var orderID = $(cObj).data('ref');

  swal({
    title: 'Are you sure Cancel "' +  orderID +'" Order?',
    // text: "Are you sure delete Restaurant?",
    type: "warning",
    showCancelButton: !0,
    confirmButtonText: "Yes",
    cancelButtonText: "Cancel",
    reverseButtons: !0
  }, async function (event) {
    if (event) {
      // update data
      await orderDBRef.doc(orderID).update({orderStatus: 1});
      loadTable();
    }
  });
  
}

function billFinish(cObj) {
  var orderID = $(cObj).data('ref');
  var tableNum = $(cObj).data('tablenum');

  swal({
    title: 'Are you sure Bill finish "' +  orderID +'" Order?',
    // text: "Are you sure delete Restaurant?",
    type: "warning",
    showCancelButton: !0,
    confirmButtonText: "Yes",
    cancelButtonText: "Cancel",
    reverseButtons: !0
  }, async function (event) {
    if (event) {
      // update data
      await orderDBRef.doc(orderID).update({orderStatus: 5});
      loadTable();

      let currentUnbilledOrders = await orderDBRef
                          .where('orderStatus', 'in', [0, 2, 3, 4])
                          .where('tableNum', '==', parseInt(tableNum))
                          .where('isCurrent', '==', true)
                          .get();

      if (currentUnbilledOrders.size > 0) return;

      var data = {
        restauarnt_id: restaurant_id,
        tableNum: tableNum
      }

      $.ajax({
        data: data,
        type: 'GET',
        url: baseImgUrl + 'mobile/exit',
        contentType: "application/json; charset=utf-8",
        success: async function (data) {
          if (data.status === 1) {

            console.log(`Table ${tableNum} is released`);
          } else {
            alert(data.msg);
          }
        },
        error: function (jqXHR, txtStatus, errorThrown) {
            //alert(errorThrown + " " + txtStatus);
            console.log("txtStatus:" + txtStatus + " (" + errorThrown + ")");
        },
        statusCode: {
            404: function () {
                console.log("url not found");
            }
        }
      }).fail(function (f) {
        console.log("Fail")
      });
    }
  });
  
}

function clearModalConent() {
  var modal = $('#modalOrder');
  modal.find('input[name="orderId"]').val("");
  modal.find('form select[name="tables"]').val("1");
  modal.find('form select[name="tables"]').css("pointer-events","auto");
  modal.find('form select[name="menus"]').val("");
  modal.find("#cart_menu_wrapper").html("");
  $('form label[name="orderPrice"]').html("$0");
}

$('form select[name="menus"]').on('change', function(){
  var select_menu = $(this).children("option:selected")
  var menu_id = select_menu.val();
  if(menu_id !== 0){
    var isTrue = true;
    var menus = getMenus_2();

    menus.forEach(elem => {
      if (elem.nFoodId == parseInt(menu_id)) {
        isTrue = false;
      }
    });

    if (isTrue) {
      html = `<div name="menu" class="d-flex justify-content-between my-2">
                  <input type="hidden" name="menu_id" class="form-control" value="`+ menu_id +`">
                  <img src="`+ baseImgUrl+select_menu.data('foodpicurl') +`" width="50" height="50" alt="">
                  <input type="hidden" name="foodPicUrl" class="form-control" value="`+ baseImgUrl + select_menu.data('foodpicurl') +`" readonly>
                  <input type="text" name="foodName" class="form-control" value="`+ select_menu.data('foodname') +`" readonly>
                  <input type="number" name="foodPrice" class="form-control" value="`+ select_menu.data('foodprice') +`" readonly>
                  <input type="number" name="foodQuantity" class="form-control" value="" onblur="setOrderPrice()">
                  <a href="javascript:void(0);" class="delete-selectedFood btn btn-outline-danger py-0" style="line-height: 50px;"><i class="icon-trash"></i></a>
              </div>`
      $('form #cart_menu_wrapper').append(html)
    }
  }
})

$('#cart_menu_wrapper').on('click', '.delete-selectedFood', function(){
  var element =$(this);
  element.parent().remove()
  setOrderPrice();
})

function setOrderPrice() {
  var orderPrice = 0.0;

  $('form #cart_menu_wrapper div[name="menu"]').each((index, elem) => {
    
    if ($(elem).find('input[name="foodQuantity"]').val() == "") return;

    orderPrice += parseInt($(elem).find('input[name="foodQuantity"]').val()) * parseFloat($(elem).find('input[name="foodPrice"]').val());
  });
  
  $('form label[name="orderPrice"]').html("$" + orderPrice);
}

function getMenus_2() {
  var menus = [];

  var isFilled = true;
  $('form #cart_menu_wrapper div[name="menu"]').each((index, elem) => {

    var imgUrl = $(elem).find('input[name="foodPicUrl"]').val();
    var menu = {
      nFoodId: parseInt($(elem).find('input[name="menu_id"]').val()),
      st_foodPicUrl: imgUrl == "" ? "" : imgUrl,
      st_foodName: $(elem).find('input[name="foodName"]').val(),
      nCartedCount: $(elem).find('input[name="foodQuantity"]').val()? parseInt($(elem).find('input[name="foodQuantity"]').val()) : 0,
      dFoodPrice: parseFloat($(elem).find('input[name="foodPrice"]').val()),
    }
    menus.push(menu);
  });
  
  return menus;
}

function getMenus() {
  var menus = [];

  var isFilled = true;
  $('form #cart_menu_wrapper div[name="menu"]').each((index, elem) => {
    
    if ($(elem).find('input[name="foodQuantity"]').val() == "") {
      isFilled = false 
      return;
    }
    var imgUrl = $(elem).find('input[name="foodPicUrl"]').val();
    var menu = {
      nFoodId: parseInt($(elem).find('input[name="menu_id"]').val()),
      st_foodPicUrl: imgUrl == "" ? "" : imgUrl,
      st_foodName: $(elem).find('input[name="foodName"]').val(),
      nCartedCount: parseInt($(elem).find('input[name="foodQuantity"]').val()),
      dFoodPrice: parseFloat($(elem).find('input[name="foodPrice"]').val()),
    }
    menus.push(menu);
  });
  
  if (isFilled) return menus;
  else return [];
}

// submit data
$('#modalOrder').find('form button').on('click', function() {
  
  var menus = getMenus();

  if (menus.length == 0) {
    alert('Please Select Food!');
    return;
  }
  console.log(menus);

  var orderPrice = 0;
  menus.forEach(menu => {
    orderPrice += menu.dFoodPrice * menu.nCartedCount;
  });

  console.log(orderPrice);
  
  var modal = $('#modalOrder');
  var orderID = modal.find('input[name="orderId"]').val();

  if (!orderID) {
    // insert
    var orderID = orderDBRef.doc().id;
    
    var docData = {
      deviceId: "manager",
      isCurrent: true,
      orderID: orderID,
      orderPrice: orderPrice,
      orderStatus: 0,
      restaurant_id: restaurant_id,
      tableNum: parseInt(modal.find('form select[name="tables"]').val()),
      timeStamp: firebase.firestore.FieldValue.serverTimestamp(),
      userType: 'manager',
      userName: staff_name,
      menus: menus
    }

    orderDBRef.doc(orderID)
      .set(docData)
      .then(function() {
        alert("Order successfully written!");
        loadTable();
      })
      .catch(function(error) {
        console.log(error);
      });

  } else {
    // update
    var docData = {
      orderPrice: orderPrice,
      menus: menus
    }
    orderDBRef.doc(orderID)
      .update(docData)
      .then(function() {
        alert("Order successfully Updated!");
        loadTable();
      })
      .catch(function(error) {
        console.log(error);
      });
  }
  
  $('#modalOrder').modal('hide');
})

jQuery(function(){

  $('#dt_orders').dataTable({
    responsive: true,
    processing: true,
    // serverSide: false,
    // pageLength: 10,
    order: [], //Initial no order.
    columns: columns,
    data: []
  });
  
  updateUINewOrderWrapper();

  loadTable();
});
