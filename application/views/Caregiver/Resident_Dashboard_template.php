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
	<title>{page_title}</title>
	<link rel="stylesheet" href="assets/css/transitions.css">
	<link href="<?php echo base_url(); ?>assets/css/resident_dashboard.css" rel='stylesheet' type='text/css' />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="http://d3js.org/d3.v4.js"></script>
</head>
<body>

<div class="grid-container fade-in">
	<div class="picture">
        <?php if(isset($resident['picture'])){ ?>
		<img src="data:image/jpg;base64, <?php echo base64_encode($resident['picture']);?>"/>
        <?php }?>
    </div>

    <div class="modal-content" id="information-contactperson-modal-content">
        <div class="modal-header">
            <button type="button" class="close" id="closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><span class="glyphicon glyphicon-lock"></span>Contact information</h4>

        </div>

        <div id="info-contact" class="info-contact">
            <?php
            //print_r($);
            echo "Contact person: " . $contactperson['firstname'].' '.$contactperson['lastname'];
            echo "<br>";
            echo "Email: " . $contactperson['email'];
            echo "<br>";
            echo "Phone number: " . $contactperson['phonenumber'];
            echo "<br>";
            ?>
        </div>

        <form method="post" action="">
        <div id="info-contact-changed" style="display: none">
            <input type="text" placeholder="Enter firstname" class = "form-control" name="firstname" required=""
            value="<?php echo $contactperson['firstname']; ?>">
            <?php echo form_error('firstname','<span class="help-block">','</span>'); ?>

            <input type="text" placeholder="Enter lastname" class = "form-control" name="lastname" required=""
            value="<?php echo $contactperson['lastname']; ?>">
            <?php echo form_error('lastname','<span class="help-block">','</span>'); ?>

            <input type="text" placeholder="Enter email " class = "form-control" name="email" required=""
            value="<?php echo $contactperson['email']; ?>">
            <?php echo form_error('email','<span class="help-block">','</span>'); ?>

            <input type="text" placeholder="Enter phone number " class = "form-control" name="phonenumber" required=""
            value="<?php echo $contactperson['phonenumber']; ?>">
            <?php echo form_error('phonenumber','<span class="help-block">','</span>'); ?>
        </div>
        <div class="modal-footer">
            <input id="changeInfo" name="changeInfo" class="btn btn-block btn-lg" value="Change info" readonly>
            <input type="submit" id="saveInfo" name="saveInfo" class="btn btn-block btn-lg" value="Save info" style="display: none" readonly>
        </div>
        </form>
    </div>

	<div class="info">
        <div class="name">
            <?php
            echo $resident['firstname'].' '.$resident['lastname']; ?>
        </div>
		<?php
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
		?>
        <span class="infcon">
            <i class="fa fa-info-circle" style="color: #0c5460"></i>
            <a href="#" id="CIModal" style="color: #0c5460"> Info contactperson</a>
        </span>
    </div>
	<div class="back_start"></div>
	<div class="visualisation">
		<div id="chart" name="chart">
        </div>
        <label><br>Select a questionnaire:</label>
        <select class="custom-select selectQuestionnaire" style="width: min-content">
            <?php foreach ($questionnaires as $questionnaire){?>
                <option value="<?php echo $questionnaire['idQuestionnaires'];?>">
                    <?php echo date_format(DateTime::createFromFormat('Y-m-d H:i:s.u', $questionnaire['timestamp']), 'd/m/Y')?>
                </option>
            <?php }?>
        </select>
	</div>
	<div class="hint">
		<text rows="4" cols="50">Hier komen de hints </text>
	</div>
	<div class="print">
        <button type="submit">
        <i class="fa fa-print"></i>
        </button>
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

        $('#changeInfo').click(changeInfo)
        $('#saveInfo').click(saveInfo)


    });

    function changeInfo(event){
        document.getElementById('info-contact').style.display='none';
        document.getElementById('info-contact-changed').style.display='block';
        document.getElementById('changeInfo').style.display='none';
        document.getElementById('saveInfo').style.display='block';
    }

    function saveInfo(event){
            document.getElementById('info-contact').style.display='block';
            document.getElementById('info-contact-changed').style.display='none';
            document.getElementById('changeInfo').style.display='block';
            document.getElementById('saveInfo').style.display='none';
    }

        $(".selectQuestionnaire")
            .change(function () {
                $idQuestionnaire = $( ".selectQuestionnaire option:selected" ).val();
                $.ajax({
                    url: '<?php echo base_url(); ?>caregiver/getQuestionnaireResults/?idQuestionnaire='+$idQuestionnaire,
                    dataType: 'json',
                    success:function (array) {
                        testdata = array;
                        drawChart(testdata);
                    }
                });

            });

        $idQuestionnaire = $( ".selectQuestionnaire option:selected" ).val();
        $.ajax({
            url: '<?php echo base_url(); ?>caregiver/getQuestionnaireResults/?idQuestionnaire='+$idQuestionnaire,
            dataType: 'json',
            success:function (array) {
                testdata = array;
                drawChart(testdata);
            }
        });
    });


</script>
</html>

