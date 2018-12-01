<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/newResident.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>{page_title}</title>
</head>

<body>
<div class="modal modal-content" id="information-contactperson-modal-content">
	<div class="modal-header">
		<button type="button" class="close" id="closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title"><span class="glyphicon glyphicon-lock"></span>Contact information</h4>
	</div>
	<div class="info-contact">
		<div class = "search">
			<input type="text" id="myInput" onkeyup="search()" placeholder="Search.." title="Type in a name">
		</div>
		<div class="table">
			<table id="myTable"></table>
		</div>
	</div>
</div>
<form action="" method="post">
    <div class="grid-container">
        <div class = "resident">
            <h3>Resident information</h3>
        </div>

        <div class="firstname">
            <b>First name: </b>
        </div>
        <div class="firstname_input">
            <input type="text" placeholder="Enter first name" class = "form-control" name="firstname" required=""
                   value="<?php echo !empty($resident['firstname'])?$resident['firstname']:''; ?>">
            <?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
        </div>
        <div class="lastname">
            <b>Last name: </b>
            <br>
        </div>
        <div class="lastname_input">
            <input type="text" placeholder="Enter last name" class = "form-control" name="lastname" required=""
                   value="<?php echo !empty($resident['lastname'])?$resident['lastname']:''; ?>">
            <?php echo form_error('lastname','<span class="help-block">','</span>'); ?>
        </div>
        <div class="birthday">
            <b>Birthday: </b>
            <br>
        </div>
        <div class="birthday_input">
            <input type="date" placeholder="" name="birthdate" class = "form-control" required="">
            <?php echo form_error('birthdate','<span class="help-block">','</span>'); ?>
        </div>
        <div class="gender">
            <b>Gender: </b>
            <br>
        </div>
        <div class="gender_input" name="gender"  required="">
            <select name="gender" class = "form-control">
                <option value="male">male</option>
                <option value="female">female</option>
            </select>
            <?php echo form_error('gender','<span class="help-block">','</span>'); ?>
        </div>
        <div class="floor">
            <b>Floor: </b>
            <br>
        </div>
        <div class="floor_input">
            <input type="number" name="floor" class = "form-control" placeholder="Enter floor number" min="0" required="">
            <?php echo form_error('floor','<span class="help-block">','</span>'); ?>
        </div>
        <div class="room">
            <b>Room: </b>
            <br>
        </div>
        <div class="room_input">
            <input type="number" name="room" class = "form-control" placeholder="Enter room number" min="1"required="">
            <?php echo form_error('room','<span class="help-block">','</span>'); ?>
        </div>

        <div class = "extra">
            <h3>Contact information</h3>
        </div>

        <div class="contact_first">
            <b>First name: </b>
        </div>
        <div class="contact_first_input">
            <input type="text" name="first_name"  class = "form-control contact" placeholder="Enter first name" required="">
            <br>
        </div>
        <div class="contact_last">
            <b>Last name: </b>
        </div>
        <div class="contact_last_input">
            <input type="text" name="last_name"  class = "form-control contact" placeholder="Enter last name" required="">
            <br>

        </div>
        <div class="email">
            <b>Email: </b>
        </div>
        <div class="email_input">
            <input type="text" name="email" class = "form-control contact" placeholder="Enter email">
            <br>
        </div>
        <div class="phone">
            <b>Phone nr: </b>
        </div>
        <div class="phone_input">
            <input type="tel" name="phone" class = "form-control contact" placeholder="Enter phone number">
        </div>
        <div class="relation">
            <b>Relation: </b>
        </div>

        <div class="relation_input">
            <select name="relation" onchange='checkChoice(this.value);' class="form-control">
                <option>Relation to resident</option>
                <option value="son">son</option>
                <option value="daughter">daughter</option>
                <option value="brother">brother</option>
                <option value="sister">sister</option>
                <option value="other">other</option>
            </select>
            <input type="text" name="relation" id="relation" style='display:none;' class="form-control" placeholder="Enter your relation"/>
			<span class="infcon"><a href="#" id="CIModal">Add existing Contactperson</a></span>
			<button type="button" class="xbut">X</button>

		</div>
        <div class="buttons">
            <input type="submit" value="Add resident" name="saveSettings"/>
            <input type="button" value="Cancel" onclick="location.href='landingPage'"/>
        </div>
        </div>
</form>

<script type="text/javascript">
	var database = "";
	var list,name;
	$(function () {
		populate();
		init();

	});
    function checkChoice(val){
        var element=document.getElementById('relation');
        if(val=='Choose your relation'||val=='other')
            element.style.display='block';
        else
            element.style.display='none';
    }

	function search() {
		var input, filter, table, i;
		input = document.getElementById("myInput");
		filter = input.value.toUpperCase();
		table = document.getElementById("myTable");
		list = document.getElementsByTagName('tr');
		for (i = 1; i <= list.length; i++) {
			if(list[i] != undefined) {
				name = list[i].getElementsByTagName("td")[1].innerHTML;
				if (name.toUpperCase().indexOf(filter) > -1) {
					list[i].style.display = "";
				} else {
					list[i].style.display = "none";
				}
			}
		}
	}

	function populate() {
		database = <?php echo json_encode($contactpersons)?>;
		var table = document.getElementById("myTable");
		var tbody = createTopRow();
		var elements = [];
		for (var i = 0 ; i < database.length ; i++)
		{
			var element = getElements(database[i]);
			elements.push(element);

			var row = document.createElement('tr');

			var id = document.createElement('td');
			id.innerHTML = element.id;
			// id.style.display = "block"
			row.appendChild(id);

			var col2 = document.createElement('td');
			col2.innerHTML = element.name;
			row.appendChild(col2)
			var col3 = document.createElement('td');
			col3.innerHTML = element.email;
			row.appendChild(col3)
			tbody.appendChild(row);
		}
		table.appendChild(tbody)
	}
	function createTopRow() {
		var tbody = document.createElement("tbody");
		var row = document.createElement('tr');
		var id = document.createElement('th');
		// id.style.display = "block";
		id.innerHTML = "ID";
		row.appendChild(id);
		var col1 = document.createElement('th');
		col1.innerHTML = "Name";
		row.appendChild(col1)
		var col2 = document.createElement('th');
		col2.innerHTML = "Email";
		row.appendChild(col2)
		tbody.appendChild(row);
		return tbody;
	}
	function getElements(db_element) {
		var element = {}
		element.id = db_element['idContactInformation'];
		element.name = db_element['firstname'] +" " + db_element['lastname'];
		element.email = db_element['email'];
		return element;
	}

	function init() {
		$('#myTable tbody').on('click', 'tr', function() {
			$(".contact").prop('disabled', true);
			var id_td = this.firstChild;
			var test = id_td.innerHTML;
			var contact = database.filter(e => e.idContactInformation == test)[0];
			console.log(contact)
			$('#information-contactperson-modal-content').fadeOut('fast');
			$('[name="first_name"]').val(contact.firstname);
			$('[name="last_name"]').val(contact.lastname);
			$('[name="email"]').val(contact.email);
			$('[name="phone"]').val(contact.phonenumber);
			$('.xbut').toggle();
			$('#CIModal').hide();
		})

		$('.xbut').on('click',function () {
			$('.xbut').toggle();
			$('#CIModal').show();
			$(".contact").prop('disabled', false);
			$('[name="first_name"]').val("");
			$('[name="last_name"]').val("");
			$('[name="email"]').val("");
			$('[name="phone"]').val("");
		})
	}
	$(document).ready(function () {
		$('#CIModal').click(function(){
			$('#information-contactperson-modal-content').fadeIn('fast');
		});

		$('#closemodal').click(function () {
			$('#information-contactperson-modal-content').fadeOut('fast');
		})
	});

</script>

<script>

</script>
</body>
</html>



