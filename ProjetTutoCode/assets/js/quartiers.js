function retour_quartiers(ville)
{
	var chaine_quartiers='';

	switch(ville){
		case 'Abomey-Calavi':
		chaine_quartiers='Akassato|Arconville|Cocokodji|Godomey|Ouedo|Togbin|Zoca|Zopah';
			break;
		case 'Cotonou':
		chaine_quartiers='Agla|Akpakpa|Cadjehoun|Camp Guezo|Ex Zone Des Ambassades|Fidjrosse|Houeyiho|Les Cocotiers & Haie Vive|Sainte Cecile|Vedoko';
			break;
		case 'Ouidah':
		chaine_quartiers='Pahou';
			break;
		case 'Sakete':
		chaine_quartiers='Kossi';
			break;
		case 'Seme-Kpodji':
		chaine_quartiers='';
			break;
	}

return chaine_quartiers;
}