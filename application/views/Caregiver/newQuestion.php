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
            <select name="section_input" onchange='checkChoice(this.value);' class="form-control" required="">
                <option>Sections</option>
                <option value="A">Privacy</option>
                <option value="B">Het eten/ de maaltijden</option>
                <option value="C">Veiligheid</option>
                <option value="D">Zich prettig voelen</option>
                <option value="E">Dagelijks kiezen [Autonomie]</option>
                <option value="F">Respect</option>
                <option value="G">Reageren door medewerkers op vragen</option>
                <option value="H">Een band voelen met wie hier werkt</option>
                <option value="I">Keuze aan activiteiten</option>
                <option value="J">Persoonlijke omgang (Aanwezig zijn van vrienden)</option>
                <option value="K"> Informatie vanuit het woonzorgcentrum</option>
                <option value="new">New Section</option>
            </select>
            <input type="text" name="section_input" id="section_input" style='display:none;' class="form-control" placeholder="Section name"/>
            <br>
        </div>

        <div class="question">
            <h3>Question</h3>
        </div>

        <div class="question_input">
            <input type="text" name="question" class = "form-control" placeholder="Type new question here">
            <br>
        </div>

        <div class="buttons">
            <input type="submit" value="Submit" name="saveSettings"/>
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