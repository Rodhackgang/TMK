const mongoose = require('mongoose');

const socialLinkSchema = new mongoose.Schema({
  platform: { type: String, required: true },
  icon: { type: String, required: true },
  url: { type: String, default: '#' }
});

const contactContentSchema = new mongoose.Schema({
  // Page Header
  pageTitle: { type: String, default: 'Contactez-nous' },
  
  // Section Title
  sectionTitle: { type: String, default: 'Contactez TMK' },
  
  // Contact Info
  contactInfo: {
    title: { type: String, default: 'Informations de Contact' },
    phone: {
      label: { type: String, default: 'Téléphone' },
      number: { type: String, default: '+243 900 000 000' }
    },
    email: {
      label: { type: String, default: 'Email' },
      address: { type: String, default: 'contact@tmkfoundation.org' }
    },
    address: {
      label: { type: String, default: 'Adresse' },
      line1: { type: String, default: 'A108 Rue Adam' },
      line2: { type: String, default: 'Kinshasa, RDC' }
    }
  },
  
  // Social Links
  socialTitle: { type: String, default: 'Suivez-nous' },
  socialLinks: [socialLinkSchema],
  
  // Form Section
  formSection: {
    title: { type: String, default: 'Envoyez-nous un Message' },
    description: { type: String, default: 'Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais.' },
    submitButtonText: { type: String, default: 'Envoyer le Message' }
  },
  
  updatedAt: { type: Date, default: Date.now }
});

contactContentSchema.pre('save', function(next) {
  this.updatedAt = Date.now();
  next();
});

module.exports = mongoose.model('ContactContent', contactContentSchema);
