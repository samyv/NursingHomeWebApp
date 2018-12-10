<link rel="stylesheet" href="<?=base_url();?>assets/css/floorView.css">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="assets/css/transitions.css">

<body>
<div class ="grid-container fade-in">
	<div class = "title">
		<p>Please select the desired resident</p>
	</div>
</div>
</body>
<script>
	$(function () {
		let amount = 0+<?php print_r(sizeof($residents));?>;
		let residents = <?php print_r(json_encode($residents));?>;
		let rooms = [];
		const unique = (value, index, self) => {
			return self.indexOf(value) === index;
		}
		rooms = residents.map(a => a.room).filter(unique);
		var sorted = residents.sort(function(a,b){return a.room - b.room});
		let parent = $("<div></div>");
		parent.addClass("roomContainer");
		for(let i = 1;i<=rooms.length;i++) {

			let room = rooms[i-1]
			var found = residents.filter(e => e.room == room);
			//BIG CHILD
			let child = $("<div></div>");
			let z = room.split("");
			let roomNumber = "room"+(z[1]==0?'':z[1])+""+z[2];
			child.addClass(roomNumber);
			child.addClass("room");

			//NUMBER
			let number = $("<div></div>");
			number.addClass("roomNr");
			let h = $("<h2></h2>").text(room);
			number.append(h);
			child.append(number);
			//images
			for (let j = 1; j <=found.length; j++) {
				let imagediv = $("<div></div>");
				imagediv.addClass("image" + j);
				imagediv.attr("roomid", i);
				imagediv.attr("id",j-1);
                let x = parseInt(sessionStorage.getItem('floorSelected'))
                let y = parseInt(imagediv.attr('roomid'))
                let nummer = x*100+y;
                let room = residents.filter(e => e.room == nummer)[parseInt(imagediv.attr('id'))];
				imagediv.click(function () {
					sessionStorage.setItem("residentSelected",room['residentID']);
					location.href='resDash/?id='+room['residentID'];

				})
				let name = $("<h3></h3>").text(found[j-1]['firstname']);
				imagediv.append(name);

				$.ajax({
                    url: '<?=base_url()?>/caregiver/getResidentImage/?id=' + room['residentID'],
                    dataType: 'text',
                    success: function ($image) {
                        image.attr("src", 'data:image/jpg;base64, ' + $image);
                    }
                });

				let image = $("<img>");
				image.attr("width", "50");
				image.attr("height", "50");
				imagediv.append(image)
				child.append(imagediv);
			}
			parent.append(child);

			function setClick(id) {
				sessionStorage.setItem("selectedCaregiver",id);
			}

		}
		$(".grid-container").append(parent);
	})
</script>


