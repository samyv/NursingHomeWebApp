<!doctype html>
<html>
<body>

<!DOCTYPE html>
<html>
<head>
    <title>{page_title}</title>
    <link href="<?=base_url()?>assets/css/activated.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <script src="<?php echo base_url();?>assets/js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/transitions.css">
</head>

<div class="h1 fade-in">
    <h1>GraceAge</h1>
    <h2>Providing better care</h2>
</div>
<div class="grid-container fade-in">
<form class="p" id="resetPassword" name="resetPassword" method="post" action="" '>
    <table class="table table-bordered table-hover table-striped">
        <tbody>
        <tr>
            <td>Enter new Password: </td>
            <td>
                <input type="password" name="password" id="password" style="width:250px" required>
            </td>
        </tr>
        <tr>
            <td>Confirm new Password: </td>
            <td>
                <input type="password" name="conf_password" id="conf_password" style="width:250px" required>
            </td>
            <td><input type = "submit" value="submit" name="resetPassword" class="button"></td>
        </tr>

        </tbody>
    </table>
</form>
</div>
</body>
</html>
