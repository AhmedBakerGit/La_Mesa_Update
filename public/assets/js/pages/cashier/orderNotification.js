var orderDBRef = firebase.firestore()
    .collection("restaurants")
    .doc("" + restaurant_id)
    .collection("orders");

    
// New Order
var isLoad = true;
var nNewOrder = 0;

orderDBRef
  .where("orderStatus", "==", 0)
  .where("userType", "in", ["android_user", "manager"])
  // .where("userType", "==", "manager")
  .onSnapshot(function(querySnapshot) {
    if (isLoad) {
      isLoad = false
      return;
    }
    querySnapshot.docChanges().forEach(function(change) {
      if (change.type === "added") {
        nNewOrder ++;
        console.log(nNewOrder);
        console.log(change.doc.data());
        $('#newOrderCount').html("" + nNewOrder);

        if ($('#btnNewOrderArrived').length) {
          updateUINewOrderWrapper();
        }
      }
      // if (change.type === "modified") {
      //     console.log("modified");
      // }
      // if (change.type === "removed") {
      //   console.log("removed");
      // }
    });
  });

$('#newOrderCountWrapper').on('click', function() {
  window.location.href = window.location.origin + "/cashier/orders";
})

// Bill Request
var isBillLoad = true;
var nNewBillRequest = 0;

orderDBRef
  .where("orderStatus", "==", 4)
  .onSnapshot(function(querySnapshot) {
    if (isBillLoad) {
      isBillLoad = false
      return;
    }
    querySnapshot.docChanges().forEach(function(change) {
      if (change.type === "added") {
        nNewBillRequest ++;
        showBillCount();

        var arrBillData = [];
        var billData = localStorage.getItem('billData');
        if (billData != null) {
          var arr = JSON.parse(billData);
          arrBillData = arr;
        }

        arrBillData.push(change.doc.data());
        
        localStorage.setItem('billData', JSON.stringify(arrBillData));
        console.log(arrBillData);

        drawBillRequestNotiBox(arrBillData);
        
        if ($('#btnNewOrderArrived').length) {
          loadTable();;
        }
      }

      if (change.type === "removed") {
        nNewBillRequest --;
        showBillCount();

        var arrBillData = [];

        var billData = localStorage.getItem('billData');
        if (billData == null) return;

        var arr = JSON.parse(billData);

        var data = change.doc.data();
        var arrBillData = arr.filter( el => el.orderID !== data.orderID );
        
        localStorage.setItem('billData', JSON.stringify(arrBillData));
        console.log(arrBillData);

        drawBillRequestNotiBox(arrBillData);
      }
    });
  });

function showBillCount() {
  if (nNewBillRequest == 0) $('#newBillCount').html("");
  else $('#newBillCount').html("" + nNewBillRequest);
}

function drawBillRequestNotiBox(arrBillData) {
  nNewBillRequest = arrBillData.length;
  showBillCount()

  $('#billDropdownList').empty();
  if (arrBillData.length == 0) {
    var h = `<li class="header"><strong>No Bill Requests.</strong></li>`;
    $('#billDropdownList').append(h);

    return;
  }
  var h = `<li class="header"><strong>You have ` + arrBillData.length + ` Bill Requests.</strong></li>`;

  arrBillData.forEach(data => {
    var time = data.timeStamp.seconds;
    dateObj = new Date(time * 1000);
    var month = dateObj.getMonth() + 1; //months from 1-12
    var day = dateObj.getDate();
    var year = dateObj.getFullYear();
    var hours = dateObj.getHours();
    var minutes = dateObj.getMinutes();
    var seconds = dateObj.getSeconds();

    var newdate = year + "-" + month + "-" + day + " / " + hours + ":" + minutes + ":" + seconds;

    h += `
    <li>
        <a>
            <div class="media">
                <div class="media-left">
                    <i class="icon-info text-warning"></i>
                </div>
                <div class="media-body">
                    <p class="text">Order ID: &nbsp; <strong>` + data.orderID + `</strong></p>
                    <span class="timestamp">` + newdate +`</span>
                </div>

            </div>
        </a>
    </li>
    `;
  })

  $('#billDropdownList').append(h);
}

$('#billDropdownList li').on('click', function(){
  console.log("===============")
  var txt= ($(this).find('p[class="text"] strong')).text();
  console.log(txt);
});

var stRbillReqests = localStorage.getItem('billData');
if (stRbillReqests != null) drawBillRequestNotiBox(JSON.parse(stRbillReqests))
else drawBillRequestNotiBox([]);
  