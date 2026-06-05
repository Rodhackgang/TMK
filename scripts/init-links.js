const mongoose = require('mongoose');
const NavLink = require('../models/NavLink');
const config = require('../config.js');

// Connexion à MongoDB
mongoose.connect(config.MONGODB_URI, {
  useNewUrlParser: true,
  useUnifiedTopology: true
})
.then(async () => {
  console.log('✅ Connecté à MongoDB');
  
  // Vérifier si des liens existent déjà
  const existingLinks = await NavLink.countDocuments();
  
  if (existingLinks > 0) {
    console.log(`⚠️  ${existingLinks} lien(s) existent déjà. Voulez-vous les remplacer ?`);
    console.log('Pour réinitialiser, supprimez d\'abord les liens existants via l\'interface admin.');
    process.exit(0);
  }
  
  // Liens par défaut
  const defaultLinks = [
    {
      type: 'simple',
      label: 'Accueil',
      href: 'index.php',
      order: 0,
      isActive: true,
      activePages: ['index']
    },
    {
      type: 'simple',
      label: 'À propos',
      href: 'about.php',
      order: 1,
      isActive: true,
      activePages: ['about']
    },
    {
      type: 'simple',
      label: 'Histoire',
      href: 'histoire.php',
      order: 2,
      isActive: true,
      activePages: ['histoire']
    },
    {
      type: 'simple',
      label: 'Communauté',
      href: 'equipe.php',
      order: 3,
      isActive: true,
      activePages: ['equipe']
    },
    {
      type: 'dropdown',
      label: 'Nos réalisations',
      href: '#',
      order: 4,
      isActive: true,
      activePages: ['realisationsphoto', 'realisationsvideo'],
      dropdownItems: [
        {
          label: 'Nos photos',
          href: 'realisationsphoto.php',
          order: 0,
          isActive: true
        },
        {
          label: 'Nos vidéos',
          href: 'realisationsvideo.php',
          order: 1,
          isActive: true
        },
        {
          label: 'Vidéo TMK',
          href: 'video.php?video=videos/video.mp4',
          order: 2,
          isActive: true
        }
      ]
    },
    {
      type: 'dropdown',
      label: 'Membres Services',
      href: '#',
      order: 5,
      isActive: true,
      dropdownItems: [
        {
          label: 'Comité Administratif',
          href: 'membreservice.php#comite',
          order: 0,
          isActive: true
        },
        {
          label: 'Service des Ressources Humaines',
          href: 'membreservice.php#rh',
          order: 1,
          isActive: true
        },
        {
          label: 'Service Promotion et Planification',
          href: 'membreservice.php#promotion',
          order: 2,
          isActive: true
        },
        {
          label: 'Service Financière & Administrative',
          href: 'membreservice.php#financiere',
          order: 3,
          isActive: true
        },
        {
          label: 'Service de Logistique',
          href: 'membreservice.php#logistique',
          order: 4,
          isActive: true
        },
        {
          label: 'Service Relations Internationales',
          href: 'membreservice.php#international',
          order: 5,
          isActive: true
        },
        {
          label: 'Service Communication Digitale',
          href: 'membreservice.php#communication',
          order: 6,
          isActive: true
        },
        {
          label: 'Service Juridique',
          href: 'membreservice.php#juridique',
          order: 7,
          isActive: true
        }
      ]
    },
    {
      type: 'simple',
      label: 'Contact',
      href: 'contact.php',
      order: 6,
      isActive: true,
      activePages: ['contact']
    },
    {
      type: 'simple',
      label: 'Status Juridique',
      href: 'juridique.php',
      order: 7,
      isActive: true,
      activePages: ['juridique']
    }
  ];
  
  // Insérer les liens
  try {
    await NavLink.insertMany(defaultLinks);
    console.log(`✅ ${defaultLinks.length} liens par défaut créés avec succès !`);
    process.exit(0);
  } catch (error) {
    console.error('❌ Erreur lors de la création des liens:', error);
    process.exit(1);
  }
})
.catch((error) => {
  console.error('❌ Erreur de connexion à MongoDB:', error);
  process.exit(1);
});
