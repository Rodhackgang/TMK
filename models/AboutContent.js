const mongoose = require('mongoose');

const aboutContentSchema = new mongoose.Schema({
  // Page Header
  pageTitle: { type: String, default: 'À Propos de Nous' },
  
  // Section Header
  sectionTitle: { type: String, default: 'Nos Domaines d\'Intervention' },
  sectionDescription: { type: String, default: 'The Miracle Kingdom Foundation s\'engage dans six domaines clés pour transformer les communautés et créer un impact durable.' },
  
  // Services/Domaines
  services: [{
    icon: { type: String, default: 'fa fa-heart' },
    iconClass: { type: String, default: 'humanitarian' },
    title: { type: String },
    description: { type: String },
    statNumber: { type: String },
    statLabel: { type: String }
  }],
  
  // Mission Section
  mission: {
    title: { type: String, default: 'Notre Mission' },
    description: { type: String, default: 'The Miracle Kingdom Foundation s\'engage à transformer les vies et les communautés à travers des interventions humanitaires, éducatives et de développement durable.' },
    values: [{
      icon: { type: String },
      label: { type: String }
    }],
    impactNumber: { type: String, default: '10,000+' },
    impactLabel: { type: String, default: 'Vies Transformées' }
  },
  
  updatedAt: { type: Date, default: Date.now }
});

aboutContentSchema.pre('save', function(next) {
  this.updatedAt = Date.now();
  next();
});

module.exports = mongoose.model('AboutContent', aboutContentSchema);
