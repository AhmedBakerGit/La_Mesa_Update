
// New Order
function updateUINewOrderWrapper() {
  if(nNewOrder > 0) {
    $('#btnNewOrderArrived').css('visibility', 'visible');
  } else {
    $('#btnNewOrderArrived').css('visibility', 'hidden');
  }

  $('#btnNewOrderArrived').val(nNewOrder + " New Orders");
}

$('#btnNewOrderArrived').on('click', function() {
  nNewOrder = 0;
  updateUINewOrderWrapper();
  $('#newOrderCount').html("");
  // loadTable();
  // window.location.href = window.location.origin + "/cashier/orders";
})

// Left Order List ( Queuing )
function getLeftDataAndDrawUI() {
  // get left order data
  orderDBRef
    .where("orderStatus", "==", 0)
    .orderBy('timeStamp').limit(500)
    .get()
    .then(function(querySnapshot) {
      
      var dataSet = [];
      
      querySnapshot.forEach(function(doc) {
          // doc.data() is never undefined for query doc snapshots
          // console.log(doc.id, " => ", doc.data());
          dataSet.push(doc.data());
      });

      drawLeftUI(dataSet);
    })
    .catch(function(error) {
        console.log("Error getting documents: ", error);
    });
}

function drawLeftUI(dataSet) {
  $('#left_ui').empty();
  var html = '';
  dataSet.forEach((data) => {
    var time = data.timeStamp.seconds;
    dateObj = new Date(time * 1000);
    var month = dateObj.getMonth() + 1; //months from 1-12
    var day = dateObj.getDate();
    var year = dateObj.getFullYear();
    var hours = dateObj.getHours();
    var minutes = dateObj.getMinutes();
    var seconds = dateObj.getSeconds();

    var orderTime = hours + ":" + minutes + ":" + seconds;

    html += 
      `<li>
        <div class="feeds-left"><i class="fa fa-shopping-basket"></i></div>
        <div class="feeds-body">
            <h4 class="title"># ID</h4>
            <div class="d-flex justify-content-between">
                <small>` + data.orderID + `</small>
                <small class="float-right text-muted">` + orderTime + `</small>
            </div>
        </div>
      </li>`;
  })

  $('#left_ui').append(html);
}

// Right Order List ( Preparing )
function getRightDataAndDrawUI() {
  // get right order data
  orderDBRef
    .where("orderStatus", "==", 2)
    .orderBy('timeStamp').limit(3)
    .get()
    .then(function(querySnapshot) {
      
      var dataSet = [];
      
      querySnapshot.forEach(function(doc) {
          // doc.data() is never undefined for query doc snapshots
          // console.log(doc.id, " => ", doc.data());
          dataSet.push(doc.data());
      });

      drawRightUI(dataSet);
    })
    .catch(function(error) {
        console.log("Error getting documents: ", error);
    });
}

function drawRightUI(dataSet) {
  $('#right_ui').empty();
  var html = '';
  dataSet.forEach(data => {
    var time = data.timeStamp.seconds;
    dateObj = new Date(time * 1000);
    var month = dateObj.getMonth() + 1; //months from 1-12
    var day = dateObj.getDate();
    var year = dateObj.getFullYear();
    var hours = dateObj.getHours();
    var minutes = dateObj.getMinutes();
    var seconds = dateObj.getSeconds();

    var orderTime = hours + ":" + minutes + ":" + seconds;

    html += 
      `<div class="card" style="margin-bottom: 10px;">
        <div class="body">
            <div class="row">
                <div class="col-sm-3">
                    <div class="review-block-name"><a href="javascript:void(0);"><h4>Order Info</h4></a></div>
                    <span>Table: &nbsp` + data.tableNum +`<br>
                        Time: &nbsp` + orderTime + `
                    </span>
                    <input name="finish" onclick="finishButtonClick(this)" data-id="` + data.orderID + `" type="button" class="btn btn-primary mt-4" style="width: 100px" value="Finish">
                </div>
                <div class="col-sm-9 food-list">
                    <table class="table table-striped" style="margin-bottom: 0px">`

    data.menus.forEach(menu => {
      html += `
        <tr>
            <td><img src="` + menu.st_foodPicUrl + `" width="40" height="40" alt="food-img"></td>
            <td>` + menu.st_foodName + `</td>
            <td>quantity: &nbsp ` + menu.nCartedCount + `</td>
        </tr>
      `;
    })
    html += `</table></div></div></div></div>;`
  });

  $('#right_ui').append(html);
}

function finishButtonClick(cObj) {
  var orderID = $(cObj).data('id');
  console.log(orderID);

  orderDBRef
    .doc(orderID)
    .update({orderStatus: 3})
    .then(function() {
      
      orderDBRef
        .where("orderStatus", "==", 0)
        .orderBy('timeStamp').limit(1)
        .get()
        .then(function(querySnapshot) {
          
          var id = "";
          
          querySnapshot.forEach(function(doc) {
              id = doc.id;
          });
          
          if (id == "") {
            getLeftDataAndDrawUI();
            getRightDataAndDrawUI();
          } else {
            orderDBRef
            .doc(id)
            .update({orderStatus: 2})
            .then(function() {
              getLeftDataAndDrawUI();
              getRightDataAndDrawUI();
            })
            .catch(function(error) {
                // The document probably doesn't exist.
                console.error("Error updating document: ", error);
            });
          }
        })
        .catch(function(error) {
            console.log("Error getting documents: ", error);
        });
    })
    .catch(function(error) {
        // The document probably doesn't exist.
        console.error("Error updating document: ", error);
    });
  
}

// document load
jQuery(function(){
  updateUINewOrderWrapper();

  getLeftDataAndDrawUI();
  getRightDataAndDrawUI();
});