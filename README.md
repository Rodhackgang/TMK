<div align="center">

<img src="https://capsule-render.vercel.app/api?type=waving&color=gradient&customColorList=0,2,2,5,30&height=150&section=header&text=TMK&fontSize=40&fontColor=ffffff&fontAlignY=38&desc=Gestionnaire%20de%20contenu&descAlignY=62&descSize=14&animation=fadeIn" width="100%" alt="TMK — Gestionnaire de contenu" />

<p>
  <img src="https://img.shields.io/badge/Projet-3FB950?style=flat-square" alt="Projet" />
  <img src="https://img.shields.io/github/languages/top/Rodhackgang/TMK?style=flat-square&color=1D4ED8" alt="Langage principal" />
  <img src="https://img.shields.io/github/last-commit/Rodhackgang/TMK?style=flat-square&color=1D4ED8&label=dernier%20commit" alt="Dernier commit" />
  <img src="https://img.shields.io/github/repo-size/Rodhackgang/TMK?style=flat-square&color=1D4ED8&label=taille" alt="Taille" />
</p>

<p>
  <img src="https://img.shields.io/badge/Node.js-339933?logo=nodedotjs&logoColor=white&style=for-the-badge" alt="Node.js" />
  <img src="https://img.shields.io/badge/Express-000000?logo=express&logoColor=white&style=for-the-badge" alt="Express" />
  <img src="https://img.shields.io/badge/MongoDB-47A248?logo=mongodb&logoColor=white&style=for-the-badge" alt="MongoDB" />
  <img src="https://img.shields.io/badge/JWT-000000?logo=jsonwebtokens&logoColor=white&style=for-the-badge" alt="JWT" />
  <img src="https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white&style=for-the-badge" alt="Docker" />
</p>

</div>

---

## Présentation

Back-office qui pilote l'intégralité du site de la TMK Foundation : chaque section — accueil, à propos, histoire, équipe, services, contact, mentions juridiques, albums, vidéos — possède son modèle, son écran d'administration et son API.

**Pourquoi ce choix.** Un site institutionnel dont le contenu change souvent ne doit pas exiger un développeur à chaque virgule. Ce gestionnaire met la main au client, sans lui donner accès au code.

---

## Ce que fait le projet

- **11 types de contenu** modélisés séparément (accueil, à propos, histoire, équipe, contact, juridique, albums, vidéos, liens de navigation, pied de page, membres)
- **Authentification JWT** avec `bcryptjs`, cookies et middleware de protection des routes d'écriture
- **Téléversement de médias** via `multer`, servis en statique
- **Écrans d'administration autonomes** en HTML/JS, un par section
- **Amorçage** des liens de navigation par script (`npm run init-links`)
- **Conteneurisé** — `Dockerfile` fourni

---

## Stack

<div align="center">

<img src="https://img.shields.io/badge/Node.js-339933?logo=nodedotjs&logoColor=white&style=for-the-badge" alt="Node.js" />
<img src="https://img.shields.io/badge/Express-000000?logo=express&logoColor=white&style=for-the-badge" alt="Express" />
<img src="https://img.shields.io/badge/MongoDB-47A248?logo=mongodb&logoColor=white&style=for-the-badge" alt="MongoDB" />
<img src="https://img.shields.io/badge/JWT-000000?logo=jsonwebtokens&logoColor=white&style=for-the-badge" alt="JWT" />
<img src="https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white&style=for-the-badge" alt="Docker" />

</div>

---

## Démarrage

```bash
npm install
cp .env.example .env   # MONGODB_URI, JWT_SECRET
npm run init-links
npm run dev
```

---

<div align="center">

### Développé par Rodrigue SAMA

<a href="https://github.com/Rodhackgang"><img src="https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white" alt="GitHub" /></a>
<a href="https://wa.me/22677701726"><img src="https://img.shields.io/badge/WhatsApp-25D366?style=for-the-badge&logo=whatsapp&logoColor=white" alt="WhatsApp" /></a>
<a href="mailto:Samarodrigue690@gmail.com"><img src="https://img.shields.io/badge/Email-D14836?style=for-the-badge&logo=gmail&logoColor=white" alt="Email" /></a>

<sub>Ouagadougou, Burkina Faso 🇧🇫</sub>

<img src="https://capsule-render.vercel.app/api?type=waving&color=gradient&customColorList=0,2,2,5,30&height=100&section=footer" width="100%" alt="" />

</div>
