<?php
/**
 * Created by IntelliJ IDEA.
 * User: samy
 * Date: 18/11/2018
 * Time: 0:30
 */
?>
<html>
<head>
	<title>Simple d3js example</title>
	<link href="<?php echo base_url(); ?>assets/css/resident_dashboard.css" rel='stylesheet' type='text/css' />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="http://d3js.org/d3.v4.js"></script>
</head>
<body>

<div class="grid-container">
	<div class="picture">
		PICTURE
<!--		<img src="https://i.pinimg.com/originals/d0/dd/2c/d0dd2c8bb30ef5281ebb4472f1cc71fa.jpg" />-->
	</div>

    <div class="modal-content" id="information-contactperson-modal-content">
        <div class="modal-header">
            <button type="button" class="close" id="closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><span class="glyphicon glyphicon-lock"></span>Contact information</h4>
        </div>
        <div class="info-contact">
            <?php
            echo "Contact person: " . $contactperson['firstname'].' '.$contactperson['lastname'];
            echo "<br>";
            echo "Email: " . $contactperson['email'];
            echo "<br>";
            echo "Phone number: " . $contactperson['phonenumber'];
            echo "<br>";
            echo "Relation: ".$contactperson['relation'];
            ?>
        </div>
    </div>

	<div class="info">
		<?php
		echo $resident['firstname'].' '.$resident['lastname'];
		echo "<br>";
		$dateOfBirth = $resident['birthdate'];
		date_default_timezone_set("Europe/Brussels");
		$today = date("Y-m-d");
		$diff = date_diff(date_create($dateOfBirth),date_create($today));
		echo "Leeftijd: " . $diff->format('%y');
		echo "<br>";
		echo "Geslacht: ";
		if($resident['gender'] == 'm'){
			echo "man";
		} else {
			echo "vrouw";
		}
		echo "<br>";
		echo "Kamer: ".$resident['room'];
		echo "<br>";
		echo "Allergieën: Geen";
		echo "<br>";
		?>
        <br>
        <span class="infcon"><a href="#" id="CIModal">Info contactperson</a></span>
    </div>
	<div class="back_start"></div>

	<div class="visualisation">
		<div id="chart"></div>
	</div>
	<div class="hint">
		<text rows="4" cols="50">Jozef doesn't like the food, let's talk to him!!</text>
	</div>
	<div class="print">
		<input type="submit" value="Print">
	</div>
</div>

<script src="../javascript/rawdata.js"></script>
<script src="../javascript/trulia_vis.js"></script>

</body>
<script>
    $(document).ready(function () {
        $('#CIModal').click(function(){
            $('#information-contactperson-modal-content').fadeIn('fast');
        });

        $('#closemodal').click(function () {
            $('#information-contactperson-modal-content').fadeOut('fast');
        })
    });
</script>
</html>

