
var orderDBRef = firebase.firestore()
    .collection("restaurants")
    .doc("" + restaurant_id)
    .collection("orders");

var isLoad = true;
var isLoadCancel = true;
var nNewOrder = 0;

orderDBRef
  .where("orderStatus", "==", 0)
  .onSnapshot(function(querySnapshot) {
    if (isLoad) {
      isLoad = false

      if ($('#btnNewOrderArrived').length) {
          
        // current in order page
        updateUINewOrderWrapper();
        
        checkPreparingState();
      }

      return;
    }
    querySnapshot.docChanges().forEach(function(change) {
      if (change.type === "added") {
        nNewOrder ++;
        // console.log(nNewOrder);
        // console.log(change.doc.data());
        $('#newOrderCount').html("" + nNewOrder);

        if ($('#btnNewOrderArrived').length) {
          
          // current in order page
          updateUINewOrderWrapper();
          
          checkPreparingState();
        }
      }
    });
  });

// if order is canceled
orderDBRef
  .where("orderStatus", "==", 1)
  .onSnapshot(function(querySnapshot) {
    if (isLoadCancel) {
      isLoadCancel = false
      return;
    }
    querySnapshot.docChanges().forEach(function(change) {
      if (change.type === "added") {        
        console.log(change.doc.data());

        // Alert
        alert('Order "' + change.doc.data().orderID + '" is CANCELED');

        window.location.href = window.location.origin + "/kitchen/orders";
      }
    });
  });

$('#newOrderCountWrapper').on('click', function() {
  window.location.href = window.location.origin + "/kitchen/orders";
})

function checkPreparingState() {
  // check preparing status
  orderDBRef
    .where("orderStatus", "==", 2)
    .orderBy('timeStamp').limit(3)
    .get()
    .then(function(querySnapshot) {
      
      if (querySnapshot.size >= 3) {
        getLeftDataAndDrawUI();
        return;
      }
      var nlimit = 3 - querySnapshot.size;

      orderDBRef
        .where("orderStatus", "==", 0)
        .orderBy('timeStamp').limit(nlimit)
        .get()
        .then(async function(querySnapshot) {
          
          if (querySnapshot.size == 0) return;

          var docs = querySnapshot.docs;

          try {
            for (var i in docs) {
              await orderDBRef.doc(docs[i].id).update({orderStatus: 2});
            }
          } catch (error) {
            
          }

          getLeftDataAndDrawUI();
          getRightDataAndDrawUI();
        })
        .catch(function(error) {
            // The document probably doesn't exist.
            console.error("Error updating document: ", error);
        });
    })
    .catch(function(error) {
        // The document probably doesn't exist.
        console.error("Error updating document: ", error);
    });
}