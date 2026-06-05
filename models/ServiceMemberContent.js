const mongoose = require('mongoose');

const serviceMemberContentSchema = new mongoose.Schema({
  sectionTitle: { type: String, default: 'Nos Membres' },
  members: [{
    name: { type: String, default: '' },
    poste: { type: String, default: '' },
    photo: { type: String, default: '' }
  }],
  updatedAt: { type: Date, default: Date.now }
});

serviceMemberContentSchema.pre('save', function (next) { this.updatedAt = Date.now(); next(); });

module.exports = mongoose.model('ServiceMemberContent', serviceMemberContentSchema);
