<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/landingPage.css" rel='stylesheet' type='text/css' />
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <title>Home | GraceAge</title>
    <script src="<?php echo base_url();?>assets/js/jquery-3.3.1.min.js"></script>
    <script>
        function SaveCancel(id) {
            document.getElementById('savebtn').style.display="block";
        }

    </script>
    <script>
        document.getElementById('newNotebtn').addEventListener("click", createNote)

        function createNote() {
            var x = document.getElementById('newNote');
            console.log(1);
            x.insertAdjacentElement("beforebegin", "<input id=\"4\" value=\"Action center\" type=\"button\" class = \"btn\" onclick=\"location.href='actionCenter'\">"
        }
    </script>
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

    <div class="notes">
            {notes}
            <form name="submitNotes" class="existing form" action="">
                <input type="number" name="id" class="idinput form-group" style="display:none;" value="{noteid}">
                <textarea id="notearea" class="note form-group" wrap="hard" maxlength="1000" form="submitNotes" name="note" onfocus="SaveCancel({noteid})" >{Note}</textarea>
                <input id="savebtn" class="btn form-group" type="button" value="Save" style="display:none">
            </form>
            {/notes}
        <div class="newNote" id="newNote">
            <button id="newNotebtn" type="button" class="btn">New</button>
        </div>
    </div>

    <div class="googleCalendar">
        <p>Google Calendar API Quickstart</p>
        <!--Add buttons to initiate auth sequence and sign out-->
        <button id="authorize_button" style="display: none;">Authorize</button>
        <button id="signout_button" style="display: none;">Sign Out</button>
        <pre id="content" style="white-space: pre-wrap;"></pre>
    </div>
</div>

    <script>
        $(document).ready(function(){
            $('#savebtn').click(function(event){
                event.preventDefault();
                var notes = document.getElementsByClassName('note');
                var idinputs = document.getElementsByClassName('idinput');

                console.log(0);
                $.ajax({
                    url:'<?=base_url()?>Caregiver/saveNote',
                    method: 'post',
                    data: {
                        note: note,
                        idinput: idinput
                    },
                    dataType: 'json',
                    success: function(data){
                        alert('data updated');
                    }
                });
            });
        });


    </script>




    <script type="text/javascript">
        // Client ID and API key from the Developer Console
        var CLIENT_ID = '717305927226-31gsidivt5it0a97ijqsdmm6fj9btdgq.apps.googleusercontent.com';
        var API_KEY = 'xjjbdKvNzRTxhHD_N6IJsdtl';

        // Array of API discovery doc URLs for APIs used by the quickstart
        var DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest"];

        // Authorization scopes required by the API; multiple scopes can be
        // included, separated by spaces.
        var SCOPES = "https://www.googleapis.com/auth/calendar.readonly";

        var authorizeButton = document.getElementById('authorize_button');
        var signoutButton = document.getElementById('signout_button');

        /**
         *  On load, called to load the auth2 library and API client library.
         */
        function handleClientLoad() {
            gapi.load('client:auth2', initClient);
        }

        /**
         *  Initializes the API client library and sets up sign-in state
         *  listeners.
         */
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

    <script async defer src="https://apis.google.com/js/api.js"
            onload="this.onload=function(){};handleClientLoad()"
            onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>




</body>
</html>
