
var requestDBRef = firebase.firestore()
    .collection("restaurants")
    .doc("" + restaurant_id)
    .collection("requests");

var isRequestLoad = true;
var nNewRequest = 0;

requestDBRef
  .orderBy('timeStamp').limit(500)
  .onSnapshot(function(querySnapshot) {
    if (isRequestLoad) {
      isRequestLoad = false
      return;
    }
    querySnapshot.docChanges().forEach(function(change) {
      if (change.type === "added") {
        nNewRequest ++;
        console.log(nNewRequest);
        console.log(change.doc.data());
        if (nNewRequest == 0) $('#newRequestCount').html("");
        else $('#newRequestCount').html("" + nNewRequest);

        if ($('#btnRequestArrived').length) {
          updateUiNewRequestWrapper();
        }
      }

      if (change.type === "removed") {
        if (nNewRequest > 0) nNewRequest --;
        if (nNewRequest == 0) $('#newRequestCount').html("");
        else $('#newRequestCount').html("" + nNewRequest);

        if ($('#btnRequestArrived').length) {
          updateUiNewRequestWrapper();
          loadRequestTable();
        }
      }
    });
  });

  $('#newRequestCountWrapper').on('click', function() {
    window.location.href = window.location.origin + "/cashier/request";
  })