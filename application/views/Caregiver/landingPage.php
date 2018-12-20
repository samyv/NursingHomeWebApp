<!DOCTYPE html>
<html lang="en">
<head>
    <title>{page_title}</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <link href="<?php echo base_url(); ?>assets/css/landingPage.css" rel='stylesheet' type='text/css'/>
    <link href="<?php echo base_url(); ?>assets/css/alert_message.css" rel='stylesheet' type='text/css'/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/notes.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/transitions.css">
    <script src="<?php echo base_url();?>assets/js/notes.js"></script>
</head>
<body>
<div class="grid-container fade-in">

    <div class="title">
        <h1><?php
            echo ($this->lang->line('welcome_message'));
            echo $_SESSION['firstname']; ?>!</h1>
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
            <input id="1" type="button" class = "btn" onclick="location.href='residents'"
                   value="<?php echo ($this->lang->line('search resident'))?>">
            <input id="2" type="button" class = "btn" onclick="location.href='floorCompare'"
                   value="<?php echo ($this->lang->line('compare floor'))?>">
            <input id="3" type="button" class = "btn" onclick="location.href='floorSelect'"
                   value="<?php echo ($this->lang->line('select floor'))?>">

        </div>

    <div class="noteheader">
        <h2 class="noteheader"><?php echo ($this->lang->line('notes'))?></h2>
        <div class="newNote" id="newNote">
            <i id="newNotebtn" class="fas fa-2x fa-plus-circle"></i>
        </div>
    </div>
    <div class="clndrheader">
        <h2><?php echo ($this->lang->line('calendar'))?></h2>

    </div>
    <div class="notes">
        <?php
        if (isset($notes)) {
            foreach ($notes as $note) {
                ?>
                <form name="submitNotes" class="existing form" action="">
                    <input type="number" name="id" id="idinput" class="idinput form-group" style="display:none;"
                           value="<?php echo $note['noteid']; ?>">
                    <a class="btn deleteNote" name="close">
                        <i id="<?php echo $note['noteid']; ?>"
                           class="fa fa-trash-alt"></i></a>
                    <textarea id="notearea" class="note form-group" wrap="hard" maxlength="1000" form="submitNotes"
                              name="note"><?php echo $note['Note']; ?></textarea>
                    <input id="<?php echo $note['noteid']; ?>" class="savebtn btn form-group" type="button" style="display:none"
                           value= <?php echo ($this->lang->line('save'))?>
                    >
                </form>
            <?php }
        } ?>
    </div>

    <div class="googleCalendar">
		<a class="weatherwidget-io" href="https://forecast7.com/nl/50d884d70/leuven/" data-label_1="LEUVEN" data-label_2="WEATHER" data-theme="original" >LEUVEN WEATHER</a>
		<script>
			!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
		</script>
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
