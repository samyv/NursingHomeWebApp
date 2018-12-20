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
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/transitions.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/notes.css">
    <link href="<?php echo base_url(); ?>assets/css/alert_message.css" rel='stylesheet' type='text/css'/>
    <link href="<?php echo base_url(); ?>assets/css/resident_dashboard.css" rel='stylesheet' type='text/css'/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://d3js.org/d3.v4.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/notes.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/timeGraphResident.js"></script>
    <script src="../javascript/qrcode.min.js"></script>

</head>
<body>

<div class="grid-container fade-in">
    <div class="picture">
        <?php if (isset($resident['picture'])) { ?>
            <img src="data:image/jpg;base64, <?php echo base64_encode($resident['picture']); ?>"/>
        <?php } ?>
    </div>

    <div class="modal-content" id="information-contactperson-modal-content">
        <div class="modal-header">
            <button type="button" class="close" id="closemodal" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><span
                        class="glyphicon glyphicon-lock"></span><?php echo($this->lang->line('title contact information')); ?>
            </h4>

        </div>

        <div id="info-contact" class="info-contact">
            <?php
            //print_r($);
            echo "Contact person: " . $contactperson['firstname'] . ' ' . $contactperson['lastname'];
            echo "<br>";
            echo "Email: " . $contactperson['email'];
            echo "<br>";
            echo "Phone number: " . $contactperson['phonenumber'];
            echo "<br>";
            ?>
        </div>

        <form method="post" action="">
            <div id="info-contact-changed" style="display: none">
                <input type="text" placeholder="Enter firstname" class="form-control" name="firstname" required=""
                       value="<?php echo $contactperson['firstname']; ?>">
                <?php echo form_error('firstname', '<span class="help-block">', '</span>'); ?>

                <input type="text" placeholder="Enter lastname" class="form-control" name="lastname" required=""
                       value="<?php echo $contactperson['lastname']; ?>">
                <?php echo form_error('lastname', '<span class="help-block">', '</span>'); ?>

                <input type="text" placeholder="Enter email " class="form-control" name="email" required=""
                       value="<?php echo $contactperson['email']; ?>">
                <?php echo form_error('email', '<span class="help-block">', '</span>'); ?>

                <input type="text" placeholder="Enter phone number " class="form-control" name="phonenumber" required=""
                       value="<?php echo $contactperson['phonenumber']; ?>">
                <?php echo form_error('phonenumber', '<span class="help-block">', '</span>'); ?>
            </div>
            <div class="modal-footer">
                <input id="changeInfo" name="changeInfo" class="btn btn-block btn-lg" value="Change info" readonly>
                <input type="submit" id="saveInfo" name="saveInfo" class="btn btn-block btn-lg" value="Save info"
                       style="display: none" readonly>
            </div>
        </form>
    </div>

    <div class="info">
        <div class="name">
            <?php
            echo $resident['firstname'] . ' ' . $resident['lastname']; ?>
        </div>
        <?php
        $dateOfBirth = $resident['birthdate'];
        date_default_timezone_set("Europe/Brussels");
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        echo "Leeftijd: " . $diff->format('%y');
        echo "<br>";
        echo "Geslacht: ";
        if ($resident['gender'] == 'm') {
            echo "man";
        } else {
            echo "vrouw";
        }
        echo "<br>";
        echo "Kamer: " . $resident['room'];
        echo "<br>";
        ?>
        <span class="infcon">
            <i class="fa fa-info-circle" style="color: #0c5460"></i>
            <a href="#" id="CIModal" style="color: #0c5460"> Info contactperson</a>
        </span>
        <br>
        <span class="qrcode"><a href="#" id="qrcodeModal">Generate Qr Code</a></span>

    </div>
    <div class="back_start"></div>
    <div class="visualisation">
        <div class="selectQuestionnaires">
            <label id="select_questionnaire">Select a questionnaire:</label>
            <select class="custom-select selectQuestionnaire" style="width: min-content">
                <?php foreach ($questionnaires as $questionnaire) { ?>
                    <option value="<?php echo $questionnaire['idQuestionnaires']; ?>">
                        <?php echo date_format(DateTime::createFromFormat('Y-m-d H:i:s.u', $questionnaire['timestamp']), 'd/m/Y') ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <br>
        <div class="total_score">
            <label id="total_score_label"></label>
            <div class="progress">
            <div class="progress-bar" role="progressbar" id="total_score_bar" aria-valuenow="0" aria-valuemin="0" style="display: none"></div>
            </div>
        </div>

        <div id="chart" name="chart">
        </div>

        <div class="timeChart">

        </div>

    </div>
    <div class="noteheader">
        <h2 class="noteheader">Notes</h2>
        <div class="newNote" id="newNote">
            <i id="newNotebtn" class="fas fa-2x fa-plus-circle"></i>
        </div>
    </div>
    <div></div>
    <div class="notes">
        <?php
        if (isset($notes)) {
            foreach ($notes as $note) {
                ?>
                <form name="submitNotes" class="existing form" action="">
                    <input type="number" name="id" id="idinput" class="idinput form-group" style="display:none;"
                           value="<?php echo $note['noteid']; ?>">
                    <a class="btn deleteNote" name="close"><i id="<?php echo $note['noteid']; ?>"
                                                              class="fa fa-trash-alt"></i></a>
                    <textarea id="notearea" class="note form-group" wrap="hard" maxlength="1000" form="submitNotes"
                              name="note"><?php echo $note['Note']; ?></textarea>
                    <input id="<?php echo $note['noteid']; ?>" class="savebtn btn form-group" type="button" value="Save"
                           style="display:none">
                </form>
            <?php }
        } ?>
    </div>
    <div class="print">
        <button id="printbtn" type="submit" onclick="window.print()">
            <i class="fa fa-print"></i>
        </button>
    </div>
</div>
<div class="modal-content" id="qr-modal-content">
    <div class="modal-header">
        <button type="button" class="close" id="qrclose" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="glyphicon glyphicon-lock"></span>Qrcode</h4>
    </div>
    <div class="info-contact">
        <div id="qrcode"></div>
        <button onclick="printQrcode()">Download Qrcode</button>
    </div>
</div>
<div class='dialog-ovelay' role="alert">
    <div class='dialog'>
        <header>
            <h3>Delete note?</h3>
            <i class='fa fa-close'></i>
        </header>
        <div class='dialog-msg'>
            <p>Are you sure you want to delete this note?</p>
        </div>
        <footer>
            <div class='controls'>
                <button class='button button-danger doAction'>Yes</button>
                <button class='button button-default cancelAction'>Cancel</button>
            </div>
        </footer>
    </div>
</div>


<script src="../javascript/rawdata.js"></script>
<script src="../javascript/trulia_vis.js"></script>

</body>
<script>
    var idResident = <?php echo $_GET['id']?>;
    $(document).ready(function () {
        $('#CIModal').click(function () {
            $('#information-contactperson-modal-content').fadeIn('fast');
        });

        $('#closemodal').click(function () {
            $('#information-contactperson-modal-content').fadeOut('fast');
        })

        $('#qrcodeModal').click(function () {
            $('#qr-modal-content').fadeIn('fast');
        });

        $('#qrclose').click(function () {
            $('#qr-modal-content').fadeOut('fast');
        });

        $('#changeInfo').click(changeInfo)
        $('#saveInfo').click(saveInfo)
        
        $.ajax({
            url: '<?php echo base_url();?>caregiver/getTotalScoreTime/?idResident=' + idResident,
            dataType: 'json',
            success: function (totalScoreTime) {
                drawTimeResident(totalScoreTime);
            }
        })
        
        
    });


    function changeInfo(event) {
        document.getElementById('info-contact').style.display = 'none';
        document.getElementById('info-contact-changed').style.display = 'block';
        document.getElementById('changeInfo').style.display = 'none';
        document.getElementById('saveInfo').style.display = 'block';
    }

    function saveInfo(event) {
        document.getElementById('info-contact').style.display = 'block';
        document.getElementById('info-contact-changed').style.display = 'none';
        document.getElementById('changeInfo').style.display = 'block';
        document.getElementById('saveInfo').style.display = 'none';
    }

    $(".selectQuestionnaire")
        .change(function () {
            $idQuestionnaire = $(".selectQuestionnaire option:selected").val();

            $.ajax({
                url: '<?php echo base_url();?>caregiver/getTotalScore/?idQuestionnaire=' + $idQuestionnaire,
                dataType: 'json',
                success: function (totalscore) {
                    $('#total_score_label').html("Total score: " + totalscore[0].total_score + "/265");
                    $('#total_score_bar').attr("aria-valuenow", totalscore[0].total_score)
                        .attr("aria-valuemax", totalscore[0].nr*5)
                        .css("display", "inline")
                        .css("width", (totalscore[0].total_score/265*100)+"%");
                    switch (Math.floor(totalscore[0].total_score/265*100/20)) {
                        case 0 :
                            $('#total_score_bar').css("background", colors[0]);
                            break;
                        case 1 :
                            $('#total_score_bar').css("background", colors[1]);
                            break;
                        case 2 :
                            $('#total_score_bar').css("background", colors[2]);
                            break;
                        case 3 :
                            $('#total_score_bar').css("background", colors[3]);
                            break;
                        case 4 :
                            $('#total_score_bar').css("background", colors[4]);
                            break;
                    }
                }
            });


            $.ajax({
                url: '<?php echo base_url(); ?>caregiver/getQuestionnaireResults/?idQuestionnaire=' + $idQuestionnaire,
                dataType: 'json',
                success: function (array) {
                    testdata = array;
                    $.ajax({
                        url: '<?php echo base_url();?>caregiver/getTotalScorePerCategory/?idQuestionnaire=' + $idQuestionnaire,
                        dataType: 'json',
                        success: function (sections) {
                            sections;
                            heatmapChart(testdata, sections);
                        }
                    });
                }
            });
        });

    let qrstring = "<?php echo $resident['qrCode'];?>"
    new QRCode(document.getElementById("qrcode"), qrstring);

    function printQrcode() {
        let img = $('#qrcode').children('img')[0];
        let src = img.getAttribute('src');
        var a = $("<a>")
            .attr("href", src)
            .attr("download", "<?php echo $resident['firstname'] . '-' . $resident['lastname']?>-qrcode.png")
        a[0].click();
        a.remove();
    }


    $idQuestionnaire = $(".selectQuestionnaire option:selected").val();
    $.ajax({
        url: '<?php echo base_url();?>caregiver/getTotalScore/?idQuestionnaire=' + $idQuestionnaire,
        dataType: 'json',
        success: function (totalscore) {

            $('#total_score_label').html("Total score: " + totalscore[0].total_score + "/265");
            $('#total_score_bar').attr("aria-valuenow", totalscore[0].total_score)
                .attr("aria-valuemax", totalscore[0].nrOfQuestions*5)
                .css("width", (totalscore[0].total_score/265*100)+"%")
                .css("display", "inline");

            switch (Math.floor(totalscore[0].total_score/265*100/20)) {
                case 0 :
                    $('#total_score_bar').css("background", colors[0]);
                    break;
                case 1 :
                    $('#total_score_bar').css("background", colors[1]);
                    break;
                case 2 :
                    $('#total_score_bar').css("background", colors[2]);
                    break;
                case 3 :
                    $('#total_score_bar').css("background", colors[3]);
                    break;
                case 4 :
                    $('#total_score_bar').css("background", colors[4]);
                    break;
            }
        }
    });
    $.ajax({
        url: '<?php echo base_url(); ?>caregiver/getQuestionnaireResults/?idQuestionnaire=' + $idQuestionnaire,
        dataType: 'json',
        success: function (array) {
            testdata = array;
            $.ajax({
                url: '<?php echo base_url();?>caregiver/getTotalScorePerCategory/?idQuestionnaire=' + $idQuestionnaire,
                dataType: 'json',
                success: function (sections) {
                    heatmapChart(testdata, sections);
                }
            });
        }
    });

</script>
</html>

