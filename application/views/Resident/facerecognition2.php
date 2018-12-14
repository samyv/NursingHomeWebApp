<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        video {
            height: 400px;
            width: 600px;
            border: thin solid silver;
        }
    </style>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
<button id="camera">Show Camera</button>
<button id="capture">Start Capturing</button>
<input placeholder="Enter Name" type="text" class="validation" id="ip">
<video id="video" autoplay>
</video>
<canvas id="myCanvas" width="500"  height="400"></canvas>
<script>
    var canvas = document.getElementById("myCanvas");
    var ctx = canvas.getContext("2d");
    document.getElementById("camera").addEventListener('click', capture);
    document.getElementById("capture").addEventListener('click', snapshot);

    function capture() {
        navigator.mediaDevices.getUserMedia({video: true})
            .then(function (stream) {
                const video = document.querySelector("video");
                video.srcObject = stream;
            })
            .catch(e => console.log("error" + e));
    }


    function snapshot() {

        ctx.drawImage(video, 0,0, canvas.width, canvas.height);
        var img1 = new Image();
        img1.src = canvas.toDataURL();
        var ip = document.getElementById('ip').value;
        datad = "{\r\n    \"image\":\"" + img1.src+ "\",\r\n    \"subject_id\":\"" + ip + "\",\r\n    \"gallery_name\":\"Arti\"\r\n}";
        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "https://api.kairos.com/enroll",
            "method": "POST",
            "headers": {
                "content-type": "application/json",
                "app_id": "97b66377",
                "app_key": "facdd610c757d99089f1329a135fb832",
                "cache-control": "no-cache"
            },
            "processData": false,
            "data": datad
        }

        $.ajax(settings).done(function (response) {
            //
            if((response.images[0].transaction.status) == "success"){
                console.log("success");
            }
            else{
                console.log("fail");
            }
        });
        //console.log(img1.src);
    }


</script>
</body>
</html>