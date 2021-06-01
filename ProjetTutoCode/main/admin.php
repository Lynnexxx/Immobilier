<?php 
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
    ImmobPOrto
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

<body>
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
          <li class="active ">
            <a href="./admin.php">
              <i class="nc-icon nc-bank"></i>
              <p>Gestion annonces</p>
            </a>
          </li>
          <li>
            <a href="./adminvisite.php">
              <i class="nc-icon nc-bullet-list-67"></i>
              <p>Gestion visites</p>
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
            <a class="navbar-brand" href="#pablo">Bienvenue admin
			</a>
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
		<a href="admin.php?validAnn=true"><h4><b>Valider une annonce</b></h4></a>
		</li>
		<li>
		<a href="admin.php?validAnn=false"><h4><b>Annuler une annonce</b></h4></a>
		</li>
		</ul>
		<?php
		if(isset($_GET['validAnn']))
		{
			if($_GET['validAnn']=="true")
			{
				$requete1 = $bdd->prepare('SELECT * from annonce WHERE waitpubli = :waitpubli and publi =:publi or publi is null');
				$requete1->execute(array('waitpubli'=> 1,
										 'publi'=> 0
										));
	
			if(isset($_GET['detailsville']))
			{
		$i=0;
		$requete = $bdd->prepare('SELECT * from annonce where id=:id');
		$requete->execute(array('id'=> $_GET['detailsville']));
		$result = $requete->fetch();
		$pictures = $result['pictures'];
		$picture = explode("|" , $pictures);
		echo "<h2><b>".utf8_encode($result['nom'])."</b></h2>";?>
		<marquee id="id1">
	<?php
	$i=0;
	while($i<count($picture)) {?>
	<span onmouseover="getElementById('id1').stop()" onmouseout="getElementById('id1').start()">
	<a href="../assets/img/Annonces/<?php echo $picture[$i]?>"><img src="../assets/img/Annonces/<?php echo $picture[$i]?>" alt="image"/></a>	
	</span>
	<?php
	$i++;
	}
	?>
	</marquee>
	<?php
	echo "<br><br><h2><b>CARACTERISTIQUES DU BIEN</b></h2><br>";
	echo "<h4><b>Type de bien : </h4></b>".utf8_encode($result['type'])."<br>";
	echo "<h4><b>Ville du bien : </h4></b>".utf8_encode($result['ville'])."<br>";
	echo "<h4><b>Quartier du bien : </h4></b>".utf8_encode($result['quartier'])."<br>";
	echo "<h4><b>Prix du bien : </h4></b>".$result['prix']." FCFA"."<br>";
	echo "<h4><b>Type de bien : </h4></b>".utf8_encode($result['type'])."<br>";
	echo "<h4><b>Contact du fournisseur : </h4></b>"."(+229) ".$result['contact']."<br>";
	echo "<h4><b>Description du bien : </h4></b>".utf8_encode($result['descrip'])."<br><br><br>";
	}
	else if(isset($_GET['validate']))
	{
	$update = $bdd->prepare('UPDATE annonce set publi = :publi , datePost = NOW() WHERE id = :id');
	$update->execute(array('publi'=> 1,
					'id'=> $_GET['validate']
					));
										
	}
	else
	{
	?>
				<table>
				<tr>
				<?php
				$i = 0;
				while ($result = $requete1->fetch()){
				$bpictures=$bdd->prepare('SELECT pictures from annonce WHERE nom=:nom and type=:type and ville=:ville and quartier=:quartier'); 
				$bpictures->execute(array(
										'nom'=> $result['nom'],
										'type'=> $result['type'],
										'ville'=> $result['ville'],
										'quartier'=> $result['quartier']
										));
				$picture = $bpictures->fetch();
				$pictures = $picture['pictures'];
				$bpictures = explode("|" , $pictures);
				if($i%4==0){
				echo "</tr>";
				echo "<tr>";
				$i = 0;
				}
				echo "<td>";?>
				<div class="col-md-15 col-sm-15 col-xs-15">
									<div class="categorie-item">
									
										<div class="ci-thumb set-bg" data-setbg="<?php echo "../assets/img/Annonces/".$bpictures[0]?>"></div>
										<div class="ci-text">
										<h3><?php echo utf8_encode($result['nom'])?></h3>
										<p><?php echo utf8_encode($result['type'])?></p>
										<p><?php echo utf8_encode($result['ville'])?></p>
										<span><?php echo $result['prix']." FCFA"?></span>
										</div>
										<div>
										<a href="admin
										.php?validAnn=true&validate=<?php echo $result['id']?>">
										<span class="btn btn-dark ccm_sticker__btn" aria-hidden="true">
										<i class="glyphicon glyphicon-download-alt"></i>
										Valider l'annonce</span>
										</a>
										<a href="admin
										.php?validAnn=true&detailsville=<?php echo $result['id']?>">
										<span class="btn btn-dark ccm_sticker__btn" aria-hidden="true">
										<i class="glyphicon glyphicon-download-alt"></i>
										Voir les détails</span>
										</a>
										</div>
										</div>
										</div>
				<?php
				echo "</td>";
				$i++;
				}
				?>
				</tr>
				</table>
			<?php
			}
		}
		if($_GET['validAnn']=="false")
			{
				$requete1 = $bdd->prepare('SELECT * from annonce WHERE waitpubli=:waitpubli and publi=:publi');
				$requete1->execute(array('waitpubli'=> 1,
										 'publi'=> 1
										));
	
			if(isset($_GET['detailsville']))
			{
		$i=0;
		$requete = $bdd->prepare('SELECT * from annonce where id=:id');
		$requete->execute(array('id'=> $_GET['detailsville']));
		$result = $requete->fetch();
		$pictures = $result['pictures'];
		$picture = explode("|" , $pictures);
		echo "<h2><b>".utf8_encode($result['nom'])."</b></h2>";?>
	<marquee id="id1">
	<?php
	$i=0;
	while($i<count($picture)) {?>
	<span onmouseover="getElementById('id1').stop()" onmouseout="getElementById('id1').start()">
	<a href="../assets/img/Annonces/<?php echo $picture[$i]?>"><img src="../assets/img/Annonces/<?php echo $picture[$i]?>" alt="image"/></a>	
	</span>
	<?php
	$i++;
	}
	?>
	</marquee>
	<?php
	echo "<br><br><h2><b>CARACTERISTIQUES DU BIEN</b></h2><br>";
	echo "<h4><b>Type de bien : </h4></b>".utf8_encode($result['type'])."<br>";
	echo "<h4><b>Ville du bien : </h4></b>".utf8_encode($result['ville'])."<br>";
	echo "<h4><b>Quartier du bien : </h4></b>".utf8_encode($result['quartier'])."<br>";
	echo "<h4><b>Prix du bien : </h4></b>".$result['prix']." FCFA"."<br>";
	echo "<h4><b>Type de bien : </h4></b>".utf8_encode($result['type'])."<br>";
	echo "<h4><b>Contact du fournisseur : </h4></b>"."(+229) ".$result['contact']."<br>";
	echo "<h4><b>Description du bien : </h4></b>".utf8_encode($result['descrip'])."<br><br><br>";
	}
	else if(isset($_GET['abort']))
	{
	$update = $bdd->prepare('UPDATE annonce set publi=:publi, dateCancelPost=NOW() WHERE id = :id');
	$update->execute(array( 'publi'=> 0,
							'id'=> $_GET['abort']
					));
										
	}
	else
	{
	?>
				<table>
				<tr>
				<?php
				$i = 0;
				while ($result = $requete1->fetch()){
				$bpictures=$bdd->prepare('SELECT pictures from annonce WHERE nom=:nom and type=:type and ville=:ville and quartier=:quartier'); 
				$bpictures->execute(array(
										'nom'=> $result['nom'],
										'type'=> $result['type'],
										'ville'=> $result['ville'],
										'quartier'=> $result['quartier']
										));
				$picture = $bpictures->fetch();
				$pictures = $picture['pictures'];
				$bpictures = explode("|" , $pictures);
				if($i%4==0){
				echo "</tr>";
				echo "<tr>";
				$i = 0;
				}
				echo "<td>";?>
				<div class="col-md-15 col-sm-15 col-xs-15">
									<div class="categorie-item">
									
										<div class="ci-thumb set-bg" data-setbg="<?php echo "../assets/img/Annonces/".$bpictures[0]?>"></div>
										<div class="ci-text">
										<h3><?php echo utf8_encode($result['nom'])?></h3>
										<p><?php echo utf8_encode($result['type'])?></p>
										<p><?php echo utf8_encode($result['ville'])?></p>
										<span><?php echo $result['prix']." FCFA"?></span>
										</div>
										<div>
										<a href="admin
										.php?validAnn=false&abort=<?php echo $result['id']?>">
										<span class="btn btn-dark ccm_sticker__btn" aria-hidden="true">
										<i class="glyphicon glyphicon-download-alt"></i>
										Annuler l'annonce</span>
										</a>
										<a href="admin
										.php?validAnn=false&detailsville=<?php echo $result['id']?>">
										<span class="btn btn-dark ccm_sticker__btn" aria-hidden="true">
										<i class="glyphicon glyphicon-download-alt"></i>
										Voir les détails</span>
										</a>
										</div>
										</div>
										</div>
				<?php
				echo "</td>";
				$i++;
				}
				?>
				</tr>
				</table>
			<?php
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
                </script>, made  by Murielle
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