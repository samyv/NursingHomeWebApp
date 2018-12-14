
$(function () {
	let scanner = new Instascan.Scanner({ video: document.getElementById('video') });
	scanner.addListener('scan', function (content) {
		console.log(content);
	});
	Instascan.Camera.getCameras().then(function (cameras) {
		if (cameras.length > 0) {
			scanner.start(cameras[0]);
		} else {
			console.error('No cameras found.');
		}
	})
	$('#scan').click(function () {
		console.log(scanner.scan())
	})
})


