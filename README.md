Edt-Ade
=========

Emploi du Temps - Ade Web Direct Planning
*Sous Licence MIT*

Démo : http://lmorel3.fr/edt

##Installation
1. Récupérez le "ressourceId" correspondant à l'emploi du temps

 1. Connectez-vous sur votre Ade (ex : http://adelb.univ-lyon1.fr)
 2. Accédez à votre emploi du temps
 3. Cliquez sur l'icône "Exporter l'agenda" dans les "Options" en bas à gauche puis sur "Générer l'URL"
 4. Vous allez être redirigé sur une page avec une URL de ce type : http://adelb.univ-lyon1.fr/direct/gwtdirectplanning/rss?projectId=..&resources=1234&cliendId=......
 5. Le "ressourceId" vous correspondant est ici "1234"

2. Modifier le "ressourceId" dans le fichier "js/app.js"

##Modifications possibles: 
1. Changer la date de début et la date de fin
	Dans "retriever.php", modifiez les variables $firstDate et $lastDate
		
2. Vous pouvez ajouter plusieurs ressourceId dans le switch de "app.js"
	Les calendriers seront accessibles à http://url/?blabla
   Il est aussi possible d'ajouter plusieurs calendrier (univ) : à ajouter au tableau $univUrl

##Problèmes possibles
Erreur lié au "projectId"
	Dans "retriver.php", modifiez $projectId
