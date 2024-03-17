# Conception de l'application web

## Dictionnaire de données
### Table UTILISATEURS
| Données | Type | Taille | Contrainte | Obligatoire | Valeur par défaut | Détail |
|-----------|-----------|-----------|-----------|-----------|-----------|-----------|
| Nom  | Alphanumérique  | 100  | / | Oui | / | Nom de l'utilisateur |
| Prénom | Alphanumérique | 50 | / | Oui | / | Prénom de l'utilisateur |
| Date de naissance | Temporel | / | / | Non | / | Date de naissance de l'utilisateur |
| Adresse | Alphanumérique | 255 | / | Non | / | Adresse de l'utilisateur |
| Email | Alphanumérique | 100 | UNIQUE | Oui | / |  Email de l'utilisateur |
| Mot de passe | Alphanumérique | 255 | / | Oui | / | Mot de passe de l'utilisateur |
| Rôles | JSON | / | / | Oui | / | Rôles de de l'utilisateur |
| Numéro de téléphone | Alphanumérique | 20 | / | Non | / | Numéro de téléphone de l'utilisateur |
| Iban | Alphanumérique | 34 | / | Non | / | Iban de l'utilisateur |
| Image | Alphanumérique | 50 | / | Non | user_default.jpg | Image de l'utilisateur |

### Table COMPAGNIES
| Données | Type | Taille | Contrainte | Obligatoire | Valeur par défaut | Détail |
|-----------|-----------|-----------|-----------|-----------|-----------|-----------|
| Nom  | Alphanumérique  | 50  | / | Oui | / | Nom de la compagnie |
| Adresse | Alphanumérique | 100 | / | Oui | / | Prénom de la compagnie |
| Image | Alphanumérique | 50 | / | Non | compagnie_default.jpg | Image de la compagnie |

### Table AVIS
| Données | Type | Taille | Contrainte | Obligatoire | Valeur par défaut | Détail |
|-----------|-----------|-----------|-----------|-----------|-----------|-----------|
| Note  | Numérique  | /  | / | Oui | / | Notation d'un utilisateur vers un autre utilisateur |
| Commentaire | Alphanumérique | 255 | / | Non | / | Commentaire d'un utilisateur vers un autre utilisateur |

### Table FAMILLES ANIMAUX
| Données | Type | Taille | Contrainte | Obligatoire | Valeur par défaut | Détail |
|-----------|-----------|-----------|-----------|-----------|-----------|-----------|
| Nom  | Alphanumérique  | 30  | Unique | Oui | / | Le nom de la famille d'animal |
| Description | Alphanumérique | Text | / | Non | / | Description de la famille d'animal |
| Image | Alphanumérique | 50 | / | Non | animal_family.jpg | Image de la famille d'animal |

### Table CATEGORIES ANIMAUX
| Données | Type | Taille | Contrainte | Obligatoire | Valeur par défaut | Détail |
|-----------|-----------|-----------|-----------|-----------|-----------|-----------|
| Nom  | Alphanumérique  | 30  | Unique | Oui | / | Le nom de la catégorie d'animal |
| Description | Alphanumérique | Text | / | Non | / | Description de la catégorie d'animal |
| Image | Alphanumérique | 50 | / | Non | animal_family.jpg | Image de la catégorie d'animal |

### Table ANIMAUX
| Données | Type | Taille | Contrainte | Obligatoire | Valeur par défaut | Détail |
|-----------|-----------|-----------|-----------|-----------|-----------|-----------|
| Nom  | Alphanumérique  | 50  | / | Oui | / | Le nom de l'animal |
| Race | Alphanumérique | 50 | / | Non | / | Race de l'animal |
| Poids | Numérique | (4,2) | / | Non | / | Poids de l'animal |
| Date de naissance | Temporel | / | / | Non | / | Date de naissance de l'animal |
| Décès | Logique | / | / | Non | / | Est-ce que l'animal est décédé ? |
| Description | Alphanumérique | Text | / | Non | / | Description de l'animal |
| Image | Alphanumérique | 50 | / | Non | animal_categorie.jpg | Image de l'animal |