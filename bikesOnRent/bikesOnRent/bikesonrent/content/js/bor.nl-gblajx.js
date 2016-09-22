var mthdG = "GET";
var mthdP = "POST";
function jcnlGlobalAjax(mthd, dt, url, scscalbck, falcalbck) {
    var xmlhttp;
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200) {
                scscalbck(xmlhttp.responseText);
            }
            else {
                falcalbck(xmlhttp.responseText);
            }
        }
    }
    xmlhttp.open(mthd, url, true);
    xmlhttp.setRequestHeader("Content-Type", "application/json");
    //xmlhttp.setRequestHeader('Authorization', 'Basic ' + btoa('rbktw222:smalwonder'));
    xmlhttp.send(dt);
}

//callback for all ajax failures
function ajaxFailureCallback(dt) {

}