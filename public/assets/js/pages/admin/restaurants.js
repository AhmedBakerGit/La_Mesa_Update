
var baseTableUrl = window.location.origin + '/ajax/admin/restaurants/';

$('#dt_restaurants').dataTable({
  columnDefs: [
    { orderable: false, targets: 1 },
    { orderable: false, targets: 2 },
    { orderable: false, targets: 3 },
    { orderable: false, targets: 4 },
    { orderable: false, targets: 5 },
    { orderable: false, targets: 6 }
  ]
});

$('#btn_add').on('click', () => {
  clearModalConent();

  var modal = $('#modalRestaurant');
  modal.find(".modal-title").text("Add New Restaurant");

  $('#modalRestaurant').modal('show');
})

function showEditModal(cObj) {
  var restID = $(cObj).data("id");
  apiComm.PostApiCall(baseTableUrl+restID, 'editRestaurant');
}


function editRestaurant(data) {
  clearModalConent();

  var modal = $('#modalRestaurant');
  modal.find(".modal-title").html(data.restName);
  modal.find("input[name='restaurant_id']").val(data.id);
  modal.find("input[name='restName']").val(data.restName);
  modal.find("input[name='restAddress']").val(data.restAddress);
  modal.find("input[name='restTelephone']").val(data.restTelephone);
  modal.find("input[name='restCellphone']").val(data.restCellphone);
  modal.find("textarea[name='restDescription']").val(data.restDescription);

  $('#modalRestaurant').modal('show');
}

function deleteRestaurant(cObj) {
  var restID = $(cObj).data("id");
  var restName = $(cObj).data("name");

  swal({
    title: "Are you sure delete" +  restName +"?",
    // text: "Are you sure delete Restaurant?",
    type: "warning",
    showCancelButton: !0,
    confirmButtonText: "Yes",
    cancelButtonText: "Cancel",
    reverseButtons: !0
  }, function (event) {
    if (event) {
      apiComm.PostApiCall(baseTableUrl+restID+"/delete", 'deleteCallback');
    }
  });
}

function deleteCallback(data) {
  window.location.href = window.location.origin + '/admin/restaurants/';
}

function clearModalConent() {
  var modal = $('#modalRestaurant');
  modal.find(".modal-title").html("");
  modal.find("input[name='restaurant_id']").val("");
  modal.find("input[name='restName']").val("");
  modal.find("input[name='restAddress']").val("");
  modal.find("input[name='restTelephone']").val("");
  modal.find("input[name='restCellphone']").val("");
  modal.find("textarea[name='restDescription']").val("");
}
