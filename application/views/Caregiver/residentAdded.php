<!DOCTYPE html>
<html>
<head>
    <title>{page_title}</title>
    <link href="<?=base_url()?>assets/css/resAdded.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <script src="<?php echo base_url();?>assets/js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url();?>assets/css/transitions.css">
    <title>Resident added</title>
</head>

<body>
    <?php if(!empty($success_msg)){
        echo '<p class="statusMsg">'.$success_msg.'';
    }?> <a href="<?=base_url();?>newResident">Click here</a> to add another resident. </p>
</body>
