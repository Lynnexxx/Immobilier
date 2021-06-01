<?php
include_once '../function/connectBDD.php';
$bdd = bdd();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>GotUrExam</title>
	<meta charset="UTF-8">
	<meta name="description" content="WebUni Education Template">
	<meta name="keywords" content="webuni, education, creative, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Favicon -->   
	<link href="img/favicon.ico" rel="shortcut icon"/>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,500,500i,600,600i,700,700i,800,800i" rel="stylesheet">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="../assets/css/bootstrap.min2.css"/>
	<link rel="stylesheet" href="../assets/css/font-awesome.min2.css"/>
	<link rel="stylesheet" href="../assets/css/owl.carousel2.css"/>
	<link rel="stylesheet" href="../assets/css/style.css"/>
	


	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	
	
	<!-- Header section -->
	<header class="header-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3">
					<div class="site-logo">
						<img width="100%" src="../assets/img/logo.png" alt="">
					</div>
					<div class="nav-switch">
						<i class="fa fa-bars"></i>
					</div>
				</div>
				<div class="col-lg-9 col-md-9">
					<a href="../signin.php" class="site-btn header-btn">Se connecter</a>
					<nav class="main-menu">
					</nav>
				</div>
			</div>
		</div>
	</header>
	
	<!-- Hero section -->
	<section class="hero-section set-bg" data-setbg="../assets/img/Cotonou.jpg">
		<div class="container">
			<?php
			if(isset($_GET['details']))
			{
			$requete = $bdd->prepare('SELECT * from annonce where id=:id');
			$requete->execute(array('id'=> $_GET['details']));
			$result = $requete->fetch();
			$images = $result['pictures'];
			$images = explode("|" , $images);
			echo "<br><br><br><br><br><br><br><br><br><br><h2><b style='color:white;'><div>CARACTERISTIQUES DU BIEN</b></h2></div><br>";
			echo "<h4><b style='color:white;'>Type de bien : </h4></b><div style='color:white;'>".utf8_encode($result['type'])."</div><br>";
			echo "<h4><b style='color:white;'>Ville du bien : </h4></b><div style='color:white;'>".utf8_encode($result['ville'])."</div><br>";
			echo "<h4><b style='color:white;'>Quartier du bien : </h4></b><div style='color:white;'>".utf8_encode($result['quartier'])."</div><br>";
			echo "<h4><b style='color:white;'>Prix du bien : </h4></b><div style='color:white;'>".$result['prix']." FCFA"."</div><br>";
			echo "<h4><b style='color:white;'>Type de bien : </h4></b><div style='color:white;'>".utf8_encode($result['type'])."</div><br>";
			echo "<h4><b style='color:white;'>Contact du fournisseur : </h4></b><div style='color:white;'>"."(+229) ".$result['contact']."</div><br>";
			echo "<h4><b style='color:white;'>Description du bien : </h4></b><div style='color:white;'>".utf8_decode($result['descrip'])."</div><br><br><br>";
			echo"<h4><b style='color:red;'>VEUILLEZ VOUS CONNECTER POUR POURSUIVRE AVEC CE BIEN...</b></h4>";
			}
			else {
			?>
			<br><br><br><br><br><br><br><br><br><b><center><h1 style="color:white;">Accédez à notre application web de gestion immobilière</h1></center></b>
			<?php
			$requete = $bdd->prepare('SELECT * from annonce where publi=:publi');
			$requete->execute(array('publi'=> 1));
			?>
			<marquee id="id1">
			<?php
			while($result = $requete->fetch()) {
			$pictures = $result['pictures'];
			$picture = explode("|" , $pictures);	
			?>
			<span onmouseover="getElementById('id1').stop()" onmouseout="getElementById('id1').start()">
			<a href="index.php?details=<?php echo $result['id']?>"> <img width="40%" src="../assets/img/Annonces/<?php echo $picture[0]?>" alt="image"/></a>	
			</span>
			<?php
			}
			?>
			</marquee>
			<?php
			}
			?>
		<footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <div class="credits ml-auto">
              <span class="copyright">
                ©
                <script>
                  document.write(new Date().getFullYear())
                </script>, made by MUrielle
              </span>
            </div>
          </div>
        </div>
      </footer>
		</div>
		</section>
</body>
<!--====== Javascripts & Jquery ======-->
<script src="../assets/js/jquery-3.2.1.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/mixitup.min.js"></script>
<script src="../assets/js/circle-progress.min.js"></script>
<script src="../assets/js/owl.carousel.min.js"></script>
<script src="../assets/js/main2.js"></script>
</html>