<!doctype html>
<html>
<body>
<form id="resetPassword" name="resetPassword" method="post" action="<?php echo base_url();?>Caregiver/resetPassword" onsubmit ='return validate()'>
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
            <td><input type = "submit" value="submit" class="button"></td>
        </tr>

        </tbody>
    </table>
</form>
</body>
</html>
