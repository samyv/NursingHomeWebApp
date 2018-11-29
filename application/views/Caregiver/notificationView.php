<!DOCTYPE html>
<html>
<head>
    <title>Database Searching</title>
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
        <div class = "notification">
            <p class = "icon"><i class="material-icons read">access_time</i></p>
            <p class = "date">Fri 10/4/18 at 14:47</p>
            <p class = "content">Content of the notification goes here</p>
            <p class = "read"><i class="material-icons read">fiber_new</i></p>
        </div>

        <div class = "notification">
            <p class = "icon"><i class="material-icons read">access_time</i></p>
            <p class = "date">Fri 10/4/18 at 14:47</p>
            <p class = "content">Content of the notification goes here</p>
            <p class = "read"></p>
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
        var database = "";
        database = <?php echo json_encode($listCar)?>;
        var list = document.getElementsByClassName("list");
        for (let i = 0 ; i <1 ; i++)
        {
            let notification = document.createElement("div");
            let date = document.createElement("date");
            date.innerHTML = "A";
            let content = document.createElement("content");
            content.innerHTML = "B";
            let read = document.createElement("read");
            read.innerHTML = "C";

            notification.appendChild(date);
            notification.appendChild(content);
            notification.appendChild(read);

            console.log(notification);
            console.log(list);
            //list.appendChild(notification);
        }


    }
</script>
