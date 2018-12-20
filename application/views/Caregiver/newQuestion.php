<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
    <link href="<?php echo base_url(); ?>assets/css/newQuestion.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>{page_title}</title>
</head>

<body>

<form action="" method="post">
    <div class="grid-container">
        <div class="section">
            <h3><?php echo ($this->lang->line('title section'))?> </h3>
        </div>

        <div class="section_input">
            <select name="section" onchange='checkChoice(this.value);' class="form-control" required="">
                <option><?php echo ($this->lang->line('title section'))?></option>
                <?php
                foreach($sections as $section) {?>
                    <option value="<?php echo $section['sectionId'];?>"><?php echo $section['sectionType'] ;?></option>
                <?php }?>
                <option value="new"><?php echo ($this->lang->line('new section'))?></option>
            </select>
            <input type="text" name="section_input" id="section_input" style='display:none;' class="form-control" placeholder="<?php echo ($this->lang->line('ph section'))?>"/>
            <?php echo form_error('section','<span class="help-block">','</span>'); ?>
            <br>
        </div>

        <div class="question">
            <h3><?php echo ($this->lang->line('title question'))?></h3>
        </div>

        <div class="question_input">
            <input type="text" name="question" class = "form-control" placeholder="<?php echo ($this->lang->line('ph newquestion'))?>">
            <?php echo form_error('question','<span class="help-block">','</span>'); ?>
            <br>
        </div>

        <div class="buttons">
            <input type="submit" value="<?php echo ($this->lang->line('add'))?>" name="questionSubmit"/>
            <input type="button" value="<?php echo ($this->lang->line('cancel'))?>" onclick="location.href='landingPage'"/>
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
