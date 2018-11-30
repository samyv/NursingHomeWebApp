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
		?>
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
</html>

