const mongoose = require('mongoose');

const footerContentSchema = new mongoose.Schema({
  brandName: { type: String, default: 'TMK Foundation' },
  brandTagline: { type: String, default: 'The Miracle Kingdom' },
  about1: { type: String, default: "TMK Foundation est une organisation à but non lucratif engagée à transformer durablement des vies par l’éducation, la solidarité sociale et le développement communautaire." },
  about2: { type: String, default: "Nous œuvrons chaque jour pour bâtir des communautés plus justes, inclusives et résilientes." },
  social: {
    facebook: { type: String, default: 'https://www.facebook.com/tmkfoundation' },
    twitter: { type: String, default: 'https://twitter.com/tmkfoundation' },
    linkedin: { type: String, default: 'https://www.linkedin.com/company/tmkfoundation' },
    instagram: { type: String, default: 'https://www.instagram.com/tmkfoundation' },
    whatsapp: { type: String, default: 'https://wa.me/+243978219845' },
    youtube: { type: String, default: 'https://www.youtube.com/@tmkfoundation' }
  },
  contact: {
    orgName: { type: String, default: 'TMK Foundation' },
    address: { type: String, default: 'Kinshasa, République Démocratique du Congo' },
    phone1: { type: String, default: '+243 978 219 845' },
    phone2: { type: String, default: '+243 974 555 964' },
    email: { type: String, default: 'contact@tmkfoundation.org' },
    hours1: { type: String, default: 'Lundi - Vendredi : 8h00 - 17h00' },
    hours2: { type: String, default: 'Samedi : 9h00 - 13h00' },
    mapsUrl: { type: String, default: 'https://www.google.com/maps/search/?api=1&query=Kinshasa+RDC' }
  },
  newsletterTitle: { type: String, default: 'Restez connectés' },
  newsletterText: { type: String, default: "Recevez les dernières nouvelles sur nos projets, nos événements et l’impact de vos dons." },
  copyright: { type: String, default: '© 2025 TMK Foundation. Tous droits réservés.' },
  updatedAt: { type: Date, default: Date.now }
});

footerContentSchema.pre('save', function (next) { this.updatedAt = Date.now(); next(); });

module.exports = mongoose.model('FooterContent', footerContentSchema);
