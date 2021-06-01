function retour_biens(param)
{
	var chaine_biens='';

	switch(param){
		case 'SupprimerBien':
		chaine_biens='Bureaux & Commerces|Chambres|Maisons de vacances|Terrain|Villas';
			break;
	}

return chaine_biens;
}