<?php
include_once '../function/connectBDD.php';
$bdd = bdd();?>
<!-- Ecriture dans villes.js -->
<?php
$requete = $bdd->query('SELECT DISTINCT ville from gestionhabitat ORDER BY ville');
$fichier = fopen("../assets/js/villes.js","w");
fclose($fichier);

$fichier = fopen("../assets/js/villes.js","w+");

fwrite($fichier,"function retour_villes(param)\r\n{");
fwrite($fichier,"\r\n\tvar chaine_villes='';\r\n");
fwrite($fichier,"\r\n\tswitch(param){\r\n");

$habitat = "Quartier";
$chaine = "";
$chaine.="\t\tcase '".$habitat."':\r\n";
$chaine.="\t\tchaine_villes='";
while($result=$requete->fetch())
{
$chaine.=trim(utf8_encode($result["ville"]))."|";
}
$chaine =rtrim($chaine,"|");
$chaine.="';\r\n";
$chaine.= "\t\t\tbreak;\r\n";

fwrite($fichier,$chaine);

fwrite($fichier,"\t}\r\n\r\nreturn chaine_villes;\r\n}");
fclose($fichier);
?>
<!-- Ecriture dans suppr_villes.js -->
<?php
$requete = $bdd->query('SELECT DISTINCT ville from gestionhabitat ORDER BY ville');
$requete2 = $bdd->prepare('SELECT quartiers from gestionhabitat WHERE quartiers<>:quartiers AND ville=:ville ORDER BY quartiers'); 
$fichier = fopen("../assets/js/suppr_villes.js","w");
fclose($fichier);

$fichier = fopen("../assets/js/suppr_villes.js","w+");

fwrite($fichier,"function retour_villes_suppr(param)\r\n{");
fwrite($fichier,"\r\n\tvar chaine_villes_suppr='';\r\n");
fwrite($fichier,"\r\n\tswitch(param){\r\n");

$operation = "Supprimer";
$chaine = "";
$chaine.="\t\tcase '".$operation."':\r\n";
$chaine.="\t\tchaine_villes_suppr='";
while($result=$requete->fetch())
{
$chaine.=trim(utf8_encode($result["ville"]))."|";
$requete2->execute(array('quartiers'=> " ",
						'ville'=> $result["ville"]
						));
while ($result2=$requete2->fetch())
{
$chaine.=trim(utf8_encode($result2["quartiers"]))."|";
}

}
$chaine =rtrim($chaine,"|");
$chaine.="';\r\n";
$chaine.= "\t\t\tbreak;\r\n";

fwrite($fichier,$chaine);

fwrite($fichier,"\t}\r\n\r\nreturn chaine_villes_suppr;\r\n}");
fclose($fichier);
?>
<?php

if (isset ($_POST['operation']) AND $_POST['habitat'])
{
if ($_POST['operation']!="none" AND $_POST['habitat']!="none2")
{
if($_POST['operation']=="Ajouter")
{
if($_POST['habitat']=="Ville")
	{
		if(isset($_POST['nom']))
		{
		$requete = $bdd->prepare('SELECT * from gestionhabitat WHERE ville = :ville');
		$requete->execute(array('ville'=>  $_POST['nom']));
		$result = $requete->fetch();
		if(!$result)
			{
				$requete = $bdd->prepare('INSERT into gestionhabitat(ville,quartiers) VALUES (:ville,:quartiers)');
				$requete->execute(array('ville'=>  $_POST['nom'],
										'quartiers'=>" "
										));
				$success="La ville ".$_POST['nom']." a bien été ajoutée";
			}
		else
			{
			$erreur = "Une ville du même nom existe";
			}
		}
		else
		{
		$erreur = "Veuillez entrer le nom de la ville";
		}
	}
if($_POST['habitat']=="Quartier")
	{
		if($_POST['villes']!="none3")
		{
		if(isset($_POST['nom']))
			{
			$requete = $bdd->prepare('SELECT * from gestionhabitat WHERE ville = :ville and quartiers = :quartiers');
			$requete->execute(array('ville'=>  $_POST['villes'],
									'quartiers'=> " "
									));
			$result = $requete->fetch();
			if($result)
				{
				$requete = $bdd->prepare('UPDATE gestionhabitat set quartiers = :quartiers WHERE ville = :ville');
			$requete->execute(array('quartiers'=>  $_POST['nom'],
									'ville'=> $_POST['villes']
									));	
				$success = "Le quartier ".$_POST['nom']." a bien été ajouté";
				}
			else
				{
				$requete = $bdd->prepare('SELECT * from gestionhabitat WHERE ville = :ville and quartiers = :quartiers');
			$requete->execute(array('ville'=> $_POST['villes'],
									'quartiers'=> $_POST['nom']
									));
				$result = $requete->fetch();
				if(!$result)
				{
				$requete = $bdd->prepare('INSERT into gestionhabitat(ville,quartiers) VALUES  (:ville,:quartiers)');
			$requete->execute(array('ville'=> utf8_encode($_POST['villes']),
									'quartiers'=> $_POST['nom']
									));
				$success = "Le quartier ".$_POST['nom']." a bien été ajouté";
				}
				else
				{
				$erreur = "Le quartier ".$_POST['nom']." exite déja";
				}
				}
			}
		else
			{
				$erreur = "Veuillez entrer le nom du quartier";
			}
		}
		else
		{
		$erreur = "Veuillez selectionner la ville correspondante";
		}
	}		
}

if($_POST['operation']=="Supprimer")
{
if($_POST['habitat']=="Ville")
{
	if(isset($_POST['suppr']))
	{
$requete = $bdd->prepare('DELETE from gestionhabitat WHERE ville = :ville');
			$requete->execute(array('ville'=>  $_POST['suppr']
									));
	$success = "La ville ". $_POST['suppr']." a bien été supprimée";
	}
}
if($_POST['habitat']=="Quartier")
{
	if(isset($_POST['suppr']))
	{
$requete = $bdd->prepare('DELETE from gestionhabitat WHERE quartiers = :quartiers and ville = :ville');
			$requete->execute(array('quartiers'=>  $_POST['suppr'],
									'ville'=>  $_POST['villes']
									));
	$success = "Le quartier ". $_POST['suppr']." a bien été supprimé";
	}
}
}
}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf8"/>
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Gestion villes
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
            <a href="./dashadmin.php">
              <i class="nc-icon nc-bank"></i>
              <p>Tableau de bord</p>
            </a>
          </li>
          <li>
            <a href="./user.php">
              <i class="nc-icon nc-single-02"></i>
              <p>Utilisateurs</p>
            </a>
          </li>
		  <li class="active">
            <a href="./gestionvilles.php">
              <i class="nc-icon nc-istanbul"></i>
              <p>Gestion villes</p>
            </a>
          </li>
		  <li>
            <a href="./gestionbiens.php">
              <i class="nc-icon nc-bold"></i>
              <p>Gestion type biens</p>
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
            <a class="navbar-brand" href="#pablo">Bienvenue admin</a>
          </div>
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
      </nav>
      <!-- End Navbar -->
      <!-- <div class="panel-header panel-header-sm">


</div> -->
      <div class="content">
	  <h1> <b>Gestion des villes</b> </h1>
	<form class="course-search-form" method="POST" action="gestionvilles.php">
	 <select id="choose" name="operation" class="custom-select" onChange="charger_villes2()">
	 <option value="none">
	 Veuillez sélectionner le type d'opération
	 </option>
	 <option value="Ajouter">
	 Ajouter
	 </option>
	 <option value="Supprimer">
	 Supprimer
	 </option>
	 </select>
	 <br/>
	 <select id="choix_habit" name="habitat" class="custom-select" onChange="charger_villes()">
	 <option value="none2" disabled>
	 Veuillez sélectionner le type d'agglomérat
	 </option>
	 <option value="Ville">
	 Ville
	 </option>
	 <option value="Quartier">
	 Quartier
	 </option>
	 </select>
	 <div id="ville">
	&nbsp;
	</div>
	 <br/>
	 <div id="suppr">
	 &nbsp;
	 </div>
	 <br/>
	 <input type="submit" name="result" value="Executer" class="site-btn"/><br/>
	 <script src="../assets/js/villes.js"></script>
	 <script src="../assets/js/suppr_villes.js"></script>
	 <script>
function charger_villes2()
{
var tab_villes=""; var nb_villes=0; var chaine_liste="";
var le_study = document.getElementById("choose").value;
if(le_study == "Ajouter")
{
chaine_liste = "<input type='text' name='nom'>";
document.getElementById("suppr").innerHTML = chaine_liste;
}
if(le_study == "Supprimer")
{
tab_villes = retour_villes_suppr(le_study).split('|');
nb_villes = tab_villes.length;

chaine_liste = "<select class='custom-select' name='suppr'>";
chaine_liste += "<option value='none4' disabled>Sélectionner la ville ou le quartier à supprimer</option>";

for(var defil=0 ; defil<nb_villes ; defil++)
	{
		chaine_liste += "<option value='" + tab_villes[defil] + "'>" + tab_villes[defil] + "</option>";
	}
	chaine_liste += "</select>";
	document.getElementById("suppr").innerHTML = chaine_liste;
}
}
	</script>
	<script>
function charger_villes()
{
var tab_villes=""; var nb_villes=0; var chaine_liste="";
var le_study = document.getElementById("choix_habit").value;
if(le_study == "Quartier")
{
	tab_villes = retour_villes(le_study).split('|');
	nb_villes = tab_villes.length;
		
	chaine_liste = "<select id='choix_villes' class='custom-select' name='villes'>";
	chaine_liste += "<option value='none3'>Sélectionner la ville correspondante</option>";
	
	for(var defil=0 ; defil<nb_villes ; defil++)
	{
		chaine_liste += "<option value='" + tab_villes[defil] + "'>" + tab_villes[defil] + "</option>";
	}
	chaine_liste += "</select>";
	document.getElementById("ville").innerHTML = chaine_liste;
}
else
{
document.getElementById("ville").innerHTML = "";
}
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
	  if (isset($_GET['ville']))
	  {
		$query = $bdd->prepare('SELECT quartiers from gestionhabitat WHERE ville=:ville and quartiers<>:quartiers');
		$query->execute(array('ville'=> $_GET['ville'],
								'quartiers'=> " "));
	  ?>
<table width="100%">
<tr>
<?php
$i = 0;
while ($result = $query->fetch()){
if($i%4==0){
echo "</tr>";
echo "<tr>";
$i = 0;
}
echo "<td>";?>
<div class="col-md-15 col-sm-15 col-xs-15">
					<div class="categorie-item">
					
						<div class="ci-thumb set-bg" data-setbg="<?php echo "../assets/img/".$result['quartiers'].".jpg"?>"></div>
						<div class="ci-text">
						<h3><?php echo $result['quartiers']?></h3>
						<p></p>
						<span></span>
						</div>
						<div>
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
	  else {
	  echo "<center><h2><i><b>"."Villes disponibles"."</b></i></h2></center>";
	  $query = $bdd->query('SELECT DISTINCT ville from gestionhabitat');
	  ?>
<table width="100%">
<tr>
<?php
$i = 0;
while ($result = $query->fetch()){
$image = "../assets/img/".$result['ville'].".jpg";
if($i%4==0){
echo "</tr>";
echo "<tr>";
$i = 0;
}
echo "<td>";?>
<div class="col-md-15 col-sm-15 col-xs-15">
					<div class="categorie-item">
					
						<div class="ci-thumb set-bg" data-setbg="<?php echo "../assets/img/".$result['ville'].".jpg"?>"></div>
						<div class="ci-text">
						<h3><?php echo $result['ville']?></h3>
						<p></p>
						<span></span>
						</div>
						<div>
						<a href="gestionvilles.php?ville=<?php echo $result['ville']?>">
						<span class="btn btn-success ccm_sticker__btn" aria-hidden="true">
						<i class="glyphicon glyphicon-download-alt"></i>
						Voir les villes</span>
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
                </script>, made with <i class="fa fa-heart heart"></i> by Murielle
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
</body>
<!--====== Javascripts & Jquery ======-->
	<script src="../assets/js/jquery-3.2.1.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/mixitup.min.js"></script>
	<script src="../assets/js/circle-progress.min.js"></script>
	<script src="../assets/js/owl.carousel.min.js"></script>
	<script src="../assets/js/main2.js"></script>
</html>
