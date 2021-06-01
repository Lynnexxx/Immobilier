<?php include_once 'connectBDD.php';

class connexion{
	private $pseudo;
	private $mdp;
	private $bdd;
	
	public function __construct($pseudo,$mdp) {
	$this->pseudo = $pseudo;
	$this->mdp = $mdp;
	$this->bdd = bdd();
	}
	
	public function verif(){
		if($this->pseudo=='admin' AND $this->mdp=='admin')
		{
			return 'okadmin';
		}
		else if ($this->pseudo=='agent' AND $this->mdp=='agent')
		{
			return 'okagent';
		}
		else
		{
		$requete = $this->bdd->prepare('SELECT * FROM membres WHERE pseudo = :pseudo');
		$requete->execute(array('pseudo'=> $this->pseudo));
		$reponse = $requete->fetch();
		if($reponse){
			if($this->mdp==$reponse['mdp']){
				return 'ok';
			}
			else {
				$erreur = 'Le mot de passe est incorrect';
				return $erreur;
			}
		}
		else {
			$erreur = 'Le pseudo est inexistant';
			return $erreur;
		}
		}
	}
	
		public function session(){
		$requete = $this->bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo');
		$requete->execute(array('pseudo'=> $this->pseudo));
		$requete = $requete->fetch();
		$_SESSION['id'] = $requete['id'];
		$_SESSION['pseudo'] = $this->pseudo;
		return 1;
		
    }
}
?>
	