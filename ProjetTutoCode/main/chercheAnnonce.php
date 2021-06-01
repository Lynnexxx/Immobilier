<?php 
session_start();
include_once '../function/connectBDD.php';
$bdd = bdd();

$requete = $bdd->query('SELECT DISTINCT ville from gestionhabitat ORDER BY ville');
$fichier = fopen("../assets/js/quartiers.js","w");
fclose($fichier);

$fichier = fopen("../assets/js/quartiers.js","w+");
$chaine=""; $ville=""; $chaine_villes="";
fwrite($fichier,"function retour_quartiers(ville)\r\n{");
fwrite($fichier,"\r\n\tvar chaine_quartiers='';\r\n");
fwrite($fichier,"\r\n\tswitch(ville){\r\n");
while($result = $requete->fetch())
{

	$ville = $result["ville"];
	$chaine_villes .= $result["ville"]."|";
	$chaine.="\t\tcase '".$ville."':\r\n";
	$chaine.="\t\tchaine_quartiers='";
	
	$requete2 = $bdd->prepare('SELECT quartiers from gestionhabitat WHERE ville = :ville ORDER BY quartiers');
	$requete2->execute(array('ville'=> $ville));
	while($result2 = $requete2->fetch())
{
	$chaine .= trim(utf8_encode($result2["quartiers"]))."|";
}
	
	$chaine =rtrim($chaine,"|");
	$chaine.="';\r\n";
	$chaine.= "\t\t\tbreak;\r\n";

}

fwrite($fichier,$chaine);

fwrite($fichier,"\t}\r\n\r\nreturn chaine_quartiers;\r\n}");
fclose($fichier);	
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
  <link href="../assets/css/owl.carousel2.css"  rel="stylesheet" />
  <link href="../assets/css/font-awesome.min2.css"  rel="stylesheet" />
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
		  <li class="active">
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
		  <li>
            <a href="historique.php">
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
	<?php
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
	<a href="../assets/img/Annonces/<?php echo $picture[$i]?>"><img width="50%" src="../assets/img/Annonces/<?php echo $picture[$i]?>" alt="image"/></a>	
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
	if($result['whatfor']=="A Louer")
	{
	echo "<h4><b>Prix du bien : </h4></b>".$result['prix']." FCFA par mois"."<br>";
	}
	else
	{
	echo "<h4><b>Prix du bien : </h4></b>".$result['prix']." FCFA"."<br>";
	}
	echo "<h4><b>Type de bien : </h4></b>".utf8_encode($result['type'])."<br>";
	echo "<h4><b>Contact du fournisseur : </h4></b>"."(+229) ".$result['contact']."<br>";
	echo "<h4><b>Description du bien : </h4></b>".utf8_decode($result['descrip'])."<br><br><br>";
	if($result['comment'])
	echo "<h4><b>Avis : </h4></b>".utf8_decode($result['comment'])."<br>";
	if($result["waitReserv"]==1 AND $result["reserved"]==1 AND $result["paid"]!=1)
	echo "<h3 style='color:red;'>Ce bien a déja été réservé</h3>";
    if($result["paid"]==1 AND $result["whatfor"]=="A Louer")
	echo "<h3 style='color:red;'>Ce bien a déja été loué</h3>";
	if($result["paid"]==1 AND $result["whatfor"]=="A Vendre")
	echo "<h3 style='color:red;'>Ce bien a déja été acheté</h3>";
	if($result["waitReserv"]==0 AND $result["reserved"]!=1) {
	if(isset($_GET['reservBien']) AND isset($_GET['detailsville']))
	{
	$update = $bdd->prepare('UPDATE annonce set reserver=:reserver , waitReserv=:waitReserv , reserved=:reserved WHERE id=:id');
	$update->execute(array(	'reserver'=> $_SESSION['pseudo'],
							'waitReserv'=> 1,
							'reserved'=> 1,
							'id'=> $_GET['reservBien']
					));
	echo "<h3 style='color:blue;'>Vous avez réservé ce bien... Veuillez payer dans les prochaines 24 heures sous peine d'annulation<h3>";
	}
	else {
	echo "<h3><a href='chercheAnnonce.php?detailsville=".$result['id']."&reservBien=".$result['id']."'><b>Réserver ce bien</b></a></h3>";
	}
	}

	}
	else
	{
	?>
	<h1> <b style='color:white;'>Rechercher un bien</b> </h1>
	<form class="course-search-form" method="POST" action="onlysearch.php">
	 <select name="typeBien" class="custom-select">
	 <option value="none">
	 Tous types de biens
	 </option>
	 <?php
	 $requete = $bdd->query("SELECT * from biens");
	 while($result = $requete->fetch())
	 {
	 ?>
	 <option value="<?php echo $result["nom"]?>">
	 <?php echo $result["nom"]?>
	 </option>
	 <?php
	 }
	 ?>
	 </select>
	 <select name="use" class="custom-select">
	 <option value="none2">
	 A vendre & A Louer
	 </option>
	 <option value="A Louer">
	 A Louer
	 </option>
	 <option value="A Vendre">
	 A Vendre
	 </option>
	 </select>
	 <select id="ville" name="villes" class="custom-select" onChange="charger_quartiers()">
	  <option value="none3">
	 Toutes les villes
	 </option>
	 <?php
	 $requete = $bdd->query("SELECT DISTINCT ville from gestionhabitat ORDER by ville");
	 while($result = $requete->fetch())
	 {
	 ?>
	 <option value="<?php echo $result["ville"] ?>">
	 <?php echo $result["ville"] ?>
	 </option>
	 <?php
	 }
	 ?>
	 </select>
	 <div id="quartiers">
	 &nbsp;
	 </div>
	 <input type="number" name="prixMin"  class="custom-select" placeholder="Entrez le prix minimal du bien (en XOF)..." /><br/>
	 <input type="number" name="prixMax"  class="custom-select" placeholder="Entrez le prix maximal du bien (en XOF)..." /><br/>
	 <input type="submit" name="execute" value="Rechercher" class="site-btn"/><br/>
	
	<script src="../assets/js/quartiers.js"></script>
	 <script>
function charger_quartiers()
{
var tab_quartiers=""; var nb_quartiers=0; var chaine_liste="";
var le_study = document.getElementById("ville").value;

tab_quartiers = retour_quartiers(le_study).split('|');
nb_quartiers = tab_quartiers.length;

chaine_liste = "<select class='custom-select' name='quartiers'>";
chaine_liste += "<option value='none4'>Tous les quartiers</option>";

for(var defil=0 ; defil<nb_quartiers ; defil++)
	{
		chaine_liste += "<option value='" + tab_quartiers[defil] + "'>" + tab_quartiers[defil] + "</option>";
	}
	chaine_liste += "</select>";
	document.getElementById("quartiers").innerHTML = chaine_liste;
}
	</script>
	<?php
	 if(isset($erreur))
		 echo "<div style='color:red;'>".$erreur."</div>";
	 if(isset($success))
		 echo "<div style='color:blue;'>".$success."</div>";
	?>
	 </form>
	<?php
	$requete = $bdd->prepare('SELECT * from annonce WHERE publi = :publi');
	$requete->execute(array('publi'=> 1));
	echo "<h2><center> Toutes les annonces disponibles</center></h2>";
    ?>
<table>
<tr>
<?php
$i = 0;
while ($result = $requete->fetch()){
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
						<?php
						if($result['whatfor']=="A Louer")
						{
						?>
						<span><?php echo $result['prix']." FCFA par mois"?></span>
						<?php
						}
						else
						{
						?>
						<span><?php echo $result['prix']." FCFA"?></span>
						<?php
						}
						?>
						
						
						</div>
						<div>
						<?php
						$requete1=$bdd->prepare('SELECT * from annonce WHERE nom=:nom and type=:type and ville=:ville and quartier=:quartier and whatfor=:whatfor and waitReserv=:waitReserv');
						$requete1->execute(array(
						'nom'=> $result['nom'],
						'type'=> $result['type'],
						'ville'=> $result['ville'],
						'quartier'=> $result['quartier'],
						'whatfor'=> "A Louer",
						'waitReserv'=> 0
						));
						$result1=$requete1->fetch();
						if($result1)
						echo "<div style='color:blue;'><b>"."A Louer"."</b></div>";
						$requete1=$bdd->prepare('SELECT * from annonce WHERE nom=:nom and type=:type and ville=:ville and quartier=:quartier and waitReserv=:waitReserv and reserved=:reserved and paid=:paid');
						$requete1->execute(array(
						'nom'=> $result['nom'],
						'type'=> $result['type'],
						'ville'=> $result['ville'],
						'quartier'=> $result['quartier'],
						'waitReserv'=> 1,
						'reserved'=> 1,
						'paid'=> 0
						));
						$result1=$requete1->fetch();
						if($result1)
						echo "<div style='color:red;'><b>"."Déja réservé"."</b></div>";
						
						$requete2=$bdd->prepare('SELECT * from annonce WHERE nom=:nom and type=:type and ville=:ville and quartier=:quartier and whatfor=:whatfor and paid=:paid');
						$requete2->execute(array(
						'nom'=> $result['nom'],
						'type'=> $result['type'],
						'ville'=> $result['ville'],
						'quartier'=> $result['quartier'],
						'whatfor'=> "A Louer",
						'paid'=> 1
						));
						$result2=$requete2->fetch();
						if($result2)
						echo "<div style='color:blue;'><b>"."Déja loué"."</b></div>";
						$requete2=$bdd->prepare('SELECT * from annonce WHERE nom=:nom and type=:type and ville=:ville and quartier=:quartier and whatfor=:whatfor and paid=:paid');
						$requete2->execute(array(
						'nom'=> $result['nom'],
						'type'=> $result['type'],
						'ville'=> $result['ville'],
						'quartier'=> $result['quartier'],
						'whatfor'=> "A Vendre",
						'paid'=> 1
						));
						$result2=$requete2->fetch();
						if($result2)
						echo "<div style='color:blue;'><b>"."Déja vendu"."</b></div>";
						$requete2=$bdd->prepare('SELECT * from annonce WHERE nom=:nom and type=:type and ville=:ville and quartier=:quartier and whatfor=:whatfor and waitReserv=:waitReserv');
						$requete2->execute(array(
						'nom'=> $result['nom'],
						'type'=> $result['type'],
						'ville'=> $result['ville'],
						'quartier'=> $result['quartier'],
						'whatfor'=> "A Vendre",
						'waitReserv'=> 0
						));
						$result2=$requete2->fetch();
						if($result2)
						echo "<div style='color:blue;'><b>"."A Vendre"."</b></div>";
						
						?>
						<a href="chercheAnnonce.php?detailsville=<?php echo $result['id']?>">
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
                </script>, made with by Murielle
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
