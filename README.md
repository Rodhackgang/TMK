# Backend - Gestionnaire de Liens TMK

Application Node.js pour gérer dynamiquement les liens de navigation du site TMK Foundation via MongoDB.

## Installation

```bash
cd Backend
npm install
```

## Démarrage

```bash
# Mode production
npm start

# Mode développement (avec auto-reload)
npm run dev
```

Le serveur sera accessible sur `http://localhost:3000`

## Initialiser les liens par défaut

```bash
npm run init-links
```

## URLs

- **Interface admin**: http://localhost:3000/admin
- **API**: http://localhost:3000/api

## API REST

| Méthode | URL | Description |
|---------|-----|-------------|
| GET | `/api/links` | Liens actifs (pour le header) |
| GET | `/api/admin/links` | Tous les liens (admin) |
| GET | `/api/admin/links/:id` | Un lien par ID |
| POST | `/api/admin/links` | Créer un lien |
| PUT | `/api/admin/links/:id` | Modifier un lien |
| DELETE | `/api/admin/links/:id` | Supprimer un lien |

## Structure

```
Backend/
├── server.js          # Serveur Express
├── config.js          # Configuration MongoDB
├── package.json       # Dépendances
├── models/
│   └── NavLink.js     # Modèle Mongoose
├── routes/
│   └── api.js         # Routes API
├── public/
│   └── admin.html     # Interface admin
└── scripts/
    └── init-links.js  # Script d'initialisation
```
# TMK
