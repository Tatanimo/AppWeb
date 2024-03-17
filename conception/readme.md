# Conception de l'application web

## Dictionnaire de données
### Utilisateurs
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