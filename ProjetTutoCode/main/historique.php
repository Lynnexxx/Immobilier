<?php 
session_start();
include_once '../function/connectBDD.php';
$bdd = bdd();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
  ImmobPorto
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min2.css" rel="stylesheet" />
  <link href="../assets/css/style.css"  rel="stylesheet" />
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/paper-dashboard.css?v=2.0.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
  <link href="../assets/css/esthetics.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="../assets/img/logo-small.png">
          </div>
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
        ImmobPorto
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="./fournisseur.php">
              <i class="nc-icon nc-bank"></i>
              <p>Accueil</p>
            </a>
          </li>
          <li>
            <a href="./postAnnonce.php">
              <i class="nc-icon nc-bullet-list-67"></i>
              <p>Poster annonce</p>
            </a>
          </li>
		  <li>
            <a href="./chercheAnnonce.php">
              <i class="nc-icon nc-zoom-split"></i>
              <p>Rechercher annonce</p>
            </a>
          </li>
		  <li>
            <a href="./panier.php">
              <i class="nc-icon nc-cart-simple"></i>
              <p>Mon panier</p>
            </a>
          </li>
		  <li class="active">
            <a href="./historique.php">
              <i class="nc-icon nc-circle-10"></i>
              <p>Historiques Activités</p>
            </a>
          </li>
		  <li>
            <a href="perso.php">
              <i class="nc-icon nc-single-02"></i>
              <p>Mes informations personnelles</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">Bienvenue <?php echo $_SESSION['pseudo']?></a>
          </div>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
			  <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-settings-gear-65"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Mon compte</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="../deconnexion.php">Se déconnecter</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <!-- <div class="panel-header panel-header-lg">

  <canvas id="bigDashboardChart"></canvas>


</div> -->
      <div class="content">
		<ul>
		<li>
		<a href="historique.php?historique=fournisseur"><h4><b>Votre historique de fournisseur</b></h4></a>
		</li>
		<li>
		<a href="historique.php?historique=acheteur"><h4><b>Votre historique d'acheteur</b></h4></a>
		</li>
		<li>
		<a href="historique.php?historique=locataire"><h4><b>Votre historique de locataire</b></h4></a>
		</li>
		</ul>
		<?php
		if(isset($_GET['historique']))
		{
		if($_GET['historique']=="fournisseur") {
	    $requete = $bdd->prepare('SELECT * from annonce WHERE publisher=:publisher and publi=:publi and datePost is not null');
	    $requete->execute(array('publisher'=> $_SESSION['pseudo'],
							  'publi'=> 1
							  ));
		while($result=$requete->fetch())
		{
		echo "<div style='color:white;'><b><h4>".$result['datePost']." :</h4></b> Votre annonce intitulée <b>".utf8_encode($result['nom'])."</b> concernant un bien de type <b>".$result['type']."</b> situé dans la ville de <b>".$result['ville']."</b> plus précisement dans le quartier <b>".$result['quartier']."</b> a été <b>postée</b> suite à la validation de l'agent.<br></div>";
		}
		$requete2 = $bdd->prepare('SELECT * from annonce WHERE publisher=:publisher and publi=:publi and datePost is not null');
	    $requete2->execute(array('publisher'=> $_SESSION['pseudo'],
							  'publi'=> 0
							  ));
		while($result2=$requete2->fetch())
		{
		echo "<div style='color:white;'><b><h4>".$result2['datePost']." :</h4></b> Votre annonce intitulée <b>".utf8_encode($resul2['nom'])."</b> concernant un bien de type <b>".$result2['type']."</b> situé dans la ville de <b>".$result2['ville']."</b> plus précisement dans le quartier <b>".$result2['quartier']."</b> a été <b>annulée</b> suite à la vérification de l'agent.<br></div>";
		}
		}
		if($_GET['historique']=="acheteur") {
	    $requete = $bdd->prepare('SELECT * from annonce WHERE reserver=:reserver and whatfor=:whatfor and reserved=:reserved and paid=:paid and dateReserv is not null');
	    $requete->execute(array('reserver'=> $_SESSION['pseudo'],
							    'whatfor'=> "A Vendre",
								'reserved'=> 1,
								'paid'=> 0
							  ));
		while($result=$requete->fetch())
		{
		echo "<div style='color:white;'><b><h4>".$result['dateReserv']." :</h4></b> Le bien intitulé <b>".utf8_encode($result['nom'])."</b> de type <b>".$result['type']."</b> situé dans la ville de <b>".$result['ville']."</b> plus précisement dans le quartier <b>".$result['quartier']."</b> vous a été <b>réservé</b> suite à la validation de l'agent.<br></div>";
		}
		$requete = $bdd->prepare('SELECT * from annonce WHERE reserver=:reserver and whatfor=:whatfor and reserved=:reserved and dateReserv is not null');
	    $requete->execute(array('reserver'=> $_SESSION['pseudo'],
							    'whatfor'=> "A Vendre",
								'reserved'=> 0
							  ));
		while($result=$requete->fetch())
		{
		echo "<div style='color:white;'><b><h4>".$result['dateReserv']." :</h4></b> La réservation du bien intitulé <b>".utf8_encode($result['nom'])."</b> de type <b>".$result['type']."</b> situé dans la ville de <b>".$result['ville']."</b> plus précisement dans le quartier <b>".$result['quartier']."</b> vous a été <b>réfusée</b> suite à la vérification de l'agent.<br></div>";
		}
		$requete = $bdd->prepare('SELECT * from annonce WHERE reserver=:reserver and whatfor=:whatfor and reserved=:reserved and paid=:paid and dateAchat is not null');
	    $requete->execute(array('reserver'=> $_SESSION['pseudo'],
							    'whatfor'=> "A Vendre",
								'reserved'=> 1,
								'paid'=> 1
							  ));
		while($result=$requete->fetch())
		{
		echo "<div style='color:white;'><b><h4>".$result['dateAchat']." :</h4></b> Vous avez <b>acheté</b> le bien intitulé <b>".utf8_encode($result['nom'])."</b> de type <b>".$result['type']."</b> situé dans la ville de <b>".$result['ville']."</b> plus précisement dans le quartier <b>".$result['quartier']."</b>.<br></div>";
		}
		}
		if($_GET['historique']=="locataire") {
	    $requete = $bdd->prepare('SELECT * from annonce WHERE reserver=:reserver and whatfor=:whatfor and reserved=:reserved and paid=:paid and dateReserv is not null');
	    $requete->execute(array('reserver'=> $_SESSION['pseudo'],
							    'whatfor'=> "A Louer",
								'reserved'=> 1,
								'paid'=> 0
							  ));
		while($result=$requete->fetch())
		{
		echo "<div style='color:white;'><b><h4>".$result['dateReserv']." :</h4></b> Le bien intitulé <b>".utf8_encode($result['nom'])."</b> de type <b>".$result['type']."</b> situé dans la ville de <b>".$result['ville']."</b> plus précisement dans le quartier <b>".$result['quartier']."</b> vous a été <b>réservé</b> suite à la validation de l'agent.<br></div>";
		}
		$requete = $bdd->prepare('SELECT * from annonce WHERE reserver=:reserver and whatfor=:whatfor and reserved=:reserved and paid=:paid and dateAchat is not null');
	    $requete->execute(array('reserver'=> $_SESSION['pseudo'],
							    'whatfor'=> "A Louer",
								'reserved'=> 1,
								'paid'=> 1
							  ));
		while($result=$requete->fetch())
		{
		echo "<div style='color:white;'><b><h4>".$result['dateAchat']." :</h4></b> Vous avez <b>loué</b> le bien intitulé <b>".utf8_encode($result['nom'])."</b> de type <b>".$result['type']."</b> situé dans la ville de <b>".$result['ville']."</b> plus précisement dans le quartier <b>".$result['quartier']."</b>.<br></div>";
		}
		}
		}
		?>
	  </div>
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <div class="credits ml-auto">
              <span class="copyright">
                ©
                <script>
                  document.write(new Date().getFullYear())
                </script>, made by Murielle
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/paper-dashboard.min.js?v=2.0.0" type="text/javascript"></script>
  <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
      demo.initChartsPages();
    });
  </script>
</body>
<!--====== Javascripts & Jquery ======-->
<script src="../assets/js/jquery-3.2.1.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/mixitup.min.js"></script>
<script src="../assets/js/circle-progress.min.js"></script>
<script src="../assets/js/owl.carousel.min.js"></script>
<script src="../assets/js/main2.js"></script>
</html>
