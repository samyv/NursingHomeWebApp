<!DOCTYPE html>
<html>
<head>
    <title>{page_title}</title>
    <link href="<?=base_url()?>assets/css/loginResident.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
<!--    <script src="--><?//=base_url()?><!--assets/js/Resident/login.js"></script>-->
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
	<script src="<?=base_url()?>javascript/instascan.min.js"></script>
</head>
<body>
<div class="logo">
	<div id="title">GraceAge</div><br>
	<div id="subtitle">Providing better care</div>
</div>
<video id="camera-stream" autoplay></video>
<button onclick=autoLogin()></button>
<img id = qrpicture class = qrpicture src= '<?=base_url()?>assets/images/qrcode.png' alt="QR-code">
<img id = qrmarker class = qrmarker src= '<?=base_url()?>assets/images/marker.png' alt="QR-code">
<p class = explanation>Hou je QR-code in het groene vierkant</p>
<script>

	let scanner = new Instascan.Scanner({ video: document.getElementById('camera-stream') });
	scanner.addListener('scan', function (content)
    {
		$contentt = content;
		$.ajax({
			url: '<?=base_url()?>Resident/loginQr/' + $contentt,
			success: function (content,error) {
				let x = document.getElementById('camera-stream');
				x.remove();
				window.location.replace("Resident/tutorial");
			}
		});
	});

    scanner.addListener('active', stylescanner);

    function stylescanner()
    {
        // Style the scanner window
        let cam = document.getElementById('camera-stream');
        let s = cam.style;
        s["width"] = "100%";

        // only make the qr code and marker visible when the scanner is loaded
        let marker = document.getElementById('qrmarker');
        s = marker.style;
        s["display"] = "inline-block";

        let qrcode = document.getElementById('qrpicture');
        s = qrcode.style;
        s["display"] = "inline-block";
    }

    Instascan.Camera.getCameras().then(function (cameras) {
			if (cameras.length > 0) {
				scanner.start(cameras[0]);
			} else {
				console.error('No cameras found.');
			}
		}).catch(function (e) {
			console.error(e);
		});

	function autoLogin(){
		$.ajax({
			url: '<?=base_url()?>Resident/loginQr/' + "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHI",
			success: function (content,error) {
				let x = document.getElementById('camera-stream');
				x.remove();
				window.location.replace("Resident/tutorial");
				// console.log(content)
				// console.log(JSON.parse("["+content+"]")[0]);
				// console.log(error);
			}
		});
	}

</script>
</body>
</html>
