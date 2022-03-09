<html lang="en">
<head>
	<title>KEOMS - Log in Page</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>
	
	<style>
	@import url('https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap');
		*{
			list-style: none;
			text-decoration: none;
			box-sizing: border-box;
		}
		
		.text-center{
			text-align: center !important;
		}
		.lead{
			margin: 1vw auto;
		}
		
		body {
		  display: -ms-flexbox;
		  display: -webkit-box;
		  display: flex;
		  -ms-flex-align: center;
		  -ms-flex-pack: center;
		  -webkit-box-align: center;
		  align-items: center;
		  -webkit-box-pack: center;
		  justify-content: center;
		  padding-top: 40px;
		  padding-bottom: 40px;
		  background-color: #f5f5f5;
		}

		.form-signin {
		  width: 100%;
		  max-width: 330px;
		  padding: 15px;
		  margin: 0 auto;
		}
		.form-signin .checkbox {
		  font-weight: 400;
		}
		.form-signin .form-control {
		  position: relative;
		  height: auto;
		  padding: 10px;
		  font-size: 16px;
		}
		.form-signin .form-control:focus {
		  z-index: 2;
		}
		.form-signin input[type="email"] {
		  margin-bottom: -1px;
		  border-bottom-right-radius: 0;
		  border-bottom-left-radius: 0;
		}
		.form-signin input[type="password"] {
		  margin-bottom: 10px;
		  border-top-left-radius: 0;
		  border-top-right-radius: 0;
		}
	</style>
</head>
<body class="text-center">
	<?php 
		session_start();
		if(isset($_SESSION['role'])){
			header('location: index.php');
			exit();
		}else{
	?>
	<div class="form-signin">
	<img src="images/keoms_logo.png" alt="APC Logo" style="width:100px;height:100px;"><br>
		<h1 class="h1">K.E.O.M.S.</h1>
		<h6 class="lead">Please Sign in</h6>
		<form action="backend/login.p.php" method="POST" >
			<input class="form-control <?php 
				if(isset($_GET['error']) && $_GET['error'] == 'userdoesnotexist'){
					echo 'is-invalid mb-1';
				}
			?>" type="email" id="email" name ="email" required placeholder="E-mail" />
			<?php
				if(isset($_GET['error']) && $_GET['error'] == 'userdoesnotexist'){
					?>
						<div class="invalid-feedback">User does not exist!</div>
					<?php
				}
			?>
			<input class="form-control <?php 
				if(isset($_GET['error']) && $_GET['error'] == 'password'){
					echo 'is-invalid';
				}
			?>"" type="password" id="pass" name="pswd" required placeholder="Password"/>
			<?php
				if(isset($_GET['error']) && $_GET['error'] == 'password'){
					?>
						<div class="invalid-feedback">Wrong password</div>
					<?php
				}
			?>
			
			<br>
			<button class="btn btn-primary btn-lg btn-block" type="submit" name="submit" id="login">Sign in</button>
			<br><br>
			<img src="images/apc_logo2.png" alt="APC Logo" style="width:100px;height:50px;"><br>
		</form>
		
	</div>
	
	<?php 
		
		}
	?>
</body>
</html>