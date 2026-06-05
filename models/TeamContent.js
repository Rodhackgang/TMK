const mongoose = require('mongoose');

const memberSchema = new mongoose.Schema({
  name: { type: String, required: true },
  photo: { type: String, required: true },
  role: { type: String, default: '' },
  order: { type: Number, default: 0 }
});

const teamContentSchema = new mongoose.Schema({
  // Titre de la section
  sectionTitle: { type: String, default: 'Notre Communauté' },
  
  // Liste des membres
  members: [memberSchema],
  
  updatedAt: { type: Date, default: Date.now }
});

teamContentSchema.pre('save', function(next) {
  this.updatedAt = Date.now();
  next();
});

module.exports = mongoose.model('TeamContent', teamContentSchema);
