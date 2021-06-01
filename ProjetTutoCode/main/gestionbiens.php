<?php
include_once '../function/connectBDD.php';
$bdd = bdd();?>
<!-- Ecriture dans suppr_biens.js -->
<?php
$requete = $bdd->query('SELECT nom from biens ORDER BY nom');
$fichier = fopen("../assets/js/suppr_biens.js","w");
fclose($fichier);

$fichier = fopen("../assets/js/suppr_biens.js","w+");

fwrite($fichier,"function retour_biens(param)\r\n{");
fwrite($fichier,"\r\n\tvar chaine_biens='';\r\n");
fwrite($fichier,"\r\n\tswitch(param){\r\n");

$habitat = "SupprimerBien";
$chaine = "";
$chaine.="\t\tcase '".$habitat."':\r\n";
$chaine.="\t\tchaine_biens='";
while($result=$requete->fetch())
{
$chaine.=trim(utf8_encode($result["nom"]))."|";
}
$chaine =rtrim($chaine,"|");
$chaine.="';\r\n";
$chaine.= "\t\t\tbreak;\r\n";

fwrite($fichier,$chaine);

fwrite($fichier,"\t}\r\n\r\nreturn chaine_biens;\r\n}");
fclose($fichier);

if (isset ($_POST['operation']))
{
	if($_POST['operation']=="AjouterBien")
	{
	if(isset($_POST['nom']))
	{
	$requete = $bdd->prepare('SELECT * from biens WHERE nom = :nom');
	$requete->execute(array('nom'=> $_POST['nom']));
	$result = $requete->fetch();
	if(!$result)
	{
	$requete = $bdd->prepare('INSERT into biens(nom) VALUES(:nom)');
	$requete->execute(array('nom'=> $_POST['nom']));
	$success = "Le type de bien ".$_POST['nom']." a bien été ajouté";
	}
	else {
	$erreur = "Le type de bien existe déja";
	}
	
	}
	}
	
	if($_POST['operation']=="SupprimerBien")
	{
	if(isset($_POST['suppr_biens']))
	{
	$requete = $bdd->prepare('DELETE from biens WHERE nom = :nom');
	$requete->execute(array('nom'=> $_POST['suppr_biens']));
	$success = "Le type de bien ".$_POST['suppr_biens']." a bien été supprimé";
	
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
  <link href="../assets/css/style.css"  rel="stylesheet"/>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/paper-dashboard.css?v=2.0.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
   <link href="../assets/css/esthetics.css" rel="stylesheet"/>
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
		  <li>
            <a href="./gestionvilles.php">
              <i class="nc-icon nc-istanbul"></i>
              <p>Gestion villes</p>
            </a>
          </li>
		  <li class="active">
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
	  <h1> <b>Gestion des biens</b> </h1>
	<form class="course-search-form" method="POST" action="gestionbiens.php">
	 <select id="choose" name="operation" class="custom-select" onChange="chargerTypeBien()">
	 <option value="none">
	 Veuillez sélectionner le type d'opération
	 </option>
	 <option value="AjouterBien">
	 Ajouter un type de bien
	 </option>
	 <option value="SupprimerBien">
	 Supprimer un type de bien
	 </option>
	 </select>
	 <br/>
	 <div id="magic">
	&nbsp;
	</div>
	 <br/>
	 <input type="submit" name="execute" value="Executer" class="site-btn"/><br/>
	 <script src="../assets/js/suppr_biens.js"></script>
	 <script>
function chargerTypeBien()
{
var tab_biens=""; var nb_biens=0; var chaine_liste="";
var le_study = document.getElementById("choose").value;
if(le_study == "AjouterBien")
{
chaine_liste = "<input type='text' name='nom'>";
document.getElementById("magic").innerHTML = chaine_liste;
}
if(le_study == "SupprimerBien")
{
tab_biens = retour_biens(le_study).split('|');
nb_biens = tab_biens.length;

chaine_liste = "<select class='custom-select' name='suppr_biens'>";
chaine_liste += "<option value='none5' disabled>Sélectionner le type de bien à supprimer</option>";

for(var defil=0 ; defil<nb_biens ; defil++)
	{
		chaine_liste += "<option value='" + tab_biens[defil] + "'>" + tab_biens[defil] + "</option>";
	}
	chaine_liste += "</select>";
	document.getElementById("magic").innerHTML = chaine_liste;
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
	  if (isset($_GET['delete']))
	  {
		$delete = $bdd->prepare('DELETE from biens WHERE nom = :nom');
		$delete->execute(array('nom' => $_GET['delete']));
		$query = $bdd->query('SELECT nom from biens ORDER BY nom');
		$result =$query->fetch();
		if(!$result)
		{echo "<h3><center>Il n'y a pas de types de biens disponibles</center></h3>";}
	  else {
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
					
						<div class="ci-thumb set-bg" data-setbg="<?php echo "../assets/img/".$result['nom'].".jpg"?>"></div>
						<div class="ci-text">
						<h3><?php echo $result['nom']?></h3>
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
	  }
	  else {
	  echo "<center><h2><i><b>"."Types de biens disponibles"."</b></i></h2></center>";
	  $query = $bdd->query('SELECT nom from biens ORDER BY nom');
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
					
						<div class="ci-thumb set-bg" data-setbg="<?php echo "../assets/img/".$result['nom'].".jpg"?>"></div>
						<div class="ci-text">
						<h3><?php echo $result['nom']?></h3>
						<p></p>
						<span></span>
						</div>
						<div>
						<a href="gestionbiens.php?delete=<?php echo $result['nom']?>">
						<span class="btn btn-danger ccm_sticker__btn" aria-hidden="true">
						<i class="glyphicon glyphicon-download-alt"></i>
						Supprimer</span>
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
