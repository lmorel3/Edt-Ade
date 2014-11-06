Edt-Lyon1
=========

Emploi du Temps - Universite Claube Benard Lyon 1 - (Ade Web Direct Planning)
*Sous Licence MIT*

##Installation
1. Récupérer le "ressourceId" correspondant à l'emploi du temps

 1. Connectez-vous sur http://adelb.univ-lyon1.fr
 2. Accédez à votre emploi du temps
 3. Cliquez sur l'icône "Flux RSS" dans les "Options" en bas à gauche, puis sur "Exporter"
 4. Vous allez être redirigé sur une page avec une URL de ce type : http://adelb.univ-lyon1.fr/direct/gwtdirectplanning/rss?projectId=..&resources=1234&cliendId=......
 5. Le "ressourceId" vous correspondant est ici "1234"

2. Modifier le "ressourceId" dans le fichier 'js/app.js'

##Modifications possibles: 
1. Récupérer les données sur plus (ou moins) de 15 jours
	Dans "rss.php", modifiez $url au début du fichier.
		Remplacez "nbDays=15" par "nbDays=NB_JOURS_VOULU"

##Problèmes possibles
Erreur lié au "projectId"
	Dans "rss.php", modifiez $url au début du fichier.
		Remplacez "projectId=6" par celui de votre URL récupérée lors de l'installation
