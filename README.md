# CyberHawk 
![Static Badge](https://img.shields.io/badge/Linux%20-%20?label=Plateform)
![Static Badge](https://img.shields.io/badge/Python%203.7%20%2B%20-%20?label=Support&color=orange)
![Static Badge](https://img.shields.io/badge/N%C3%A9osoft%20-%20?label=Dev%20Team&color=blue)

<p align="center">
   <img src="/CYBERHAWK-IL/logo.png" alt="Alt text">
</p>

> [!CAUTION]
> This project is no longer maintained by Neosoft, and we are releasing it under the GPLv3 license in order to make it available to the community and to those who need our solution.

>[!WARNING]
>Description in French first, then in English below.You can see in some documents the name of the company CONIX. CONIX is now part of the Neosoft group, with no particular distinction.

>[!IMPORTANT]
>Description in French first, then in English below.
>- The installation manual is currently only available in french. Sorry for the inconvenience.

## [FR][CyberHawk] Fiche descriptive

### Problématiques et enjeux :

Afin de transférer des fichiers (firmwares, documents, etc.) contenus sur des média amovibles (supports USB) vers des réseaux de confiance (ou à sécurité renforcée), des interventions physiques sur les équipements du réseau sont nécessaires.

La problématique inhérente à cette pratique reste la propagation (automatique ou non) d’éléments potentiellement malveillants à l’intérieur du réseau de confiance. Ces éléments, en fonction de leur niveau de menace, pourraient porter atteinte à la disponibilité, l’intégrité ou encore à la confidentialité de celui-ci.

### Présentation synthétique du projet :

La solution de SAS Néosoft « CyberHawk » permet de s’affranchir du besoin d’utilisation de médias amovibles à l’intérieur du réseau de confiance, grâce à l’utilisation d’un serveur de décontamination antivirus cloisonné, accessible via une interface web d’échange de fichiers. 

L’accès à l’interface web de gestion de fichiers peut être mis à disposition sur un système d’information (SI) séparé de moindre importance, ou sur une station dédiée sécurisée (borne libre-service). 

Sur CyberHawk, chaque utilisateur est libre de créer son espace personnel et de transférer les fichiers de son choix. Ces fichiers sont ensuite analysés par plusieurs solutions antivirales avant d’être stockés (ou supprimés si une menace est détectée par au moins un antivirus).

Contrairement aux solutions physiques concurrentes permettant la décontamination de clés USB sur borne, CyberHawk permet une décontamination via le réseau quel que soit le support utilisé. Elle peut aussi être utilisée pour l’échange sécurisé de fichiers sur un même réseau. 

*Note : La décontamination est effectuée sur le / les fichier(s) envoyé(s) mais n’est pas réalisée sur le média amovible.*

### Architecture de CyberHawk :

<p align="center">
   <img src="/CYBERHAWK-IL/architecture.png" alt="Alt text">
</p>

### Matrice de flux :

<p align="center">
   <img src="/CYBERHAWK-IL/flux.png" alt="Alt text">
</p>

### Cas d’usages :

**Envoi et décontamination depuis un média amovible :**

Le média amovible est inséré dans le **Poste de Travail Libre-Service** (ou, selon le choix client, sur un poste quelconque dans le réseau)
L’utilisateur, après s’être identifié / authentifié sur le portail web sur le **Serveur de Décontamination**, envoie un ou plusieurs fichiers dans son espace personnel.
Le fichier est analysé par le **Serveur de Décontamination** et supprimé dans le cas où il serait infecté. Dans le cas contraire, il est laissé à disposition de l’utilisateur dans son espace personnel

<p align="center">
   <img src="/CYBERHAWK-IL/e1.png" alt="Alt text">
</p>

**Récupération de fichier depuis le réseau de confiance :**

L’utilisateur, après s’être authentifié sur le portail web du **Serveur de Décontamination**, récupère un ou plusieurs fichiers dans son espace personnel.

<p align="center">
   <img src="/CYBERHAWK-IL/e2.png" alt="Alt text">
</p>

L’accès à l’interface de gestion de fichiers du **Serveur de Décontamination** est réalisé en mode Web uniquement, à l’aide d’un navigateur web (Internet Explorer, Chrome, Firefox, etc.). L’interface est accessible à l’ensemble des utilisateurs créant un compte sur l’application (configuration possible afin de créer des comptes à la demande uniquement). Sur le **Poste de Travail en Libre-Service**, seule l’Interface Web est accessible et la navigation dans le système est impossible. 

<p align="center">
   <img src="/CYBERHAWK-IL/e3.png" alt="Alt text">
</p>

Plusieurs états sont disponibles sur l’interface web du **Serveur de Décontamination**. Des indicateurs visibles par tous les utilisateurs permettent de comprendre l’état de la plateforme :

> [!NOTE]
> **Vert** : Fonctionnement normal de l’application.

> [!WARNING]
> **Orange** : Dysfonctionnement non bloquant. Utilisation de l’application possible mais non recommandée en raison d’un manque de mises-à-jour des bases de signatures antivirus. L’envoi et le téléchargement de fichiers restent néanmoins possibles.

> [!CAUTION]
>  **Rouge** : Dysfonctionnement bloquant. Utilisation de l’application possible uniquement pour récupérer des fichiers déjà présents sur l’espace utilisateur. Envoi de fichiers impossible en raison d’un dysfonctionnement de l’un ou de plusieurs moteurs antivirus. 

### Avantages :

- Solution sécurisée de transfert de fichiers permettant de préserver un système d’information ou un environnement sensible vis-à-vis des codes malveillants.
- Véritable alternative aux échanges par email ou médias amovibles (clé USB, CD/DVD, etc.)
- Solution centralisée et intégrée de transfert de fichiers (Métier) avec analyse anti-malware (Sécurité) entre environnements de sensibilité distincte et/ou au sein d’un même environnement
- Interface web avec prise en main intuitive pour les utilisateurs et administrateurs
- Flexibilité optimale avec des modes de déploiement multiples (serveur sur site, serveur relais en DMZ, couplages externes, mode SaaS, borne interactive avec E/S USB, etc.)

### Spécifications techniques et fonctions supportées :

- Système d’exploitation : distributions Linux Debian
- Dépôt/Récupération de fichiers (tout format) unitaires ou multiples avec purge automatique [Paramétrable] ou suppression manuelle par l’utilisateur
- Partage de fichiers entre utilisateurs (hyperlien activable par l’utilisateur)
- Analyse anti-malware (virus/worm/rootkit/trojan/randsomware/etc.) multi-moteurs cumulables (séquencement ClamAV/Sophos/Comodo par défaut [Paramétrable]) avec blocage en cas de code malveilant
- Intégration ou couplage externe (analyse déportée / en cloud) avec des moteurs anti-malware compatibles avec les distributions Linux Debian [Paramétrable et sous réserve de pré-qualification]
- Mise à jour manuelle ou automatique des moteurs et signatures AV par le biais d’un relais (ex : en DMZ), d’un proxy interne ou directement auprès du serveur miroir en Cloud Conix [Paramétrable]
- Support des principaux navigateurs du marché (IE, Edge, Chrome, Firefox)
- Authentification login/mdp ou simple identification des utilisateurs [Paramétrable]
- Gestion des comptes utilisateurs en local en mode autonome ou circuit de validation [Paramétrable] avec espace individuel cloisonné [capacité paramétrable]
- Journalisation des connexions et évènements systèmes/sécurité en local et/ou en export syslog

### Historique des implémentations / Améliorations effectuées (version 2) :

- [x] Amélioration de l’interface graphique et remise au goût du jour
- [x] Ajout de la langue anglaise dans l’outil
- [x] Ajout de didacticiels FR / EN
- [x] Implémentation d’un mécanisme d’authentification en plus de celui d’identification. L’utilisateur peut, selon la sensibilité de ses fichiers, choisir entre identification (aucun mot de passe) et authentification.
- [x] Intégration de nouveaux antivirus dans le moteur de la solution ainsi que dans l’interface graphique
- [x] Interfaçage optionnel de la solution « CyberHawk » avec la solution « ThreatHydra » afin de réaliser de l’analyse comportementale des fichiers envoyés
- [x] Ajout d’une interface administrateur (gestion des utilisateurs, mise à jour manuelle des antivirus, etc.)
- [x] Ajout d’un processus complet d’installation afin de faciliter le déploiement de la solution
  - Choix des antivirus à activer
  - Mise en place de White-Lists / Black-Lists
  - Langue par défaut
  - Logos
  - Configuration des espaces personnels (tailles maximales, etc.)

## Installation des environnements de CyberHawk :
- Lire la documentation fonctionnelle présente dans « **[FR][CyberHawk] Documentation Fonctionnelle** »
- Remplir le question présents dans le fichier « **[FR][CyberHawk] Questionnaire Client** »
- Installation des environnements Cyberhawk en suivant la procédure présente dans le document « **[FR][CyberHawk] Documentation Installation** »
- Lire le manuel utilisateur « **[FR][CyberHawk] Manuel Utilisateur** »

 ## [EN][CyberHawk] Description Sheet 

### Issues and challenging: 
In order to transfer files (firmware, documents etc.) from removable media (USB drives) to trusted / sensitive networks, physical interventions on network equipment(s) are required.
Inherent problematic with this practice is spreading (automatically or not) potentially malicious elements inside the trusted / sensitive network. These elements, according to their threat level, could affect the availability, integrity or confidentiality of the network.

### Summary presentation of the project:

The Néosoft "CyberHawk" solution eliminates the need of removable media usage inside trusted / sensitive network, through the use of antivirus decontamination on an isolated server, accessible via a web interface for file transfers.

Access to the file management web interface can be provided on a separated information system (IS), or on a secure dedicated station (self-service / kiosk station).

Within CyberHawk, each user is free to create his personal space and transfer files of their choice. These files are then analyzed by several antivirus engines before being stored (or deleted if a threat is detected by at least one antivirus).

Unlike competitive solutions allowing USB keys decontamination on physical terminal, CyberHawk allows decontamination via the network, regardless of the medium used. It can also be used for secure files’ exchange on the same network.

*Note: Decontamination is performed on the sent file(s) but is not performed on the removable media.*

### CyberHawk Architecture :

<p align="center">
   <img src="/CYBERHAWK-IL/architecture.png" alt="Alt text">
</p>

### Flow matrix :

<p align="center">
   <img src="/CYBERHAWK-IL/flux.png" alt="Alt text">
</p>

### Use cases:

**File upload from removable media and decontamination:**
Removable media is inserted within Self-Service Station (or, depending on customer’s choice, on any station within “untrusted” domain).
User, after being identified / authenticated on the Decontamination Server’s web interface, uploads one or more file to his personal space 
File is then analyzed by the Decontamination Server and removed if a potential threat is detected. Otherwise, it is left available to the user in his personal space.

<p align="center">
   <img src="/CYBERHAWK-IL/e1.png" alt="Alt text">
</p>

**Files’ download from the trusted domain:**
User, after being identified / authenticated on the Decontamination Server’s web interface, downloads one or more file from his personal space.

<p align="center">
   <img src="/CYBERHAWK-IL/e2.png" alt="Alt text">
</p>

Access to file management interface of the Decontamination Server is realized in Web mode only, using a web browser (Internet Explorer, Chrome, Firefox, etc.). This interface is available to all users having an account on the application (configuration possible to create accounts on request only). On Self-Service Station, only the Web Interface is accessible and the system access is made impossible.

<p align="center">
   <img src="/CYBERHAWK-IL/e3.png" alt="Alt text">
</p>

Several states are available on the Decontamination Server web interface. Indicators are made available to all users for viewing the state of the platform:
> [!NOTE]
> **Green**: Application in normal operating mode. 

> [!WARNING]
> **Orange**: Non-blocking malfunction. Using the application is possible, but not recommended due to a lack of antivirus signature databases update. Uploading and downloading files remain possible.

> [!CAUTION]
> **Red**: Blocking malfunction. Using the application is possible for downloading files already present within the user’s space. Files’ upload is not possible due to a malfunction of one or more antivirus engines.

### Implementations / Improvements (version 2):
- [x] Improved GUI
- [x] Language support (French / English by default, other on demand)
- [x] Adding tutorial (FR / EN)
- [x] Implementation of an authentication mechanism in addition to the identification one. Users can, depending on the sensitivity of their files, choose between identification (no password) and authentication.
- [x] New antiviruses’ integration in the application engine and within web interface.
- [x] Optional interfacing of the “CyberHawk” solution with the "ThreatHydra" solution to perform a behavioral analysis of uploaded files
- [x] Adding administrative interface (users’ management, manual antiviruses update, etc.)
- [x] Adding a complete installation mechanism in order to simplify solution deployment:
     - On-demand antiviruses activation
     - Implementation of “White-Lists / Black-Lists”
     - Default language
     - Customer’s personalization
     - Personal spaces configuration (maximum storage space, etc.)

## Setting up CyberHawk environments:
- Read the functional documentation in "**[EN][CyberHawk] Functional Documentation**".
- Fill in the question in the file "**[EN][CyberHawk] Client Questionnaire**".
- Install Cyberhawk environments following the procedure in the document "**[FR][CyberHawk] Documentation Installation**". 
- Read the user manual "**[EN][CyberHawk] User Manual**".
