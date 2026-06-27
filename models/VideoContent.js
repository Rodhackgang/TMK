const mongoose = require('mongoose');

const videoContentSchema = new mongoose.Schema({
  videos: [{
    title: { type: String, default: '' },
    description: { type: String, default: '' },
    videoPath: { type: String, default: '' },
    youtubeUrl: { type: String, default: '' },
    previewImage: { type: String, default: '' },
    category: { type: String, default: 'Vidéo' }
  }],
  updatedAt: { type: Date, default: Date.now }
});

videoContentSchema.pre('save', function (next) { this.updatedAt = Date.now(); next(); });

module.exports = mongoose.model('VideoContent', videoContentSchema);
