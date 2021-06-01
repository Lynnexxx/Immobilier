<?php  

include_once 'connectBDD.php';

class inscription{
	
	private $pseudo;
	private $email;
	private $mdp;
	private $mdp2;
	
	public function __construct($pseudo , $email , $mdp , $mdp2){
		$pseudo = htmlspecialchars($pseudo);
		$email =htmlspecialchars ($email);
		$this->pseudo = $pseudo;
		$this->email = $email;
		$this->mdp = $mdp;
		$this->mdp2 = $mdp2;
		$this->bdd = bdd();
	}
	public function verif(){
		$requete = $this->bdd->prepare('SELECT pseudo from membres WHERE pseudo = :pseudo');
		$requete->execute(array(
			'pseudo'=> $this->pseudo
			));
		$reponse = $requete->fetch();
		if($reponse)
		{
        $erreur = 'Un utilisateur du meme nom existe déja';
		return $erreur;
		}
		else
		{
			if(strlen($this->pseudo)>5 AND strlen($this->pseudo)<20){
			if(strlen($this->mdp)>5 AND strlen($this->mdp)<20){
			 if($this->mdp == $this->mdp2){
			 return 'ok';
			 }
			 else {
				$erreur = 'Les mots de passe doivent être identiques';
			     return $erreur;
			 }
			}			 
			else{
				$erreur = 'Le mot de passe doit être compris entre 5 et 20 caractères';
				return $erreur;
			}
				
		}
			else {
				$erreur = 'Le pseudo doit être compris entre 5 et 20 caractères';
				return $erreur;
			}
	}
	}
	
	public function enregistrement(){
		$requete = $this->bdd->prepare('SELECT pseudo from membres WHERE pseudo = :pseudo');
		$requete->execute(array(
			'pseudo'=> $this->pseudo
			));
		$reponse = $requete->fetch();
		if(!$reponse)
		{
		$requete = $this->bdd->prepare('INSERT INTO membres(pseudo , email , mdp , type) VALUES(:pseudo,:email,:mdp,:type)');
		$requete->execute(array(
			'pseudo'=> $this->pseudo ,
			'email'=> $this->email,
			'mdp'=> $this->mdp,
			'type'=> ''
			));
		
	$header="MIME-Version: 1.0\r\n";
	$header.='From:"Murielle"<essena.agb@gmail.com>'."\n";
	$header.='Content-Type:text/html; charset="uft-8"'."\n";
	$header.='Content-Transfer-Encoding: 8bit';

	$message='
	<html>
		<body>
			<div align="center">
				<img src="http://www.primfx.com/mailing/banniere.png"/>
				BIENVENUE DANS LA MEILLEURE APPLICATION WEB DE GESTION IMMOBILIERE DU BENIN !!! <br/>
				<b>ImmobPorto</b><br/>
				<img src="http://www.primfx.com/mailing/separation.png"/>
			</div>
		</body>
	</html>
	';
mail($this->email, "Bienvenue " . $this->pseudo . " dans le site ImmobPorto", $message, $header);		
			
		return 1;
		}
		else
		{
		return 0;
		}
			
	}	
}
?>
		
		