const mongoose = require('mongoose');

const albumContentSchema = new mongoose.Schema({
  albums: [{
    title: { type: String, default: '' },
    description: { type: String, default: '' },
    mainImage: { type: String, default: '' },
    albumType: { type: String, default: '' },
    year: { type: String, default: '' },
    photosCount: { type: Number, default: 0 },
    link: { type: String, default: '#' }
  }],
  updatedAt: { type: Date, default: Date.now }
});

albumContentSchema.pre('save', function (next) { this.updatedAt = Date.now(); next(); });

module.exports = mongoose.model('AlbumContent', albumContentSchema);
