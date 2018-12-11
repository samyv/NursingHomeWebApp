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
	<script src="../a18ux02/javascript/instascan.min.js"></script>
</head>
<body>
<div class="logo">
	<div id="title">GraceAge</div><br>
	<div id="subtitle">Providing better care</div>
</div>
<video id="camera-stream" autoplay></video>
	<script>
		$(function () {
			var video = document.querySelector('#camera-stream');
			start_camera = document.querySelector('#start-camera');
			navigator.getMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);

			if (!navigator.getMedia)
			{
				displayErrorMessage("Your browser doesn't have support for the navigator.getUserMedia interface.");
			}
			else
				{

				// Request the camera.
				navigator.getMedia(
					{
						video: true
					},
					// Success Callback
					function(stream){

						// Create an object URL for the video stream and
						// set it as src of our HTLM video element.
						video.src = window.URL.createObjectURL(stream);

						// Play the video element to start the stream.
						video.play();
						video.onplay = function() {
							showVideo();
						};

					},
					// Error Callback
					function(err){
						displayErrorMessage("There was an error with accessing the camera stream: " + err.name, err);
					}
				);
					start_camera.addEventListener("click", function(e) {
						e.preventDefault();
						console.log("clicked"
						)
						// Start video playback manually.
						video.play();
						showVideo();
					});
			}


			function showVideo() {
				// Display the video stream and the controls.
				hideUI();
				video.classList.add("visible");
			}

			function hideUI() {
				// Helper function for clearing the app UI.
				start_camera.classList.remove("visible");
				video.classList.remove("visible");
			}

	</script>
<script>
	let scanner = new Instascan.Scanner({ video: document.getElementById('camera-stream') });
	scanner.addListener('scan', function (content) {
		console.log(content);
		$contentt = content;
		$.ajax({
			url: '<?=base_url()?>Resident/loginQr/' + $contentt,
			success: function (content,error) {
				let x = document.getElementById('camera-stream');
				x.remove();
				window.location.replace("Resident/tutorial");
				// console.log(content)
				// console.log(JSON.parse("["+content+"]")[0]);
				// console.log(error);
			}
		});
	})
		Instascan.Camera.getCameras().then(function (cameras) {
			if (cameras.length > 0) {
				scanner.start(cameras[0]);
			} else {
				console.error('No cameras found.');
			}
		}).catch(function (e) {
			console.error(e);
		});

</script>
</body>
</html>
