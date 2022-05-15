// function initMap() {
//     const myLatLng = { lat: -25.363, lng: 131.044 };
//     const map = new google.maps.Map(document.getElementById("map"), {
//         zoom: 4,
//         center: myLatLng,
//     });

//     new google.maps.Marker({
//         position: myLatLng,
//         map,
//         title: "Hello World!",
//     });
// }

// window.initMap = initMap;

function initMap(lati, long) {
    const myLatLng = { lat: lati, lng: long };
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 4,
        center: myLatLng,
    });

    new google.maps.Marker({
        position: myLatLng,
        map,
        title: "Hello World!",
    });
}

window.initAddress = initMap(45.225, 48.577);

// $(function () {
//     var $join = $("input[name=btnSubmit]");
//     var processJoin = function (element) {
//         if(element.id == "choiceno") {
//             $join.attr("disabled", "disabled");
//         }
//         else {
//             $join.removeAttr("disabled")
//         }
//     };

//     $(":radio[name=choice]").click(function () {
//         processJoin(this);
//     }).filter(":checked").each(function () {
//         processJoin(this);
//     });
// });
function select_change() {
    var index = document.getElementById("form_action").selectedIndex;
    var option = document.getElementsByTagName("option")[index].value;
    alert("Form action changed to " + option);
}
function myfunction() {
    if (validation()) {
        var x = document.getElementById("form_action").selectedIndex;
        var action = document.getElementsByTagName("option")[x].value;
        if (action !== "") {
            document.getElementById("form_id").action = action;
            document.getElementById("form_id").submit();
        } else {
            alert("Set form action");
        }
    }
}

