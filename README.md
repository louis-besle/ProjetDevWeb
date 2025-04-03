# ProjetDevWeb


Ce dépôt représente notre site web complet d'aide à la recherche de stage. Il permet de rechercher, poster et administrer des offres et entreprises pour des étudiants

# Sommaire

## Conception de la base de données

### Dictionnaire de données

Dans ce dictionnaire de données, vous trouverez tous les attributs de la base de données. Ce tableau permet de bien comprendre les données que nous avons besoins de stocker.

| **Nom de l'attribut**            | **Nom dans la base de données**     | **Type**         | **Taille** | **Tables**      |
|-----------------------------------|-------------------------------------|------------------|------------|-----------------|
| id_utilisateur                    | ID_UTILISATEUR                      | Auto_increment   |            | Utilisateur     |
| nom_utilisateur                   | NOM_UTILISATEUR                     | Varchar          | 50         | Utilisateur     |
| prenom_utilisateur                | PRENOM_UTILISATEUR                  | Varchar          | 50         | Utilisateur     |
| email                              | EMAIL                               | Varchar          | 75         | Utilisateur     |
| mot_de_passe                       | MOT_DE_PASSE                        | Varchar          | 255        | Utilisateur     |
| cacher_utilisateur                 | CACHER_UTILISATEUR                  | Bool             |            | Utilisateur     |
| id_entreprise                      | ID_ENTREPRISE                       | Auto_increment   |            | Entreprise      |
| nom                                | NOM                                 | Varchar          | 50         | Entreprise      |
| description_entreprise             | DESCRIPTION_ENTREPRISE              | Text             |            | Entreprise      |
| email_contact                      | EMAIL_CONTACT                       | Varchar          | 50         | Entreprise      |
| telephone                          | TELEPHONE                           | Varchar          | 50         | Entreprise      |
| image_illustration                 | IMAGE_ILLUSTRATION                  | Varchar          | 50         | Entreprise      |
| cacher_entreprise                  | CACHER_ENTREPRISE                   | Bool             |            | Entreprise      |
| id_offre                           | ID_OFFRE                            | Auto_increment   |            | Offre           |
| titre                              | TITRE                               | Varchar          | 50         | Offre           |
| description_offre                  | DESCRIPTION_OFFRE                   | Text             |            | Offre           |
| remuneration                       | REMUNERATION                        | Float            |            | Offre           |
| date_debut                         | DATE_DEBUT                          | Date             |            | Offre           |
| date_fin                           | DATE_FIN                            | Date             |            | Offre           |
| mise_en_ligne                      | MISE_EN_LIGNE                       | Date             |            | Offre           |
| cacher_offre                       | CACHER_OFFRE                        | Bool             |            | Offre           |
| id_competence                      | ID_COMPETENCE                       | Auto_increment   | 50         | Compétence      |
| competence                         | COMPETENCE                          | Varchar          | 50         | Compétence      |
| id_role                            | ID_ROLE                             | Auto_increment   |            | Rôle            |
| nom_role                           | ROLE                                | Varchar          | 50         | Rôle            |
| id_log                             | ID_LOG                              | Auto_increment   |            | Log             |
| date_connexion                     | DATE_CONNEXION                      | Date             |            | Log             |
| note                               | NOTE                                | Float            |            | Évaluer         |
| commentaire                        | COMMENTAIRE                          | Text             |            | Évaluer         |
| date_candidature                   | DATE_CANDIDATURE                    | Date             |            | Candidater      |
| lettre_motivation                  | LETTRE_MOTIVATION                   | Varchar          | 50         | Candidater      |
| message_recruteur                  | MESSAGE_RECRUTEUR                   | Text             |            | Candidater      |
| id_ville                           | ID_VILLE                            | Auto_increment   |            | Ville           |
| nom_ville                          | NOM_VILLE                           | Varchar          | 50         | Ville           |
| id_pays                            | ID_PAYS                             | Auto_increment   |            | Pays            |
| nom_pays                           | NOM_PAYS                            | Varchar          | 50         | Pays            |
| id_cv                              | ID_CV                               | Auto_increment   |            | CV              |
| cv                                 | CV                                  | Varchar          | 50         | CV              |

### Modèle Conceptuel de Données

Ensuite, ce MCD (Modèle Conceptuel de Données) permet de représenter graphiquement les données et leurs relations dans le système d'information. Ainsi, nous avons réaliser ce schéma à l'aide de notre dictionnaire de données. Nous y avons modéliser nos tables qui vont contenir les données principales du site ainsi que le relations entre elles permettant aussi de voir l'interaction des tables entre elle. Ce dernier respecte la norme <a href="https://openclassrooms.com/fr/courses/6938711-modelisez-vos-bases-de-donnees/7561516-ameliorez-votre-modelisation-grace-aux-formes-normales" target="_blank">3NF</a>.
<br>
On peut voir que l'élément central est l'utilisateur. En effet, toutes les actions seront liées à ce dernier.

![alt text](documentation/mcd.png)

### Modèle Logique de Données
Ensuite, nous avons choisi de transformer notre MCD en MLD (Modéle Logique de données) pour avoir une meilleure vision des clés étrangères entre les tables.

![alt text](documentation/mld.png)

