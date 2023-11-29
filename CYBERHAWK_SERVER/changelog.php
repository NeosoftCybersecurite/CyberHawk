<?php include 'config.php'; ?>

<?php 
	if (is_admin() or $_ENV['CHX_VERSION'] == "on")
	{
		echo "<div style='text-align: center;'>";

		echo "<h3><b>CyberHawk 2.2.0</b></h3>";
		echo "<div style='display: inline-block; text-align: left'>
			<ul>
				<li>Ajout de deux nouveaux languages</li>
				<ul>
					<li>Espagnol</li>
					<li>Italien</li>
				</ul>
				<li>Ajout de deux nouvelles fonctionnalités mineures</li>
				<ul>
					<li>Export des utilisateurs depuis la base de données</li>
					<li>Amélioration de l'algorithme de compression des MaJ antivirales. Réduction de 30% de la taille de l'archive journalière.</li>
				</ul>
				<li>Correction de bugs mineurs</li>
				<ul>
					<li>Erreur Thumbnail lors de l'upload d'images</li>
					<li>Inversion des boutons 'Délai de rétention' et 'Limite de stockage'</li>
					<li>Erreur lors de l'export des LOGS sur un système US / FR</li>
					<li>Suppression du cas particuliers pour les images qui étaient affichées au lieu de téléchargées.</li>
				</ul>
			</ul>
			</div>";

		echo "<h3><b>CyberHawk 2.1.0</b></h3>";
		echo "<div style='display: inline-block; text-align: left'>
			<ul>
				<li>Basculement vers le mode \"modules / plugins\"</li>
				<ul>
					<li>Ajout / Désactivation des modules désormais possible depuis l’interface d’administration.</li>
					<li>Ajout de plusieurs modules de base (désactivés par défaut) :</li>
					<ul>
						<li>VBA Blocker : Permet de bloquer tous les fichiers Office contenant des macros VBA</li>
						<li>Malicious VBA Blocker : Permet de bloquer tous les fichiers Office contenant des macros VBA jugées malveillantes</li>
						<li>OCR (Images) : Permet d'autoriser / bloquer les fichiers Images contenant certains mots (Ex. Confidentiel)</li>
						<li>OCR (PDF) : Permet d'autoriser / bloquer les fichiers Images contenant certains mots (Ex. Confidentiel)</li>
					</ul>
					<li>Revue de l'affichage des plugins et de leur état sur la page principale CyberHawk</li>
					<ul>
						<li>Un drapeau Rouge / Orange / Vert indique désormais l'état de la plateforme et remplace le tableau précédent.</li>
						<li>Un clic sur le drapeau permet d’afficher les détails des modules (état, nom, description). Ce clic est désactivable si besoin, afin de ne pas afficher de détails aux utilisateurs.</li>
						<li>Les modules peuvent être désactivés pour l’interface d’administration uniquement</li>
					</ul>
				</ul>
				<li>Optimisation du temps d'analyse</li>
				<ul>
					<li>Exécution simultanée de tous les modules (gain de temps d'environ 47% par fichier). L'activation d'un nouveau module n’additionne pas de temps d’analyse supplémentaire.</li>
					<li>Pré chargement des signatures pour les moteurs Sophos et ClamAV. Gain de 10 secondes par analyse environ.</li>
					<li>Exemple : Pour un fichier de base PDF, le temps d'analyse a été réduit de 12 secondes environ, à moins d'une seconde. </li>
				</ul>
				<li>Ajout d'un compte \"invité / générique\"</li>
				<ul>
					<li>Ce compte ajoute un lien en dessous du bouton de connexion permettant d'accéder à CyberHawk sans compte utilisateur.</li>
					<li>Il est partagé entre tous les utilisateurs, et nettoyé toutes les 24h.</li>
				</ul>
				<li>Gestion des logs</li>
				<ul>
					<li>Les logs sont désormais exportés en XML (en plus du MySQL & Syslog), format plus lisible et exploitable que le TXT.</li>
					<li>Statistiques graphiques disponibles pour les taux de détections par périodes et par plugin.</li>
				</ul>
				<li>Gestion des utilisateurs</li>
				<ul>
					<li>Possibilité pour l'administrateur de définir un espace de stockage par utilisateur (en plus de celui par défaut)</li>
					<li>Possibilité pour l'administrateur de définir un délai de rétention par utilisateur (en plus de celui par défaut)</li>
					<li>Possibilité pour l'administrateur d'exporter tous les utilisateurs de la base vers un fichier CSV</li>
				</ul>
				<li>Interface graphique</li>
				<ul>
					<li>Affichage de la version utilisée sur la page principale. Un clic sur cette version permet d'afficher les changements liées aux versions. Désactivation possible pour les utilisateurs.</li>
					<li>Ajout de balises permettant à CyberHawk une meilleure compatibilité avec les téléphones et tablettes.</li>
					<li>Amélioration de l'affichage des paramètres dans la partie administrateur.</li>
				</ul>		
				<li>Correction de bugs mineurs</li>
				<ul>
					<li>Bug d'affichage lors de l'actualisation avec la touche F5 dans certains navigateurs</li>
					<li>Bug d'affichage lors de la connexion en mode \"Kiosque Tactile\"</li>
					<li>Affichage de l'ancien Nom / Prénom utilisateur lors de la modification</li>
					<li>Logs désormais en anglais et non plus en fonction de la langue choisie par l’utilisateur.</li>
					<li>Les utilisateurs sont désormais affichés par ordre alphabétique dans le menu d'administration, et non par date d'ajout.</li>
					<li>Amélioration des listes (utilisateurs, whitelist, etc.) afin qu'elles soient plus rapides. L'affichage était lent pour un affichage de plus de 500 utilisateurs.</li>
				</ul>			
			</ul>
			</div>";
       

		echo "<h3><b>CyberHawk 2.0</b></h3>";
		echo "<div style='display: inline-block; text-align: left'>
			<ul>
				<li>Amélioration de l'interface graphique</li>
				<ul>
					<li>Refonte totale du menu</li>
					<li>Utilisation d'AJAX pour éviter le rafraîchissement</li>
					<li>Mise en place d'éléments plus actuels</li>
				</ul>
				<li>Ajout de deux moteurs antiviraux (Sophos, Comodo) et début du fonctionnement en mode \"modules\"</li>
				<li>Amélioration de l'expérience utilisateur</li>
				<ul>
					<li>Gestion de l'identification et de l'authentification</li>
					<li>Gestion des informations personnelles</li>
					<li>Possibilité de changement des options après inscription</li>
					<li>Possibilité de partage de fichier(s) via lien temporaire</li>
				</ul>
				<li>Ajout d'une interface Administrateur</li>
				<ul>
					<li>Gestion des utilisateurs</li>
					<li>Gestion des logs</li>
				</ul>
			</ul>
			</div>";


		echo "<h3><b>CyberHawk 1.0</b></h3>";
		echo "<div style='display: inline-block; text-align: left'>
			<ul>
				<li>Version Initiale CyberHawk (2010, 2011)</li>
				<li>Utilisation de JQuery BlueImp FileUpload pour la partie Upload</li>
				<li>Utilisation de ClamAV comme antivirus</li>
				<li>Interface deux pages : Identification et Upload</li>
			</ul>
			</div>";
		echo "</div>";

	}
?>
