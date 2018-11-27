<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/landingPage.css" rel='stylesheet' type='text/css' />
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <link href="<?php echo base_url(); ?>assets/css/alert_message.css" rel='stylesheet' type='text/css'/>
    <title>Home | GraceAge</title>
    <script src="<?php echo base_url();?>assets/js/jquery-3.3.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

</head>
<body>
<div class="grid-container">

    <div class = "title">
        <h1>Welcome back <?php echo  $_SESSION['firstname']; ?>!</h1>
    </div>

    <div class = "quote">
        <h5 id="quote">
			<?php
			$number = rand(1,1000);
			$this->load->model('caregivers');
			echo $this->caregivers->getQuote($number);
			?>
		</h5>
    </div>
        <div class="btn-group">
            <input id="1" value="Search a resident" type="button" class = "btn" onclick="location.href='residents'">
            <input id="2" value="Floor comparison" type="button" class = "btn" onclick="location.href='floorCompare'">
            <input id="3" value="Floor Select" type="button" class = "btn" onclick="location.href='floorSelect'">
            <input id="4" value="Action center" type="button" class = "btn" onclick="location.href='actionCenter'">
        </div>

    <h2 class="noteheader">Notes</h2>

    <h2 class="clndrheader">Calendar</h2>

    <div class="notes">
            {notes}
            <form name="submitNotes" class="existing form" action="">
                <input type="number" name="id" id="idinput" class="idinput form-group" style="display:none;" value="{noteid}">
                <a class="btn deleteNote" name="close"><i id="{noteid}" class="fa fa-trash-alt"></i></a>
                <textarea id="notearea" class="note form-group" wrap="hard" maxlength="1000" form="submitNotes" name="note">{Note}</textarea>
                <input id="{noteid}" class="savebtn btn form-group" type="button" value="Save" style="display:none">
            </form>
            {/notes}
        <div class="newNote" id="newNote">
            <button id="newNotebtn" type="button" class="btn">New note</button>
        </div>
    </div>

    <div class="googleCalendar"><button id="btnCreateEvents" class="btn btn-primary" onclick="makeApiCall();">
            Create Events</button>

        <div id="divifm">
            <iframe id="ifmCalendar"

                    src="https://www.google.com/calendar/embed?
                    height=550&amp;wkst=1&amp;bgcolor=%23FFFFFF&
                    amp;src=24tn4fht2sssdssfdiqqlsedk%40group.calendar.google.com&
                    amp;color=%238C500B&amp;ctz=Asia%2FCalcutta"

                    style="border-width: 0" width="100%"

                    height="300px" frameborder="0" scrolling="no">
            </iframe>
        </div>
    </div>
</div>

    <script>

        $(document).ready(function () {
            $('.note').focus(showSave)
        });

        function showSave(event){
            $(event.target).next().css("display","block");
            $(event.target).next(".fa").remove();
            $(event.target).next(".savebtn").css("left","3px");
            $(event.target).next(".savebtn").val("Save");
        }

        function saveNote(event){
            $noteid = $(event.target).attr("id");
            $note = $(event.target).prev().val();
            $.ajax({
                url: '<?=base_url()?>Caregiver/saveNote',
                method: 'post',
                dataType: 'json',
                data: {
                    'note': $note,
                    'idinput': $noteid
                },
                function(data) {
                    alert('data updated');
                }
            });
            $(event.target).before("<i class=\"fa fa-check\"></i>");
            $(event.target).prev().css({"position":"absolute",
            "bottom": "3px",
            "left":"3px",
            "background-color": "#003b46",
            "color":"white",
            "padding-left": "5px",
            "z-index": "9",
            });
            $(event.target).prev().css("height",$(event.target).css("height"));
            $(event.target).prev().css("padding-top","11px");
            $(event.target).css("left", "19px")
            $(event.target).val("Saved");

        }

        function deleteNote (event) {
            $note = $(event.target).parent();
            console.log($note);
            $noteid = $(event.target).attr("id");
            Confirm('Delete note?', 'Are you sure you want to delete this note?', 'Yes', 'Cancel', $noteid, $note);
        };

        function Confirm(title, msg, $true, $false, $noteid, $note) { /*change*/
            var $content = "<div class='dialog-ovelay'>" +
                "<div class='dialog'><header>" +
                " <h3> " + title + " </h3> " +
                "<i class='fa fa-close'></i>" +
                "</header>" +
                "<div class='dialog-msg'>" +
                " <p> " + msg + " </p> " +
                "</div>" +
                "<footer>" +
                "<div class='controls'>" +
                " <button class='button button-danger doAction'>" + $true + "</button> " +
                " <button class='button button-default cancelAction'>" + $false + "</button> " +
                "</div>" +
                "</footer>" +
                "</div>" +
                "</div>";
            $('body').prepend($content);
            $flag = false;
            $('.doAction').click(function () {
                $(this).parents('.dialog-ovelay').fadeOut(500, function () {
                    $(this).remove();
                    $.ajax({
                        url: '<?=base_url()?>Caregiver/deleteNote',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            'idNote': $noteid
                        },
                        success() {

                        }
                    });
                    $note.parent().remove();
                });
            });

            $('.cancelAction, .fa-close').click(function () {
                $(this).parents('.dialog-ovelay').fadeOut(500, function () {
                    $(this).remove();
                });
            });
        };


        $(document).ready(function () {
            $('.deleteNote').click(deleteNote);
        });


        $(document).ready(function (){
            $('.savebtn').click(saveNote);
        });


        $(document).ready(function() {
            $('#newNotebtn').click(function() {
                $('#newNote').before("<form name=\"submitNotes\" class=\"existing form\" action=\"\">\n" +
                    "                <input type=\"number\" name=\"id\" id=\"idinput\" class=\"idinput form-group\" style=\"display:none;\" value=\"\">\n" +
                    "                <a class=\"btn deleteNote\" name=\"close\"><i id=\"\" class=\"fa fa-trash-alt\"></i></a>\n" +
                    "                <textarea id=\"notearea\"  class=\"note form-group\" wrap=\"hard\" maxlength=\"1000\" form=\"submitNotes\" name=\"note\"></textarea>\n" +
                    "                <input id=\"\" class=\"savebtn btn form-group\" type=\"button\" value=\"Save\" style=\"display:none\">\n" +
                    "            </form>");
                $('.note').focus(showSave);
                $('.deleteNote').click(deleteNote);
                $('.savebtn').click(saveNote);
            });

        });

    </script>




    <script type="text/javascript">

        // Google api console clientID and apiKey

        var clientId = '717305927226-31gsidivt5it0a97ijqsdmm6fj9btdgq.apps.googleusercontent.com';
        var apiKey = 'AIzaSyCCDk2C-VML0a2SYu2ekYSLqA_sBzVMv5o';

        // enter the scope of current project (this API must be turned on in the Google console)
        var scopes = 'https://www.googleapis.com/auth/calendar';


        // OAuth2 functions
        function handleClientLoad() {
            gapi.client.setApiKey(apiKey);
            window.setTimeout(checkAuth, 1);
        }

        //To authenticate
        function checkAuth() {
            gapi.auth.authorize({ client_id: clientId, scope: scopes, immediate: true }, handleAuthResult);
        }

        // This is the resource we will pass while calling api function
        var resource = {
            "summary": "My Event",
            "start": {
                "dateTime": today
            },
            "end": {
                "dateTime": twoHoursLater
            },
            "description":"We are organizing events",
            "location":"US",
            "attendees":[
                {
                    "email":"attendee1@gmail.com",
                    "displayName":"Jhon",
                    "organizer":true,
                    "self":false,
                    "resource":false,
                    "optional":false,
                    "responseStatus":"needsAction",
                    "comment":"This is my demo event",
                    "additionalGuests":3

                },
                {
                    "email":"attendee2@gmail.com",
                    "displayName":"Marry",
                    "organizer":true,
                    "self":false,
                    "resource":false,
                    "optional":false,
                    "responseStatus":"needsAction",
                    "comment":"This is an official event",
                    "additionalGuests":3
                }
            ],
        };

        function makeApiCall(){
            gapi.client.load('calendar', 'v3', function () { // load the calendar api (version 3)
                var request = gapi.client.calendar.events.insert
                ({
                    'calendarId': '24tn4fht2tr6m86efdiqqlsedk@group.calendar.google.com',
// calendar ID which id of Google Calendar where you are creating events. this can be copied from your Google Calendar user view.

                    "resource": resource 	// above resource will be passed here
                });
            }
    </script>




</body>
</html>
