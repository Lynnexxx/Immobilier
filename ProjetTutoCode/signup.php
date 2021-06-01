<?php
include_once 'function/connectBDD.php';
include_once 'function/inscription.class.php';
$bdd = bdd();

if(isset($_POST['user']) AND isset($_POST['email']) AND isset($_POST['pass']) AND isset($_POST['pass2'])){
$inscription = new inscription($_POST['user'] , $_POST['email'] ,  $_POST['pass'] ,  $_POST['pass2']);
$verif = $inscription->verif();
if($verif == "ok"){
if($inscription->enregistrement()){
			header('Location: signin.php'); 
        }
}
else {
$erreur = $verif;
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>S'inscrire</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="assets/img/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="assets/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="assets/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
<!--===============================================================================================-->
</head>
<body style="background-color: #666666;">
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST" action="signup.php">
					<span class="login100-form-title p-b-43">
						Veuillez vous inscrire <br> 
					</span>
					<div class="wrap-input100 validate-input" required>
						<input class="input100" type="text" name="user" placeholder="Entrez votre pseudo">
					</div>
					<div class="wrap-input100 validate-input" required>
						<input class="input100" type="text" name="email" placeholder="Entrez votre email">
						
					</div>
					<div class="wrap-input100 validate-input" required>
						<input class="input100" type="password" name="pass" placeholder="Entrez votre mot de passe">
					</div>
					<div class="wrap-input100 validate-input" required>
						<input class="input100" type="password" name="pass2" placeholder="Confirmez votre mot de passe">
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
						</div>

						<div>
							<a href="signin.php" class="txt1">
								Vous avez déja un compte ?
							</a>
						</div>
					</div>
			

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							S'inscrire
						</button>
					</div>
					<?php
						if (isset($erreur)){
						echo "<div style='color:red;'>".$erreur."</div>";
						}
					?>
					
				</form>

				<div class="login100-more" style="background-image: url('assets/img/login.jpg');">
				</div>
			</div>
		</div>
	</div>
	
	

	
	
<!--===============================================================================================-->
	<script src="assets/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/bootstrap/js/popper.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/daterangepicker/moment.min.js"></script>
	<script src="assets/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="assets/js/main.js"></script>

</body>
<!--====== Javascripts & Jquery ======-->
<script src="../assets/js/jquery-3.2.1.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/mixitup.min.js"></script>
<script src="../assets/js/circle-progress.min.js"></script>
<script src="../assets/js/owl.carousel.min.js"></script>
<script src="../assets/js/main2.js"></script>
</html>