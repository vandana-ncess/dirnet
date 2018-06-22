<!DOCTYPE html>
<?php
    session_start();
   
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>DirNet</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
	<div id="header1">
		<div class="wrapper clearfix">
			<div id="logo">
				<a href="index.html"><img src="images/logo.png" alt="LOGO"></a>
				<a href="index.html"><img src="images/logo2.png" alt="LOGO"></a>
			</div>
                    <ul id="navigation" >
				<li class="selected">
					<a href="index.php">Home</a>
				</li>
				<li>
					<a href="attendance.php">Attendance</a>
				</li>
				<li>
					<a href="publications.php">Publications</a>
				</li>
			<li>
					<a href="documents.html">Documents</a>
				</li>
				<li>
					<a href="social.html">Social Media</a>
				</li>
                                <li>
					<a href="logout.php">Log Out</a>
				</li>
			</ul>
		</div>
            <?php
                 if(isset($_SESSION['user']) && $_SESSION['user']=='admin')
                    echo '<script>document.getElementById("navigation").style.display="block";document.getElementById("navigation").style.float="right";</script>';
                else
                    echo '<script>document.getElementById("navigation").style.display="none";</script>';
            ?>
	</div>
	<div id="contents">
            <div id="adbox" >
			<div class="wrapper clearfix">
			
			</div>

		</div>
            <div class="body clearfix" style="float: right;">
			<div class="info" style="float: right; background: url(images/login.jpg);width: 400px;height: 300px;border-radius: 25px;">
                            <form method="POST" action="" style="float: inside;padding-left: 60px;padding-top: 50px;" >
                                    <h3>Login</h3>
                                    <table ><tr><td>Username</td><td>
                                                <input type="text" name="txtUser"  placeholder="UserName" required /></td></tr>
                                        <tr><td>Password</td><td> <input type="password" name="txtPswd" placeholder="Password" required /></td></tr>
                                        <tr><td /><td> <input type="submit" name="btnLogin" value="Login" style="width:60px;border-radius: 12px;" /></td></tr>
                                    </table>
                                    <?php
                                        if(isset($_POST['btnLogin'])) {
                                            if($_POST['txtUser'] == 'admin' && $_POST['txtPswd'] == 'admin@ncess') {
                                                $_SESSION['user']='admin';
                                                echo '<script>document.getElementById("navigation").style.display="block";document.getElementById("navigation").style.float="right";</script>';
                                            }
                                            else
                                                echo 'Incorrect Username or Password!';
                                        }
                                    ?>
                                    </form>
				</div>
		</div>
	</div>
	<div id="footer">
		<!--<ul id="featured" class="wrapper clearfix">
			<li>
				<img src="images/astronaut.jpg" alt="Img" height="204" width="220">
				<h3><a href="blog.html">Category 1</a></h3>
				<p>

				</p>
			</li>
			<li>
				<img src="images/earth.jpg" alt="Img" height="204" width="220">
				<h3><a href="blog.html">Category 2</a></h3>
				<p>

				</p>
			</li>
			<li>
				<img src="images/spacecraft-small.jpg" alt="Img" height="204" width="220">
				<h3><a href="blog.html">Category 3</a></h3>
				<p>

				</p>
			</li>
			<li>
				<img src="images/space-shuttle.jpg" alt="Img" height="204" width="220">
				<h3><a href="blog.html">Category 4</a></h3>
				<p>

				</p>
			</li>
		</ul>-->
		<div class="body">
			<div class="wrapper clearfix">
				<div id="links">
					<div>
						<h4>Social</h4>
						<ul>
							<li>
								<a href="https://twitter.com/hashtag/ESSO-NCESS" target="_blank">Twitter</a>
							</li>
							<li>
								<a href="https://www.facebook.com/ESSO.NCESS/" target="_blank">Facebook</a>
							</li>
							<li>
								<a href="https://www.youtube.com/channel/UCAbCDyOAbBV2vBMUR3ojpXQ" target="_blank">Youtube</a>
							</li>
						</ul>
					</div>
					<div>
						<h4>Heading placeholder</h4>
						<ul>
							<li>
								<a href="http://ncess.gov.in/" target="_blank">NCESS WebSite</a>
							</li>
							<li>
								<a href="https://ncess.eoffice.gov.in/" target="_blank">eOffice</a>
							</li>
							<li>
								<a href="http://192.168.100.161/NcessIntranet" target="_blank">NCESS INTRANET</a>
							</li>
						</ul>
					</div>
				</div>
				<!--<div id="newsletter">
					<h4>Newsletter</h4>
					<p>
						Sign up for Our Newsletter
					</p>
					<form action="index.html" method="post">
						<input type="text" value="">
						<input type="submit" value="Sign Up!">
					</form>
				</div>-->
				<p class="footnote">
					© Copyright © 2018. | ESSO-NCESS all rights reserved
				</p>
			</div>
		</div>
	</div>
</body>
</html>
