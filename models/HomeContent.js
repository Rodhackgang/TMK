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
