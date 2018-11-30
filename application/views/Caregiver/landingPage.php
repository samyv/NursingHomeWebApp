<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/landingPage.css" rel='stylesheet' type='text/css'/>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>assets/images/logo.png">
    <link href="<?php echo base_url(); ?>assets/css/alert_message.css" rel='stylesheet' type='text/css'/>
    <title>Home | GraceAge</title>
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

</head>
<body>
<div class="grid-container">

    <div class="title">
        <h1>Welcome <?php echo $_SESSION['firstname']; ?>!</h1>
    </div>

    <div class="quote">
        <h5 id="quote">
            <?php
            $number = rand(1, 1000);
            $this->load->model('caregivers');
            echo $this->caregivers->getQuote($number);
            ?>
        </h5>
    </div>
        <div class="btn-group">
            <input id="1" value="Search a resident" type="button" class = "btn" onclick="location.href='residents'">
            <input id="2" value="Floor comparison" type="button" class = "btn" onclick="location.href='floorCompare'">
            <input id="3" value="Floor Select" type="button" class = "btn" onclick="location.href='floorSelect'">
        </div>

    <div class="noteheader">
        <h2 class="noteheader">Notes</h2>
        <div class="newNote" id="newNote">
            <button id="newNotebtn" type="button" class="btn">New note</button>
        </div>
    </div>
    <div class="clndrheader">
        <h2>Calendar</h2>

    </div>
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

    <div class="googleCalendar">
        <button id="authorize_button">Authorize</button>
    </div>
</div>


<script>

    $(document).ready(function () {
        $('.note').focus(showSave)
    });

    function showSave(event) {
        $(event.target).next().css("display", "block");
        $(event.target).next(".fa").remove();
        $(event.target).next(".savebtn").css("left", "3px");
        $(event.target).next(".savebtn").val("Save");
    }

    function saveNote(event) {
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
            success: function() {
                $.ajax({
                    url: '<?=base_url()?>Caregiver/getIdLastNote/' + $note,
                    success: function(idNote){
                        console.log(idNote);
                        $(event.target).attr("id",idNote);
                    }
                });
            }
        });

        $(event.target).before("<i class=\"fa fa-check\"></i>");
        $(event.target).prev().css({
            "position": "absolute",
            "bottom": "3px",
            "left": "3px",
            "background-color": "#003b46",
            "color": "white",
            "padding-left": "5px",
            "z-index": "9",
        });
        $(event.target).prev().css("height", $(event.target).css("height"));
        $(event.target).prev().css("padding-top", "11px");
        $(event.target).css("left", "19px")
        $(event.target).val("Saved");

    }

    function deleteNote(event) {
        $note = $(event.target).parent();
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


    $(document).ready(function () {
        $('.savebtn').click(saveNote);
    });


    $(document).ready(function () {
        $('#newNotebtn').click(function () {
            $('#newNote').parent().next().next().append("<form name=\"submitNotes\" class=\"existing form\" action=\"\">\n" +
                "                <input type=\"number\" name=\"id\" id=\"idinput\" class=\"idinput form-group\" style=\"display:none;\" value=\"\">\n" +
                "                <a class=\"btn deleteNote\" name=\"close\"><i id=\"\" class=\"fa fa-trash-alt\"></i></a>\n" +
                "                <textarea id=\"notearea\"  class=\"note form-group\" wrap=\"hard\" maxlength=\"1000\" form=\"submitNotes\" name=\"note\"></textarea>\n" +
                "                <input id=\"\" class=\"savebtn btn form-group\" type=\"button\" value=\"Save\" style=\"display:none\">\n" +
                "            </form>");
            /*$('#newNote').before("<form name=\"submitNotes\" class=\"existing form\" action=\"\">\n" +
                "                <input type=\"number\" name=\"id\" id=\"idinput\" class=\"idinput form-group\" style=\"display:none;\" value=\"\">\n" +
                "                <a class=\"btn deleteNote\" name=\"close\"><i id=\"\" class=\"fa fa-trash-alt\"></i></a>\n" +
                "                <textarea id=\"notearea\"  class=\"note form-group\" wrap=\"hard\" maxlength=\"1000\" form=\"submitNotes\" name=\"note\"></textarea>\n" +
                "                <input id=\"\" class=\"savebtn btn form-group\" type=\"button\" value=\"Save\" style=\"display:none\">\n" +
                "            </form>");*/
            $('.note').focus(showSave);
            $('.deleteNote').click(deleteNote);
            $('.savebtn').click(saveNote);
        });

    });

</script>

<script>
    var GoogleAuth; // Google Auth object.



    // Client ID and API key from the Developer Console
    var CLIENT_ID = '717305927226-31gsidivt5it0a97ijqsdmm6fj9btdgq.apps.googleusercontent.com';
    var API_KEY = 'VML0a2SYu2ekYSLqA_sBzVMv5o';

    // Array of API discovery doc URLs for APIs used by the quickstart
    var DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest"];

    // Authorization scopes required by the API; multiple scopes can be
    // included, separated by spaces.
    var SCOPES = "https://www.googleapis.com/auth/calendar";

    var authorizeButton = document.getElementById('authorize_button');
    var signoutButton = document.getElementById('signout_button');

    function handleClientLoad() {
        gapi.load('client:auth2', initClient);
    }

    function initClient() {
        gapi.client.init({
            apiKey: API_KEY,
            clientId: CLIENT_ID,
            discoveryDocs: DISCOVERY_DOCS,
            scope: SCOPES
        }).then(function () {
            // Listen for sign-in state changes.
            gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);

            // Handle the initial sign-in state.
            updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
            authorizeButton.onclick = handleAuthClick;
            signoutButton.onclick = handleSignoutClick;
        }, function(error) {
            appendPre(JSON.stringify(error, null, 2));
        });
    }


    /**
     *  Called when the signed in status changes, to update the UI
     *  appropriately. After a sign-in, the API is called.
     */
    function updateSigninStatus(isSignedIn) {
        if (isSignedIn) {
            authorizeButton.style.display = 'none';
            signoutButton.style.display = 'block';
            listUpcomingEvents();
        } else {
            authorizeButton.style.display = 'block';
            signoutButton.style.display = 'none';
        }
    }

    /**
     *  Sign in the user upon button click.
     */
    function handleAuthClick(event) {
        gapi.auth2.getAuthInstance().signIn();
    }

    /**
     *  Sign out the user upon button click.
     */
    function handleSignoutClick(event) {
        gapi.auth2.getAuthInstance().signOut();
    }

    /**
     * Append a pre element to the body containing the given message
     * as its text node. Used to display the results of the API call.
     *
     * @param {string} message Text to be placed in pre element.
     */
    function appendPre(message) {
        var pre = document.getElementById('content');
        var textContent = document.createTextNode(message + '\n');
        pre.appendChild(textContent);
    }

    /**
     * Print the summary and start datetime/date of the next ten events in
     * the authorized user's calendar. If no events are found an
     * appropriate message is printed.
     */
    function listUpcomingEvents() {
        gapi.client.calendar.events.list({
            'calendarId': 'primary',
            'timeMin': (new Date()).toISOString(),
            'showDeleted': false,
            'singleEvents': true,
            'maxResults': 10,
            'orderBy': 'startTime'
        }).then(function(response) {
            var events = response.result.items;
            appendPre('Upcoming events:');

            if (events.length > 0) {
                for (i = 0; i < events.length; i++) {
                    var event = events[i];
                    var when = event.start.dateTime;
                    if (!when) {
                        when = event.start.date;
                    }
                    appendPre(event.summary + ' (' + when + ')')
                }
            } else {
                appendPre('No upcoming events found.');
            }
        });
    }
</script>


</body>
</html>
