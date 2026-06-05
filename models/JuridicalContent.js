const mongoose = require('mongoose');

const JuridicalItemSchema = new mongoose.Schema({
  icon: {
    type: String,
    default: 'fa-file-text'
  },
  title: {
    type: String,
    required: true
  },
  description: {
    type: String,
    required: true
  },
  order: {
    type: Number,
    default: 0
  }
});

const JuridicalContentSchema = new mongoose.Schema({
  // En-tête de page
  pageTitle: {
    type: String,
    default: 'Statut Juridique'
  },
  
  // Titre principal
  mainTitle: {
    type: String,
    default: 'Le Statut Juridique de l\'Entreprise'
  },
  
  // Introduction
  introduction: {
    type: String,
    default: ''
  },
  
  // Sous-titre de la liste
  listTitle: {
    type: String,
    default: 'Points clés des documents :'
  },
  
  // Items juridiques
  items: [JuridicalItemSchema],
  
  // Résumé
  summary: {
    type: String,
    default: ''
  },
  
  updatedAt: {
    type: Date,
    default: Date.now
  }
});

// Mettre à jour la date de modification avant chaque sauvegarde
JuridicalContentSchema.pre('save', function(next) {
  this.updatedAt = Date.now();
  next();
});

module.exports = mongoose.model('JuridicalContent', JuridicalContentSchema);
