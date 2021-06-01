<?php  

include_once 'connectBDD.php';

class postAnnonce{
	
	private $nom;
	private $type;
	private $util;
	private $ville;
	private $quartiers;
	private $fichiers;
	private $descrip;
	private $contact;
	private $prix;
	
	public function __construct($nom , $type , $util , $ville , $quartiers , $fichiers , $descrip , $contact , $prix){
		$this->nom = $nom;
		$this->type = $type;
		$this->util = $util;
		$this->ville = $ville;
		$this->quartiers = $quartiers;
		$this->fichiers = $fichiers;
		$this->descrip = $descrip;
		$this->contact = $contact;
		$this->prix = $prix;
		$this->bdd = bdd();
	}
	public function verif(){
		$requete = $this->bdd->prepare('SELECT * from annonce WHERE nom=:nom and type=:type and whatfor=:whatfor and ville=:ville and quartier=:quartier');
		$requete->execute(array(
			'nom'=> $this->nom,
			'type'=> $this->type,
			'whatfor'=> $this->util,
			'ville'=> $this->ville,
			'quartier'=> $this->quartiers,
			));
		$reponse = $requete->fetch();
		if($reponse)
		{
        $erreur = 'Cette annonce existe déja';
		return $erreur;
		}
		else
		{
			if(strlen($this->nom)>10){
			if(strlen($this->descrip)>20){
			 if(strlen($this->contact)>7 AND strlen($this->contact)<20 AND preg_match("/[^0-9]/" , $this->contact)){
			 return 'ok';
			 }
			 else {
				$erreur = 'Mauvais format de numero de telephone';
			     return $erreur;
			 }
			}			 
			else{
				$erreur = 'La description est trop courte';
				return $erreur;
			}	
			}
			else {
				$erreur = 'Le nom doit contenir au moins 11 caractères';
				return $erreur;
			}
	}
	}
	
	public function enregistrement(){
		$requete = $this->bdd->prepare('SELECT * from annonce WHERE nom=:nom and type=:type and whatfor=:whatfor and ville=:ville and quartier=:quartier');
		$requete->execute(array(
			'nom'=> $this->nom,
			'type'=> $this->type,
			'whatfor'=> $this->util,
			'ville'=> $this->ville,
			'quartier'=> $this->quartiers
			));
		$reponse = $requete->fetch();
		if(!$reponse)
		{
		$requete = $this->bdd->prepare('INSERT INTO annonce(nom , type , ville , quartier , prix , whatfor , contact , descrip) VALUES(:nom,:type,:ville,:quartier,:prix,:whatfor,:contact,:descrip)');
		$requete->execute(array(
			'nom'=> utf8_decode($this->nom),
			'type'=> $this->type,
			'ville'=> $this->ville,
			'quartier'=> $this->quartiers,
			'prix'=> $this->prix,
			'whatfor'=> $this->util,
			'contact'=> $this->contact,
			'descrip'=> utf8_encode($this->descrip)
			));
		return 1;
		}
		else
		{
		return 0;
		}
			
	}	
}
?>	