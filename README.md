# ProjetDevWeb


Ce dépôt représente notre site web complet d'aide à la recherche de stage. Il permet de rechercher, poster et administrer des offres et entreprises pour des étudiants

# Sommaire

![alt text](documentation/image.png)

| **Nom de la colonne**            | **Nom dans la base de données**     | **Type**         |
|-----------------------------------|-------------------------------------|------------------|
| id_utilisateur                    | ID_UTILISATEUR                      | Auto_increment   |
| nom_utilisateur                   | NOM_UTILISATEUR                     | Varchar          |
| prenom_utilisateur                | PRENOM_UTILISATEUR                  | Varchar          |
| email                              | EMAIL                               | Varchar          |
| mot_de_passe                       | MOT_DE_PASSE                        | Varchar          |
| cacher_utilisateur                 | CACHER_UTILISATEUR                  | Bool             |
| id_entreprise                      | ID_ENTREPRISE                       | Auto_increment   |
| nom                                | NOM                                 | Varchar          |
| description_entreprise             | DESCRIPTION_ENTREPRISE              | Text             |
| email_contact                      | EMAIL_CONTACT                       | Varchar          |
| telephone                          | TELEPHONE                           | Varchar          |
| image_illustration                 | IMAGE_ILLUSTRATION                  | Varchar          |
| cacher_entreprise                  | CACHER_ENTREPRISE                   | Bool             |
| id_offre                           | ID_OFFRE                            | Auto_increment   |
| titre                              | TITRE                               | Varchar          |
| description_offre                  | DESCRIPTION_OFFRE                   | Text             |
| remuneration                       | REMUNERATION                        | Float            |
| date_debut                         | DATE_DEBUT                          | Date             |
| date_fin                           | DATE_FIN                            | Date             |
| mise_en_ligne                      | MISE_EN_LIGNE                       | Date             |
| cacher_offre                       | CACHER_OFFRE                        | Bool             |
| id_competence                      | ID_COMPETENCE                       | Auto_increment   |
| competence                         | COMPETENCE                          | Varchar          |
| id_role                            | ID_ETUDIANT                         | Auto_increment   |
| nom_role                           | ROLE                                | Varchar          |
| id_log                             | ID_LOG                              | Auto_increment   |
| date_connexion                     | DATE_CONNEXION                      | Date             |
| note                               | NOTE                                | Float            |
| commentaire                        | COMMENTAIRE                          | Text             |
| date_candidature                   | DATE_CANDIDATURE                    | Date             |
| lettre_motivation                  | LETTRE_MOTIVATION                   | Varchar          |
| message_recruteur                  | MESSAGE_RECRUTEUR                   | Text             |
| id_ville                           | ID_VILLE                            | Auto_increment   |
| nom_ville                          | NOM_VILLE                           | Varchar          |
| id_pays                            | ID_PAYS                             | Auto_increment   |
| nom_pays                           | NOM_PAYS                            | Varchar          |
| id_cv                              | ID_CV                               | Auto_increment   |
| cv                                 | CV                                  | Varchar          |
