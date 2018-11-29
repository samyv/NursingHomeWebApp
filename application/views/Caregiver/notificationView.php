<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/notificationView.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
</head>

<body>
<div class = "grid-container">
    <div class = "title">
        <p>Notifications</p>
    </div>

    <div class = list>
    </div>
    </div>

    <div class = "footer">
        <p>© KULeuven 2018</p>
    </div>

</div>
</body>
</html>

<script>
    window.onload = populate();
    function populate()
    {
        //  Populates the notification list with the right
        //  messages.
        //  TODO: Still need to implement the database part
        for (let i = 0 ; i <10 ; i++)
        {
            // get the element which we want to add notifications to
            let a = document.getElementsByClassName("list"); // returns a list
            a = a[0]; // get the first (and only) element of the list
            let notification = document.createElement("div");
            notification.className = "notification";

            // Clock Icon
            let clock = document.createElement("p");
            clock.className = "icon";
            let icon = document.createElement("i");
            icon.className = "material-icons read";
            icon.innerHTML = "access_time";
            clock.appendChild(icon);
            notification.appendChild(clock);

            // Date
            let date = document.createElement("p");
            date.className = "date";
            date.innerHTML = "Date goes here";
            notification.appendChild(date);

            // content
            let content = document.createElement("p");
            content.className = "content";
            content.innerHTML = "This is where the content of the notification goes";
            notification.appendChild(content);

            // read
            let read = document.createElement("p");
            read.className = "read";
            let symbol = document.createElement("i");
            symbol.className = "material-icons read";
            symbol.innerHTML = "fiber_new";
            read.appendChild(symbol);
            notification.appendChild(read);

            a.appendChild(notification); // add the entire html div to the notification list.
        }
    }
</script>
