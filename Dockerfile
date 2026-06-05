# ──────────────────────────────────────────────
#  Image Docker pour l'admin / API Node.js (TMK)
#  Force Coolify à lancer Node (et non le PHP).
# ──────────────────────────────────────────────
FROM node:20-alpine

WORKDIR /app

# Installer les dépendances en premier (cache Docker)
COPY package*.json ./
RUN npm install --omit=dev

# Copier le reste du code (les gros dossiers sont exclus via .dockerignore)
COPY . .

# Le serveur écoute sur le port défini dans .env (PORT=6000)
EXPOSE 6000

CMD ["node", "server.js"]
