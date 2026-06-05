const mongoose = require('mongoose');

const navLinkSchema = new mongoose.Schema({
  type: {
    type: String,
    required: true,
    enum: ['simple', 'dropdown']
  },
  label: {
    type: String,
    required: true
  },
  href: {
    type: String,
    default: '#'
  },
  order: {
    type: Number,
    default: 0
  },
  isActive: {
    type: Boolean,
    default: true
  },
  // Pour les liens dropdown
  dropdownItems: [{
    label: String,
    href: String,
    isActive: {
      type: Boolean,
      default: true
    },
    order: {
      type: Number,
      default: 0
    }
  }],
  // Pour identifier la page active
  activePages: [String],
  createdAt: {
    type: Date,
    default: Date.now
  },
  updatedAt: {
    type: Date,
    default: Date.now
  }
});

// Middleware pour mettre à jour updatedAt
navLinkSchema.pre('save', function(next) {
  this.updatedAt = Date.now();
  next();
});

module.exports = mongoose.model('NavLink', navLinkSchema);
