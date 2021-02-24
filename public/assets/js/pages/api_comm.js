/* This is where we will put our custom js */
/* admCom is for Admin Common namespace for functions*/

var apiComm = {
  PostApiCall: function (functionUrl, functionName, params, clickedObject, contentType, processData ) {
    var apiParams = "";
    if (params) { apiParams = params; }

    var apiContentType = "application/x-www-form-urlencoded; charset=UTF-8";
    if (contentType) {
      if(contentType === 'false'){
        apiContentType = false;
      } else {
        apiContentType = contentType;
      }
    }

    var apiProcessData = true;
    if (processData) {
      if(processData === 'false'){
        apiProcessData = false;
      } else {
        apiProcessData = processData;
      }
    }

    // console.log('apiContentType ===>', apiContentType);
    // console.log('apiProcessData ===>', apiProcessData);

    $.ajax({
        method: 'post',
        url: functionUrl,
        data: apiParams,
        contentType: apiContentType,
        processData: apiProcessData,
        dataType : "json",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          apiComm.apiResultFunction(data, functionName, clickedObject );
        },
        error: function (res) {
          console.log(res);
          //apiComm.globalAlertModal('Error', 'Unknown Error!');

        }
    });
  },
  GetApiCall: function (functionUrl, functionName, paramsArray, contentType, clickedObject) {
    //debugger;
    var apiParams = "";
    var apiType = 'GET';
    var apiContentType = "application/json; charset=utf-8";
    if (paramsArray) { apiParams = paramsArray; }
    if (contentType) { apiContentType = contentType; }

    $.ajax({
        data: apiParams,
        type: apiType,
        url: functionUrl,
        contentType: apiContentType,
        success: function (data) {
           try {
                var namespaces = functionName.split(".");
                if (namespaces.length == 1) {
                    window[namespaces[0]](data, clickedObject);
                }
                if (namespaces.length == 2) {
                    window[namespaces[0]][namespaces[1]](data, clickedObject);
                }
            } catch (e) {
                console.log("Error: namespace (" + functionName + ") not found");
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
  },
  apiResultFunction: function(data, functionName, clickedObject) {
    try {
        var namespaces = functionName.split(".");
        if (namespaces.length == 1) {
            window[namespaces[0]](data, clickedObject);
        }
        if (namespaces.length == 2) {
            window[namespaces[0]][namespaces[1]](data, clickedObject);
        }
    } catch (e) {
        console.log("Error: namespace (" + functionName + ") not found");
    }
  }
};
