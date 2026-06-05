# Espace d'administration TMK

Cet espace permet de modifier le contenu du site **sans toucher au code**.
Tout est enregistré dans des fichiers JSON locaux (dossier `/content`) et les
images / vidéos envoyées vont dans le dossier `/uploads`.

## Accès

- URL : `http://localhost/tmk/admin/`
- Identifiant par défaut : **admin**
- Mot de passe par défaut : **tmk2025**

> ⚠️ **Important** : changez ces identifiants dans le fichier
> `admin/config.php` (constantes `TMK_ADMIN_USER` et `TMK_ADMIN_PASS`)
> avant la mise en ligne.

## Ce que l'administrateur peut modifier

| Section du menu | Ce qui est modifiable |
|---|---|
| **Accueil** | Vidéo et textes de l'en-tête, « Notre mission & notre vision », les actualités (ajout / suppression) |
| **Domaines d'intervention** | Titres et cartes de la page « À propos » |
| **Photos / Albums** | Ajouter / supprimer des albums (image, titre, description, catégorie, année) |
| **Vidéos** | Ajouter / supprimer des vidéos (fichier, titre, description, aperçu) |
| **Membres** | Visage (photo) et poste de chaque membre (ajout / suppression) |
| **Contact** | Adresse, téléphone, email, réseaux sociaux, textes du formulaire |
| **Statut juridique** | Titres, introduction, documents (ajout / suppression), résumé |
| **Pied de page** | Coordonnées, réseaux sociaux, newsletter, copyright |

## Fonctionnement

- Chaque modification est **appliquée immédiatement** sur le site public.
- Si un fichier JSON est absent, le site affiche les valeurs par défaut
  (le contenu d'origine), définies dans `utils/content-store.php`.
- Les dossiers `/content` et `/uploads` doivent être **accessibles en écriture**
  par le serveur web.
