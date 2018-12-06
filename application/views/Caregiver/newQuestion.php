<!DOCTYPE html>
<html lang="en">
<head>
    <link href="<?php echo base_url(); ?>assets/css/newQuestion.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>{page_title}</title>
</head>

<body>

<form action="" method="post">
    <div class="grid-container">
        <div class="section">
            <h3>Choose a section or create a new one </h3>
        </div>

        <div class="section_input">
            <select name="section" onchange='checkChoice(this.value);' class="form-control" required="">
                <option>Sections</option>
                <?php
                foreach($sections as $section) {?>
                    <option value="<?php echo $section['sectionId'];?>"><?php echo $section['sectionType'] ;?></option>
                <?php }?>
                <option value="new">New Section</option>
            </select>
            <input type="text" name="section_input" id="section_input" style='display:none;' class="form-control" placeholder="Section name"/>
            <?php echo form_error('section','<span class="help-block">','</span>'); ?>
            <br>
        </div>

        <div class="question">
            <h3>Question</h3>
        </div>

        <div class="question_input">
            <input type="text" name="question" class = "form-control" placeholder="Type new question here">
            <?php echo form_error('question','<span class="help-block">','</span>'); ?>
            <br>
        </div>

        <div class="buttons">
            <input type="submit" value="Submit" name="questionSubmit"/>
            <input type="button" value="Cancel" onclick="location.href='landingPage'"/>
        </div>


    </div>
</form>

<script type="text/javascript">
    function checkChoice(val){
        var element=document.getElementById('section_input');
        if(val=='new')
            element.style.display='block';
        else
            element.style.display='none';
    }

</script>


</body>
</html>