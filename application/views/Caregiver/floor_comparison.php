<!DOCTYPE html>
<html>
<head>
    <title>Database Searching</title>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/floor_comparison.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
</head>

<body>
<div class = "grid-container">

    <div class = "title">
        <p>Select floors to compare</p>
    </div>

    <div class = "list">
        <div class="floorbtn container">Floor 5
            <i class="fas fa-check"></i>
        </div>

        <div class="floorbtn container">Floor 4
            <i class="fas fa-check"></i>
        </div>

        <div class="floorbtn container">Floor 3
            <i class="fas fa-check"></i>
        </div>

        <div class="floorbtn container">Floor 2
            <i class="fas fa-check"></i>
        </div>

        <div class="floorbtn container">Floor 1
            <i class="fas fa-check"></i>
        </div>
    </div>

    <div class = "graph">
    <p> Here comes the visualisation</p>
    </div>
</div>

<script>

    $(document).ready(function () {
        $('.floorbtn').click(myFunction)
    })

    function myFunction(event) {
        var x = event.target.getElementsByTagName('i');
        console.log(x);
        if (x.length == [])
        {
            clickIcon(event);
            return;
        }
        if (x[0].style.display == "inline-grid") {
            x[0].style.display = "none";
        } else {
            x[0].style.display = "inline-grid";
        }
    }

    function clickIcon(event) {
        var x = event.target;
        if (x.style.display == "inline-grid") {
            x.style.display = "none";
        } else {
            x.style.display = "inline-grid";
        }
    }
</script>
</body>
</html>
