const mongoose = require('mongoose');

const sectionSchema = new mongoose.Schema({
  type: { type: String, enum: ['heading', 'paragraph', 'list', 'image', 'images'], required: true },
  level: { type: Number, default: 2 }, // Pour les headings: 2, 3, 4, 5
  content: { type: String }, // Pour texte ou URL d'image
  items: [{ type: String }], // Pour les listes
  images: [{ type: String }], // Pour multiple images
  centered: { type: Boolean, default: false }
});

const historyContentSchema = new mongoose.Schema({
  // Titre principal
  pageTitle: { type: String, default: 'Histoire de TMK Foundation' },
  logoUrl: { type: String, default: '../images/logo.png' },
  
  // Titre de la section principale
  mainTitle: { type: String, default: 'The Miracle Kingdom' },
  
  // Sections du contenu
  sections: [sectionSchema],
  
  updatedAt: { type: Date, default: Date.now }
});

historyContentSchema.pre('save', function(next) {
  this.updatedAt = Date.now();
  next();
});

module.exports = mongoose.model('HistoryContent', historyContentSchema);
