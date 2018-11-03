<!DOCTYPE html>
<html>
<head>
    <title>{page_title}</title>
    <link href="<?=base_url()?>assets/css/login.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url()?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>assets/images/logo.png">
</head>
<body>
<div class="logo">
    <h1>GraceAge</h1>
    <h2>Providing better care</h2>
</div>

<div class="form">
    <form action="logindb.php" method="POST">
        <div class="container">
            <label for="uname"><b>Email</b></label>
            <br>
            <input id="emailField" type="text" placeholder="Enter email" name="email">
            <br>
            <label for="psw"><b>Password</b></label>
            <br>
            <input type="password" placeholder="Enter Password" name="psw">
            <br>
            <span class="psw"><a href="#" id="pwdForgot">Forgot password?</a></span>
            <div class="container">
                <button type="submit" value="Submit">Login</button>
				<button type="register" value="Register" formaction="register">Register</button>
            </div>
        </div>
    </form>
</div>

<!--modal-->
<div id="pwdModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="text-center">What's My Password?</h1>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="text-center">

                                <p>If you have forgotten your password you can reset it here.</p>
                                <div class="panel-body">
                                    <fieldset>
                                        <div class="form-group">
                                            <input id="emailForgotPW" class="form-control input-lg" placeholder="E-mail Address" name="email" type="email">
                                        </div>
                                        <input class="btn btn-lg btn-primary btn-block" value="Send My Password" type="submit">
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-12">
                    <button class="btn" id = "cancel" data-dismiss="modal" aria-hidden="true">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
	<p>Copyright © 2018 UXWD. KU Leuven Campus GroupT All Rights Reserved.
	</p>
</footer>
</body>
</html>
<script>


    const modal = document.getElementById('pwdModal');

    const btn = document.getElementById("pwdForgot");

    btn.addEventListener("click",openModal);


    const cancel = document.getElementById("cancel");


    function openModal(){
        const email = document.getElementById("emailField").value;
        modal.style.display = "block";
        console.log(email);
        document.getElementById("emailForgotPW").value = email;
    }


    cancel.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>


