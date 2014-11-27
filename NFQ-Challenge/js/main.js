/* NFQ User management system JS
 @author - KestutisIT
 @date - 2014.11.27
 @version - 1.0
 */

var NFQInventoryDebug = false;

// DEFINE THE LOCATION
if(document.domain == "localhost" || document.domain == "127.0.0.1")
{
    var SITE_URL = "http://localhost/GitHub/ProgrammingAssignments/NFQ-Challenge/";
} else
{
    var SITE_URL = "http://nfq.matuliauskas.lt/";
}
var API_URL = SITE_URL + "api/";

/***/ if(NFQInventoryDebug)
/***/ {
/***/ 	console.log(API_URL);
/***/ }


NFQLoadPageBlocks();

function NFQLoadPageBlocks() {
    if (jQuery('.holder .users')[0]) {
        // Do something if class exists
        NFQRefreshDashboard("users");
    } else {
        // Do something if class does not exist
    }

    if (jQuery('.holder .groups')[0]) {
        // Do something if class exists
        NFQRefreshDashboard("groups");
    } else {
        // Do something if class does not exist
    }
}

function NFQRefreshDashboard(NFQRefreshAction)
{
    var jSON_params = {};

    switch(NFQRefreshAction)
    {
        case "users":
            jSON_params = {
                "command": "get_users",
                "data": ""
            };
            break;

        case "groups":
            jSON_params = {
                "command": "get_groups",
                "data": ""
            };
            break;
    }

    // setup ajax
    jQuery.ajaxSetup({
        dataType: "json",
        refreshAction: NFQRefreshAction,
        url: API_URL,
        data: jSON_params
    });

    // Actual ajax call - member or both
    jQuery.ajax({
        beforeSend: function(ajaxOptionsUsed) { NFQShowSpinner(this.refreshAction) },
        success: function(data, status) { NFQSuccessRefreshFunc(this.refreshAction, data, status) }
    });
}

function NFQShowSpinner(refreshAction, ajaxOptionsUsed)
{
    /***/ if(NFQInventoryDebug)
    /***/ {
    /***/ 	console.log("BEFORE START - SHOW SPINNER, refreshAction:"+ refreshAction);
    /***/ }

    //var ajaxLoaders = null;

    switch(refreshAction)
    {
        case "users":
            jQuery('.holder .'+refreshAction).text('LOADING...').addClass('ajax_blue-loader');
            break;

        case "groups":
            jQuery('.holder .'+refreshAction).text('LOADING...').addClass('ajax_blue-loader');
            break;
    }
}


function NFQSuccessRefreshFunc(refreshAction, data, status)
{
    /***/ if(NFQInventoryDebug)
    /***/ {
    /***/ 	console.log("OK 1 - RELOAD CONTENT RECEIVED, refreshAction:"+ refreshAction);
    /***/ }

    //var obj = jQuery.parseJSON(data);
    var obj = data;
    console.log(obj.returnedData);

    switch(refreshAction)
    {
        case "users":
            jQuery('.holder .'+refreshAction).removeClass('ajax_blue-loader').html(obj.returnedData);
            break;

        case "groups":
            jQuery('.holder .'+refreshAction).removeClass('ajax_blue-loader').html(obj.returnedData);
            break;
    }
}