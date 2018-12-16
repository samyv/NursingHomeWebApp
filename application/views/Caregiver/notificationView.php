<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/notificationView.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/transitions.css">
</head>

<body>
<div class = "grid-container fade-in">
    <div class = "title">
        <p>Notifications</p>
    </div>
		<!-- Tab links -->
	<div class="tab-container">
		<div class="tab">
				<button class="tablinks" id="defaultOpen" onclick="openNots(event, 'floorsTab')">floors</button>
				<button class="tablinks" onclick="openNots(event, 'residentsTab')">residents</button>
		</div>
		<div class=tab_content"">
			<!-- Tab content -->
			<div id="floorsTab" class="nots">
				<h3>Floors</h3>
				<div class = Floorlist></div>
			</div>
			<div id="residentsTab" class="nots">
				<h3>Residents</h3>
				<div class = Residentlist></div>
			</div>
		</div>
	</div>
</div>
</body>
</html>

<script>
	function openNots(evt, nots) {
		// Declare all variables
		var i, tabcontent, tablinks;

		// Get all elements with class="tabcontent" and hide them
		tabcontent = document.getElementsByClassName("nots");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}

		// Get all elements with class="tablinks" and remove the class "active"
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}

		// Show the current tab, and add an "active" class to the button that opened the tab
		document.getElementById(nots).style.display = "block";
		evt.currentTarget.className += " active";
	}
	let notifs_seen = [];
	$(function () {
		var notifications;
		window.onload = populate();
		document.getElementById("defaultOpen").click();
		$(".notif_container").hover(function () {
			$notID = $(this).children()[0].getAttribute("id");
			let notif = $(this).children()[0];
			let p_read = ($(this).children().find("p").last()[0]);
			let i_icon = p_read.getElementsByTagName("i")[0];
			// let notif_childs = notif.children();
			if(!(notifs_seen.find(k => k==$notID))){
				$.ajax({
					url: '<?=base_url()?>Caregiver/setNotifSeen/' + $notID,
					success: function (error) {
						console.log($(this).children[0])
						console.log("notID: "+$notID+" set seen")
						notifs_seen.push($notID);
						i_icon.innerHTML = "check_circle";
						console.log(i_icon)
					}
				});
			}
		})
		function populate() {
			//  Populates the notification list with the right
			//  messages.

			notifications = <?php echo json_encode($floorNotifications);?>;
			console.log(notifications);
			notificationsFloor = notifications.floors;
			//loop every floor
			for (var floorID in notificationsFloor) {
				let floor = notificationsFloor[floorID];
				for (let i = 0; i < floor.length; i++) {
					// get the element which we want to add notifications to
					let a = document.getElementsByClassName("Floorlist"); // returns a list
					a = a[0]; // get the first (and only) element of the list
					let container = document.createElement("a");
					let notification = document.createElement("div");
					notification.className = "notification";
					notification.id = floor[i]["NotificationID"]
					container.className = "notif_container";
					// notification.setAttribute("type","button")
					//
					// Clock Icon
					let clock = document.createElement("p");
					clock.className = "icon";
					let icon = document.createElement("i");
					icon.className = "material-icons read";
					icon.innerHTML = "access_time";
					clock.appendChild(icon);
					notification.appendChild(clock);

					// Date
					let date = document.createElement("p");
					date.className = "date";
					date.innerHTML = floor[i]["date"];
					notification.appendChild(date);

					// content
					let content = document.createElement("p");
					content.className = "content";
					content.innerHTML = "<span style=\"color:#003B46\">" + floorID + ": " + "</span>" + floor[i]["text"];
					// content.innerHTML = floorID + ": " +floor[i]["text"];
					notification.appendChild(content);

					// read
					let read = document.createElement("p");
					read.className = "read";
					let symbol = document.createElement("i");
					symbol.className = "material-icons read";
					symbol.innerHTML = "fiber_new";
					read.appendChild(symbol);
					notification.appendChild(read);
					console.log(floor[i]['FK_FloorID']);
					if (floor[i]['FK_FloorID']== null) {
						container.setAttribute("href", "resDash/?id=" + floor[i]['FK_ResidentID'])
					} else {
						container.setAttribute("href", "floorCompare")
					}
					container.appendChild(notification)
					a.appendChild(container); // add the entire html div to the notification list.

				}
			}
			//loop every resident
			notificationsResidents = notifications.residents;
			console.log(notificationsResidents)
			for(var i = 0; i < notificationsResidents.length;i++) {
				let resident = notificationsResidents[i]
				console.log(resident)
				// get the element which we want to add notifications to
				let a = document.getElementsByClassName("Residentlist"); // returns a list
				a = a[0]; // get the first (and only) element of the list
				let container = document.createElement("a");
				let notification = document.createElement("div");
				notification.className = "notification";
				container.className = "notif_container";
				// notification.setAttribute("type","button")
				//
				// Clock Icon
				let clock = document.createElement("p");
				clock.className = "icon";
				let icon = document.createElement("i");
				icon.className = "material-icons read";
				icon.innerHTML = "access_time";
				clock.appendChild(icon);
				notification.appendChild(clock);

				// Date
				let date = document.createElement("p");
				date.className = "date";
				date.innerHTML = resident.date;
				notification.appendChild(date);

				// content
				let content = document.createElement("p");
				content.className = "content";
				content.innerHTML = "<span style=\"color:#003B46\">" + "Resident: " + "</span>" + resident.text;
				// content.innerHTML = floorID + ": " +floor[i]["text"];
				notification.appendChild(content);

				// read
				let read = document.createElement("p");
				read.className = "read";
				let symbol = document.createElement("i");
				symbol.className = "material-icons read";
				symbol.innerHTML = "fiber_new";
				read.appendChild(symbol);
				notification.appendChild(read);
				container.setAttribute("href", "resDash/?id=" + resident['FK_ResidentID'])
				container.appendChild(notification)
				a.appendChild(container); // add the entire html div to the notification list.
			}

		}
	})
</script>
