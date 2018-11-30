<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?=base_url();?>assets/css/header.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#"><?php echo $_SESSION['firstname'];?> <?php echo $_SESSION['lastname'];?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="landingpage"><i class="fas fa-home"></i> Home</a>
            </li>


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Go to
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    {dropdown_menu_items}
                    <a href="{link}" class="{className}">{name}</a>
                    {/dropdown_menu_items}
                </div>
            </li>



            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i><span class="badge badge-warning">2</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    {dropdown_menu_items}
                    <a href="{link}" class="{className}">{name}</a>
                    {/dropdown_menu_items}
                </div>
            </li>

            </li>
            <li class="nav-item">
                <a class="nav-link" href="account"><i class="fas fa-cog"></i> Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="logoutButton" href="logout"><i class="material-icons">exit_to_app</i> Log out</a>
            </li>
        </ul>
    </div>
</nav>
</body>
</html>
