# ProjetDevWeb


Ce dépôt représente notre site web complet d'aide à la recherche de stage. Il permet de rechercher, poster et administrer des offres et entreprises pour des étudiants

# Sommaire

![alt text](documentation/image.png)

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

<div align="center">
  <table>
    <thead>
      <tr>
        <th><strong>Nom de l'attribut</strong></th>
        <th><strong>Nom dans la base de données</strong></th>
        <th><strong>Type</strong></th>
        <th><strong>Taille</strong></th>
        <th><strong>Tables</strong></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>id_utilisateur</td>
        <td>ID_UTILISATEUR</td>
        <td>Auto_increment</td>
        <td></td>
        <td>Utilisateur</td>
      </tr>
      <tr>
        <td>nom_utilisateur</td>
        <td>NOM_UTILISATEUR</td>
        <td>Varchar</td>
        <td>50</td>
        <td>Utilisateur</td>
      </tr>
      <tr>
        <td>prenom_utilisateur</td>
        <td>PRENOM_UTILISATEUR</td>
        <td>Varchar</td>
        <td>50</td>
        <td>Utilisateur</td>
      </tr>
      <tr>
        <td>email</td>
        <td>EMAIL</td>
        <td>Varchar</td>
        <td>75</td>
        <td>Utilisateur</td>
      </tr>
      <tr>
        <td>mot_de_passe</td>
        <td>MOT_DE_PASSE</td>
        <td>Varchar</td>
        <td>255</td>
        <td>Utilisateur</td>
      </tr>
      <tr>
        <td>cacher_utilisateur</td>
        <td>CACHER_UTILISATEUR</td>
        <td>Bool</td>
        <td></td>
        <td>Utilisateur</td>
      </tr>
      <tr>
        <td>id_entreprise</td>
        <td>ID_ENTREPRISE</td>
        <td>Auto_increment</td>
        <td></td>
        <td>Entreprise</td>
      </tr>
      <tr>
        <td>nom</td>
        <td>NOM</td>
        <td>Varchar</td>
        <td>50</td>
        <td>Entreprise</td>
      </tr>
      <tr>
        <td>description_entreprise</td>
        <td>DESCRIPTION_ENTREPRISE</td>
        <td>Text</td>
        <td></td>
        <td>Entreprise</td>
      </tr>
      <tr>
        <td>email_contact</td>
        <td>EMAIL_CONTACT</td>
        <td>Varchar</td>
        <td>50</td>
        <td>Entreprise</td>
      </tr>
      <tr>
        <td>telephone</td>
        <td>TELEPHONE</td>
        <td>Varchar</td>
        <td>50</td>
        <td>Entreprise</td>
      </tr>
      <tr>
        <td>image_illustration</td>
        <td>IMAGE_ILLUSTRATION</td>
        <td>Varchar</td>
        <td>50</td>
        <td>Entreprise</td>
      </tr>
      <tr>
        <td>cacher_entreprise</td>
        <td>CACHER_ENTREPRISE</td>
        <td>Bool</td>
        <td></td>
        <td>Entreprise</td>
      </tr>
      <tr>
        <td>id_offre</td>
        <td>ID_OFFRE</td>
        <td>Auto_increment</td>
        <td></td>
        <td>Offre</td>
      </tr>
      <tr>
        <td>titre</td>
        <td>TITRE</td>
        <td>Varchar</td>
        <td>50</td>
        <td>Offre</td>
      </tr>
      <tr>
        <td>description_offre</td>
        <td>DESCRIPTION_OFFRE</td>
        <td>Text</td>
        <td></td>
        <td>Offre</td>
      </tr>
      <tr>
        <td>remuneration</td>
        <td>REMUNERATION</td>
        <td>Float</td>
        <td></td>
        <td>Offre</td>
      </tr>
      <tr>
        <td>date_debut</td>
        <td>DATE_DEBUT</td>
        <td>Date</td>
        <td></td>
        <td>Offre</td>
      </tr>
      <tr>
        <td>date_fin</td>
        <td>DATE_FIN</td>
        <td>Date</td>
        <td></td>
        <td>Offre</td>
      </tr>
      <tr>
        <td>mise_en_ligne</td>
        <td>MISE_EN_LIGNE</td>
        <td>Date</td>
        <td></td>
        <td>Offre</td>
      </tr>
      <tr>
        <td>cacher_offre</td>
        <td>CACHER_OFFRE</td>
        <td>Bool</td>
        <td></td>
        <td>Offre</td>
      </tr>
      <tr>
        <td>id_competence</td>
        <td>ID_COMPETENCE</td>
        <td>Auto_increment</td>
        <td>50</td>
        <td>Compétence</td>
      </tr>
      <tr>
        <td>competence</td>
        <td>COMPETENCE</td>
        <td>Varchar</td>
        <td>50</td>
        <td>Compétence</td>
      </tr>
      <tr>
        <td>id_role</td>
        <td>ID_ROLE</td>
        <td>Auto_increment</td>
        <td></td>
        <td>Rôle</td>
      </tr>
      <tr>
        <td>nom_role</td>
        <td>ROLE</td>
        <td>Varchar</td>
        <td>50</td>
        <td>Rôle</td>
      </tr>
      <tr>
        <td>id_log</td>
        <td>ID_LOG</td>
        <td>Auto_increment</td>
        <td></td>
        <td>Log</td>
      </tr>
      <tr>
        <td>date_connexion</td>
        <td>DATE_CONNEXION</td>
        <td>Date</td>
        <td></td>
        <td>Log</td>
      </tr>
      <tr>
        <td>note</td>
        <td>NOTE</td>
        <td>Float</td>
        <td></td>
        <td>Évaluer</td>
      </tr>
      <tr>
        <td>commentaire</td>
        <td>COMMENTAIRE</td>
        <td>Text</td>
        <td></td>
        <td>Évaluer</td>
      </tr>
      <tr>
        <td>date_candidature</td>
        <td>DATE_CANDIDATURE</td>
        <td>Date</td>
        <td></td>
        <td>Candidater</td>
      </tr>
      <tr>
        <td>lettre_motivation</td>
        <td>LETTRE_MOTIVATION</td>
        <td>Varchar</td>
        <td>50</td>
        <td>Candidater</td>
      </tr>
      <tr>
        <td>message_recruteur</td>
        <td>MESSAGE_RECRUTEUR</td>
        <td>Text</td>
        <td></td>
        <td>Candidater</td>
      </tr>
      <tr>
        <td>id_ville</td>
        <td>ID_VILLE</td>
        <td>Auto_increment</td>
        <td></td>
        <td>Ville</td>
      </tr>
      <tr>
        <td>nom_ville</td>
        <td>NOM_VILLE</td>
        <td>Varchar</td>
        <td>50</td>
        <td>Ville</td>
      </tr>
      <tr>
        <td>id_pays</td>
        <td>ID_PAYS</td>
        <td>Auto_increment</td>
        <td></td>
        <td>Pays</td>
      </tr>
      <tr>
        <td>nom_pays</td>
        <td>NOM_PAYS</td>
        <td>Varchar</td>
        <td>50</td>
        <td>Pays</td>
      </tr>
      <tr>
        <td>id_cv</td>
        <td>ID_CV</td>
        <td>Auto_increment</td>
        <td></td>
        <td>CV</td>
      </tr>
      <tr>
        <td>cv</td>
        <td>CV</td>
        <td>Varchar</td>
        <td>50</td>
        <td>CV</td>
      </tr>
    </tbody>
  </table>
</div>
