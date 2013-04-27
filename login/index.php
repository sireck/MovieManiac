<html>
    <head>
    <?php include "../includes.php" ?>
    <?php include "../header.php" ?>
    <title>Movie Mania - Online Movie Recommender - User Login</title>
    <script type="text/javascript">
        function log_me_in() {
            username    =   document.getElementById("username").value;
            password    =   document.getElementById("password").value;
            redirect    =   document.getElementById("redirect").value;
            if(redirect=="") redirect = "../index.php";
            else redirect   =   redirect.split("'").join("");
            url         =   "<?php echo $LOGIN; ?>"+"logmein.php";
            
            if(username == '') {
	            document.getElementById('username_error').innerHTML = "<span style='color:red'>Username field cannot be left blank</span>";
	            document.getElementById('username_error').style.display='block';
                document.getElementById('username').focus();
                document.getElementById('username').style.border='1px solid red';
            }

            else if(password == '') {
	            document.getElementById('password_error').innerHTML = "<span style='color:red'>Password field cannot be left blank</span>";
	            document.getElementById('password_error').style.display='block';
                document.getElementById('password').focus();
                document.getElementById('password').style.border='1px solid red';
            }
            else {
            $.post(url, {username: username, password: password}, function(data) {
                if(data=="success"){
                    document.getElementById("status").innerHTML="<p class=success>Please wait! We're logging you into the system!</p>";
                    setTimeout("location.href='"+redirect+"'",10);
                }
                else {
                    document.getElementById("status").innerHTML="<p>"+data+"</p>";
                }
            });
            }
        }
    </script>
    <?php 
        if(isset($_GET['redirect'])) 
            $redirect=$_GET['redirect'];
    ?>
    </head>
    <body onload=" document.getElementById('username').focus(); ">
    <div class="login-container">
    <fieldset>
        <legend><i>Login form</i></legend>
        <form action="" method="POST" class="login" id="login" onsubmit="return false">
        <table>
        <tr>
            <td class="left"><label for="username">Username <span class='required'> *</span> </td>
            <td>
                <input type="text" name="username" id="username" onkeyup="this.style.border='1px solid green';;document.getElementById('username_error').style.display='none';">
                <div id="username_error" style="display: none;"></div>
            </td>
        </tr>
        <tr>
            <td class="left"><label for="password">Password <span class='required'> *</span> </td>
            <td>
                <input type="password" name="password" id="password" onkeyup="this.style.border='1px solid green';;document.getElementById('password_error').style.display='none';">
                <div id="password_error" style="display: none;"></div>
            </td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="redirect" id="redirect" value="<?php echo $redirect; ?>">
                <input type="button" value="login" onclick="log_me_in()">
            </td>
            <td>
                <input type="button" value="cancel" onclick=" location.href='../index.php'; ">
            </td>
        </tr>
        </table>
        </form>
    </fieldset>
    <div id="status" class=status><p>Please enter your username and password and click on Login button</p></div>
    </div>
    </body>
</html>
