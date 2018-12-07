<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/newResident.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/transitions.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>{page_title}</title>
</head>

<body>
<form class ="fade-in" action="" method="post">
<?php echo form_open_multipart('Caregiver/newResident');?>
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
        <div class="form-errors">
            <?php if(isset($error_msg)){ ?>
                <span><?php echo $error_msg; ?></span>
            <?php } ?>
            <?php if(isset($success_msg)){ ?>
                <span class="success"><?php echo $success_msg; ?></span>
            <?php } ?>
            <?php echo form_error('firstname','<span class="help-block">','</span>'); ?>
            <?php echo form_error('cp_email','<span class="help-block">','</span>'); ?>
            <?php echo form_error('lastname','<span class="help-block">','</span>'); ?>
            <?php echo form_error('birthdate','<span class="help-block">','</span>'); ?>
            <?php echo form_error('gender','<span class="help-block">','</span>'); ?>
            <?php echo form_error('floor','<span class="help-block">','</span>'); ?>
            <?php echo form_error('cp_first_name','<span class="help-block">','</span>'); ?>
            <?php echo form_error('cp_phone','<span class="help-block">','</span>'); ?>
            <?php echo form_error('cp_first_name','<span class="help-block">','</span>'); ?>
            <?php echo form_error('room','<span class="help-block">','</span>'); ?>
        </div>
        <div class = "resident">
            <h3>Resident information</h3>
        </div>

        <div class="firstname">
            <b>First name: </b>
        </div>
        <div class="firstname_input">
            <input type="text" placeholder="Enter first name" class = "form-control" name="firstname" required=""
                   value="<?php echo (isset($_POST['firstname']) ? $_POST['firstname'] : ''); ?>">
        </div>
        <div class="lastname">
            <b>Last name: </b>
            <br>
        </div>
        <div class="lastname_input">
            <input type="text" placeholder="Enter last name" class = "form-control" name="lastname" required=""
                   value="<?php echo (isset($_POST['lastname']) ? $_POST['lastname'] : ''); ?>">
        </div>
        <div class="birthday">
            <b>Birthday: </b>
            <br>
        </div>
        <div class="birthday_input">
            <input type="date" placeholder="" name="birthdate" class = "form-control" required=""
                   value="<?php echo (isset($_POST['birthdate']) ? $_POST['birthdate'] : ''); ?>">

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
        </div>
        <div class="floor">
            <b>Floor: </b>
            <br>
        </div>
        <div class="floor_input">
            <input type="number" name="floor" class = "form-control" placeholder="Enter floor number" min="0" required=""
                   value="<?php echo (isset($_POST['floor']) ? $_POST['floor'] : ''); ?>">
        </div>
        <div class="room">
            <b>Room: </b>
            <br>
        </div>
        <div class="room_input">
            <input type="number" name="room" class = "form-control" placeholder="Enter room number" min="1"required=""
                   value="<?php echo (isset($_POST['room']) ? $_POST['room'] : ''); ?>">

        </div>
        <div class="picture_input">
            <div class="form-group">
                <b>Upload resident picture</b>
                <input type="file" name="imageURL"  size="20">
            </div>
        </div>

        <div class = "extra">
            <h3>Contact information</h3>
        </div>

        <div class="contact_first_name">
            <b>First name: </b>
        </div>
        <div class="cp_first_name_input">
            <input type="text" name="cp_first_name"  class = "contact form-control" placeholder="Enter first name" required=""
                   value="<?php echo (isset($_POST['cp_first_name']) ? $_POST['cp_first_name'] : ''); ?>">
            <br>
        </div>
        <div class="contact_last_name">
            <b>Last name: </b>
        </div>
        <div class="cp_last_name_input">
            <input type="text" name="cp_last_name"  class = "contact form-control" placeholder="Enter first name" required=""
                   value="<?php echo (isset($_POST['cp_last_name']) ? $_POST['cp_last_name'] : ''); ?>">
            <br>
        </div>
        <div class="email">
            <b>Email: </b>
        </div>
        <div class="email_input">
            <input type="text" name="cp_email" class = "contact form-control" placeholder="example@example.com"
                   value="<?php echo (isset($_POST['cp_email']) ? $_POST['cp_email'] : ''); ?>">
            <br>
        </div>
        <div class="phone">
            <b>Phone nr: </b>
        </div>
        <div class="phone_input">
            <input type="tel" name="cp_phone" class = "contact form-control" placeholder="+32 123 456 789"
                   value="<?php echo (isset($_POST['cp_phone']) ? $_POST['cp_phone'] : ''); ?>">
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
			$('[name="cp_first_name"]').val(contact.firstname);
			$('[name="cp_last_name"]').val(contact.lastname);
			$('[name="cp_email"]').val(contact.email);
			$('[name="cp_phone"]').val(contact.phonenumber);
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



