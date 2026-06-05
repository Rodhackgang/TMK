const mongoose = require('mongoose');

const homeContentSchema = new mongoose.Schema({
  // Section Hero
  hero: {
    videoUrl: { type: String, default: 'images/1.mp4' },
    title: { type: String, default: 'Un avenir meilleur pour tous' },
    subtitle: { type: String, default: 'Agissons ensemble pour un changement durable' },
    donateButtonText: { type: String, default: 'Faire un don' },
    videoButtonText: { type: String, default: 'Voir notre vidéo' },
    uiuxText: { type: String, default: 'Vous souhaitez créer un site web professionnel ? Contactez-nous pour donner vie à vos projets numériques avec une approche UI/UX moderne et efficace.' },
    uiuxButtonText: { type: String, default: 'Créer votre site web' },
    uiuxWhatsappLink: { type: String, default: 'https://wa.me/243974555964' }
  },
  
  // Section Vidéos
  videoSection: {
    title: { type: String, default: 'Notre Mission en Action' },
    subtitle: { type: String, default: 'Découvrez comment votre soutien transforme des vies dans les domaines de l\'éducation, de la santé et de l\'aide humanitaire.' },
    videos: [{ type: String }],
    youtubeUrl: { type: String, default: 'https://www.youtube.com/embed/IUnlo_BRRBA' }
  },
  
  // Modal Don
  donationModal: {
    title: { type: String, default: 'Merci de votre générosité' },
    subtitle: { type: String, default: 'Votre don fait la différence !' },
    note: { type: String, default: 'Après votre don, envoyez un SMS avec votre nom au même numéro pour confirmation.' }
  },
  
  // Section Don
  donationSection: {
    title: { type: String, default: 'Soutenez Notre Cause' },
    description: { type: String, default: 'Votre générosité peut changer des vies. Faites un don maintenant et aidez-nous à créer un impact durable.' }
  },
  
  // Numéros de téléphone pour les dons
  phoneNumbers: [{
    icon: { type: String, default: 'fab fa-whatsapp' },
    number: { type: String },
    operator: { type: String }
  }],
  
  // Section Contact/Service
  contactSection: {
    title: { type: String, default: 'Besoin d\'un site similaire ?' },
    description: { type: String, default: 'Contactez-nous pour la conception de votre site web professionnel' },
    buttonText: { type: String, default: 'Nous contacter' },
    whatsappLink: { type: String, default: 'https://wa.me/+243974555964?text=Bonjour,%20je%20suis%20intéressé%20par%20la%20conception%20d\'un%20site%20internet.' }
  },

  // Section Mission & Vision (page d'accueil)
  missionVision: {
    sectionTitle: { type: String, default: 'Notre mission & notre vision' },
    missionTitle: { type: String, default: 'Notre mission' },
    missionText: { type: String, default: "La mission de la fondation THE MIRACLE KINGDOM est de mettre en œuvre des actions d’intérêt général visant à soutenir les personnes démunies et vulnérables, et à aider les populations à devenir actrices de leur propre développement, grâce à des interventions adaptées, structurées et à fort impact social." },
    visionTitle: { type: String, default: 'Notre vision' },
    visionText: { type: String, default: "Par sa vision, The Miracle Kingdom œuvre à la construction de sociétés plus justes, solidaires et résilientes, où chacun, en particulier les plus défavorisés, peut accéder à des conditions de vie dignes et à de réelles opportunités d’avenir." }
  },

  // Section Actualités (page d'accueil)
  news: {
    sectionTitle: { type: String, default: 'Actualités' },
    subtitle: { type: String, default: "Découvrez les dernières actions et événements de la fondation THE MIRACLE KINGDOM sur le terrain." },
    items: [{
      meta: { type: String, default: '' },
      title: { type: String, default: '' },
      text: { type: String, default: '' },
      linkText: { type: String, default: 'En savoir plus' },
      link: { type: String, default: '#' }
    }]
  },

  updatedAt: {
    type: Date,
    default: Date.now
  }
});

// Middleware pour mettre à jour updatedAt
homeContentSchema.pre('save', function(next) {
  this.updatedAt = Date.now();
  next();
});

module.exports = mongoose.model('HomeContent', homeContentSchema);
