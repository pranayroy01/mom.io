var target,r="",temp;

function toTitleCase(str)
{
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

window.onload = function () {
    /*var values = [
        {
            value: 70,
            color: "#F7464A",
            highlight: "#FF5A5E",
            label: "Domestic Helpers"
    },
        {
            value: 53,
            color: "#46BFBD",
            highlight: "#5AD3D1",
            label: "Construction Workers"
    },
        {
            value: 23,
            color: "#FDB45C",
            highlight: "#FFC870",
            label: "Factory Workers"
    }
    ];
    makechart(values);*/
    console.log("Loaded");
    var xmlhttp;
    if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    document.getElementById("searchbox").onkeyup = function () {
        xmlhttp.open("POST", "query.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("query=" + this.value);
        temp = this;
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                r = xmlhttp.responseText;
                if (r == "demoaccidents") {
                    demoAccidents();                }
                else if (r == "summarizefeedbacks") {
                    document.getElementById("datac").innerHTML = "<img src='word.jpeg'>";
                }
                else {
                    document.getElementById("charttitle").textContent=toTitleCase(temp.value);
                    console.log(r);
                    r=eval(r);
                    var x = document.createElement("ol");
                    document.getElementById("datac").innerHTML = ""
                    document.getElementById("datac").appendChild(x);
                    if(r!=""&&typeof r!="undefined"){
                        if(r["type"]=="list"){
                            for(var i=0;i<r["data"].length;i++){
                                var y = document.createElement("li");
                                y.textContent = r["data"][i];
                                x.appendChild(y);
                            }
                        }
                        else if(r["type"]=="pie"||r["type"]=="bar"){
                            makechart(r["type"],r["data"]);
                        }

                    }
                    else{
                        //document.getElementById("datac").innerHTML = "";
                        document.getElementById("datac").innerHTML = "<p>Accidents in May 2014</p><p>Accidents by Month</p><p>Summarize Feedbacks</p><p>Workspaces Prone to Accidents</p><p>Workers by Age Group</p><p>Accidents in May</p><p></p><p></p>";
                    }
                }
            }
        }

    }
}

function makechart(type,data) {
    var d = document.createElement("canvas");
    d.setAttribute("id", "chart");
    d.innerHTML = " ";
    document.getElementById("datac").appendChild(d);
    var ctx = d.getContext("2d");
    ctx.canvas.height = document.getElementById("data").offsetHeight - 90;
    ctx.canvas.width = ctx.canvas.height;
    if(type=="pie"){
        var dchart = new Chart(ctx).Doughnut(data, {
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;<%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        });
    }
    else if(type=="bar"){
        var dchart = new Chart(ctx).Bar(data,{
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;<%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        });
    }
    var l = dchart.generateLegend();
    var ld = document.createElement("div");
    ld.setAttribute("id", "legend");
    ld.innerHTML = l;
    document.getElementById("datac").appendChild(ld);
}

function drawMap()
{
    document.getElementById("data").innerHTML = "<div id='map-canvas' style='height:100%'></div>";

    geocoder.geocode({ 'address': 'Singapore' }, function (results, status)
    {
        if (status == google.maps.GeocoderStatus.OK)
        {
            latlng = results[0].geometry.location;
            var mapOptions = {
                zoom: 11,
                center: latlng
            }
            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        }
        else
        {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

var add =
{
    'marker':
    {
        'atAdd': function (addr)
        {
            geocoder.geocode({ 'address': addr }, function (results, status)
            {
                if (status == google.maps.GeocoderStatus.OK)
                {
                    add.marker.atCoord(results[0].geometry.location);
                } else
                {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        },

        'atCoord': function (latlng)
        {
            if (map.zoom < 17) map.setZoom(17);
            map.panTo(latlng);
            //map.setCenter(results[0].geometry.location);
            overlays.push(new google.maps.Marker({
                map: map,
                position: latlng,
                animation: google.maps.Animation.DROP
            }));

            /*var elementID = overlays.length - 1;
            overlays[elementID].setAnimation(google.maps.Animation.BOUNCE);
            setTimeout(function () { overlays[elementID].setAnimation(null); }, 3000);*/
        }
    },

    'circle':
    {
        'atAdd': function (addr, r)
        {
            if (typeof (r) == 'undefined') r = 10;
            geocoder.geocode({ 'address': addr }, function (results, status)
            {
                if (status == google.maps.GeocoderStatus.OK)
                {
                    add.circle.atCoord(results[0].geometry.location, r);
                } else
                {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        },

        'atCoord': function (latlng, r)
        {
            if (typeof (r) == 'undefined') r = 10;
            var circleOptions = {
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map,
                center: latlng,
                radius: r
            };
            // Add the circle to the map.
            if (map.zoom < 17) map.setZoom(17);
            map.panTo(latlng);
            overlays.push(new google.maps.Circle(circleOptions));
        }
    },

    'removeAllOverlays': function ()
    {
        while (overlays[0])
        {
            overlays.pop().setMap(null);
        }
    }
}

function demoAccidents()
{
    document.getElementById("data").innerHTML = "<iframe src='d3/home.html' style='width: 100%; height: 100%; border:none;' id='frame'></iframe>";
    document.getElementById("frame").contentWindow.querySelector("#chart svg").setAttribute(height, document.getElementById("frame").style.height);
}

