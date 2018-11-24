<link rel="stylesheet" href="<?=base_url();?>assets/css/floorView.css">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<body>
<div class = "grid-container">

    <div class = "title">
        <p>Please select the desired room</p>
    </div>

    <div class = "room1">
        <div class = roomNr>
            <h2>Room 1</h2>
        </div>
        <div class = image1 onclick="location.href='roomView'">
            <h3>Alice</h3>
            <img src="assets/images/profile_picture.jpg" width="50" height="50" />
        </div>
        <div class = image2 onclick="location.href='roomView'">
            <h3>Bob</h3>
        <img src="assets/images/profile_picture.jpg" width="50" height="50" />
        </div>
    </div>
<!--
    <div class = "room2">
		<div class = roomNr>
			<h2>Room 2</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>

	<div class = "room3">
		<div class = roomNr>
			<h2>Room 3</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>

	<div class = "room4">
		<div class = roomNr>
			<h2>Room 4</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>

	<div class = "room5">
		<div class = roomNr>
			<h2>Room 5</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>

	<div class = "room6">
		<div class = roomNr>
			<h2>Room 6</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>

	<div class = "room7">
		<div class = roomNr>
			<h2>Room 7</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>

	<div class = "room8">
		<div class = roomNr>
			<h2>Room 8</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>

	<div class = "room9">
		<div class = roomNr>
			<h2>Room 9</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>

	<div class = "room10">
		<div class = roomNr>
			<h2>Room 10</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>

	<div class = "room11">
		<div class = roomNr>
			<h2>Room 11</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>

	<div class = "room12">
		<div class = roomNr>
			<h2>Room 12</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>

	<div class = "room13">
		<div class = roomNr>
			<h2>Room 13</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>

	<div class = "room14">
		<div class = roomNr>
			<h2>Room 14</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>

	<div class = "room15">
		<div class = roomNr>
			<h2>Room 15</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>
	<div class = "room16">
		<div class = roomNr>
			<h2>Room 16</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>
	<div class = "room17">
		<div class = roomNr>
			<h2>Room 17</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>
	<div class = "room18">
		<div class = roomNr>
			<h2>Room 18</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>
	<div class = "room19">
		<div class = roomNr>
			<h2>Room 19</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>
	<div class = "room20">
		<div class = roomNr>
			<h2>Room 20</h2>
		</div>
		<div class = image1>
			<h3>Alice</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
		<div class = image2>
			<h3>Bob</h3>
			<img src="assets/images/profile_picture.jpg" width="50" height="50" onclick="location.href='roomView'" />
		</div>
	</div>
-->
</div>
</body>
<script>
	$(function () {
		let amount = <?php print_r(sizeof($residents));?>;
		let residents = <?php print_r($residents[0]);?>
		//TODO: make object for every room

		//TODO:
		//for(let i = 1;i<=amount;i++){
		//	let residentLeft = <?php //print_r($residents[i-1]);?>//;
		//	let residentRight = <?php //print_r($residents[i]);?>//;
		//	//BIG CHILD
		//	let child = $("<div></div>");
		//	child.addClass("room"+i);
        //
		//	//NUMBER
		//	let number = $("<div></div>");
		//	number.addClass("roomNr");
		//	$('roomNr').append("<h2>Room "+i+"</h2>");
		//	child.append(number);
		//	for(let j = 1; j <3; j++){
		//		let image = $("<div></div>");
		//		image.addClass("image"+i);
		//		image
		//	}
        //
		//	$(".grid-container").append(child);
		//}
	})
</script>


