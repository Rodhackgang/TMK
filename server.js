require('dotenv').config();
const express = require('express');
const mongoose = require('mongoose');
const cors = require('cors');
const bodyParser = require('body-parser');
const cookieParser = require('cookie-parser');
const path = require('path');
const config = require('./config.js');

const app = express();
const PORT = config.PORT || 3000;

// Middleware
app.use(cors({
  origin: true,
  credentials: true
}));
app.use(cookieParser());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.static('public'));
app.use('/uploads', express.static('uploads'));

// Servir les fichiers du dossier parent (images, css, js du site principal)
app.use('/images', express.static(path.join(__dirname, '..', 'images')));
app.use('/css', express.static(path.join(__dirname, '..', 'css')));
app.use('/js', express.static(path.join(__dirname, '..', 'js')));
app.use('/fonts', express.static(path.join(__dirname, '..', 'fonts')));

// Importer les fonctions d'export
const { exportLinksToJSON, exportContentToJSON, exportAboutToJSON, exportHistoryToJSON, exportTeamToJSON, exportContactToJSON, exportJuridicalToJSON, exportFooterToJSON, exportPhotosToJSON, exportVideosToJSON, exportMembersToJSON } = require('./utils/exportLinks');
const NavLink = require('./models/NavLink');
const HomeContent = require('./models/HomeContent');
const AboutContent = require('./models/AboutContent');
const HistoryContent = require('./models/HistoryContent');
const TeamContent = require('./models/TeamContent');
const ContactContent = require('./models/ContactContent');
const JuridicalContent = require('./models/JuridicalContent');
const FooterContent = require('./models/FooterContent');
const AlbumContent = require('./models/AlbumContent');
const VideoContent = require('./models/VideoContent');
const ServiceMemberContent = require('./models/ServiceMemberContent');

// Routes d'authentification
const { router: authRoutes, initializeDefaultAdmin } = require('./routes/auth');
app.use('/api/auth', authRoutes);

// Routes API (protégées par vérification de permission côté client)
const apiRoutes = require('./routes/api');
const contentRoutes = require('./routes/content');
const uploadRoutes = require('./routes/upload');
app.use('/api', apiRoutes);
app.use('/api/content', contentRoutes);
app.use('/api/upload', uploadRoutes);

// Connexion à MongoDB
mongoose.connect(config.MONGODB_URI, {
  useNewUrlParser: true,
  useUnifiedTopology: true
})
.then(async () => {
  console.log('✅ Connecté à MongoDB');
  
  // Initialiser l'admin par défaut
  console.log('👤 Vérification de l\'admin par défaut...');
  await initializeDefaultAdmin();
  
  // Exporter les liens au démarrage
  console.log('📝 Export des liens vers nav-links.json...');
  await exportLinksToJSON(NavLink);
  
  // Exporter le contenu de la page d'accueil
  console.log('📝 Export du contenu vers home-content.json...');
  await exportContentToJSON(HomeContent);
  
  // Exporter le contenu de la page About
  console.log('📝 Export du contenu vers about-content.json...');
  await exportAboutToJSON(AboutContent);
  
  // Exporter le contenu de la page Histoire
  console.log('📝 Export du contenu vers history-content.json...');
  await exportHistoryToJSON(HistoryContent);
  
  // Exporter le contenu de la page Équipe
  console.log('📝 Export du contenu vers team-content.json...');
  await exportTeamToJSON(TeamContent);
  
  // Exporter le contenu de la page Contact
  console.log('📝 Export du contenu vers contact-content.json...');
  await exportContactToJSON(ContactContent);
  
  // Exporter le contenu de la page Juridique
  console.log('📝 Export du contenu vers juridical-content.json...');
  await exportJuridicalToJSON(JuridicalContent);

  // Exporter les nouveaux contenus (pied de page, photos, vidéos, membres)
  console.log('📝 Export footer / photos / videos / membres...');
  await exportFooterToJSON(FooterContent);
  await exportPhotosToJSON(AlbumContent);
  await exportVideosToJSON(VideoContent);
  await exportMembersToJSON(ServiceMemberContent);
})
.catch((error) => {
  console.error('❌ Erreur de connexion à MongoDB:', error);
});

// Route pour la page de login (accessible sans authentification)
app.get('/admin/login', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'login.html'));
});

// Route pour la page admin (liens)
app.get('/admin', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'admin.html'));
});

// Route pour la page admin (contenu)
app.get('/admin/content', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'content-admin.html'));
});

// Route pour la page admin (Accueil : Mission/Vision & Actualités)
app.get('/admin/home-sections', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'home-sections-admin.html'));
});

// Route pour la page admin (à propos)
app.get('/admin/about', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'about-admin.html'));
});

// Route pour la page admin (histoire)
app.get('/admin/history', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'history-admin.html'));
});

// Route pour la page admin (équipe)
app.get('/admin/team', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'team-admin.html'));
});

// Route pour la page admin (contact)
app.get('/admin/contact', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'contact-admin.html'));
});

// Route pour la page admin (juridique)
app.get('/admin/juridical', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'juridical-admin.html'));
});

// Route pour la page admin (utilisateurs)
app.get('/admin/users', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'users-admin.html'));
});

// Route pour la page admin (pied de page)
app.get('/admin/footer', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'footer-admin.html'));
});

// Route pour la page admin (photos / albums)
app.get('/admin/photos', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'photos-admin.html'));
});

// Route pour la page admin (vidéos)
app.get('/admin/videos', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'videos-admin.html'));
});

// Route pour la page admin (membres)
app.get('/admin/members', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'members-admin.html'));
});

// Route de test
app.get('/', (req, res) => {
  res.json({ message: 'API TMK Header Manager - Utilisez /admin/login pour vous connecter' });
});

// Démarrage du serveur
app.listen(PORT, () => {
  console.log(`🚀 Serveur démarré sur le port ${PORT}`);
  console.log(`📱 Interface admin: http://localhost:${PORT}/admin/login`);
  console.log(`🔗 API: http://localhost:${PORT}/api`);
});
