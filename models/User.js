const mongoose = require('mongoose');
const bcrypt = require('bcryptjs');

const UserSchema = new mongoose.Schema({
  email: {
    type: String,
    required: true,
    unique: true,
    lowercase: true,
    trim: true
  },
  password: {
    type: String,
    required: true
  },
  name: {
    type: String,
    required: true
  },
  role: {
    type: String,
    enum: ['admin', 'gestionnaire'],
    default: 'gestionnaire'
  },
  // Permissions détaillées pour les gestionnaires
  permissions: {
    // Navigation
    canManageNavigation: { type: Boolean, default: false },
    
    // Pages de contenu
    canManageHomePage: { type: Boolean, default: false },
    canManageAboutPage: { type: Boolean, default: false },
    canManageHistoryPage: { type: Boolean, default: false },
    canManageTeamPage: { type: Boolean, default: false },
    canManageContactPage: { type: Boolean, default: false },
    canManageJuridicalPage: { type: Boolean, default: false },
    
    // Gestion des utilisateurs (réservé aux admins)
    canManageUsers: { type: Boolean, default: false }
  },
  isActive: {
    type: Boolean,
    default: true
  },
  createdBy: {
    type: mongoose.Schema.Types.ObjectId,
    ref: 'User'
  },
  createdAt: {
    type: Date,
    default: Date.now
  },
  lastLogin: {
    type: Date
  }
});

// Hash du mot de passe avant sauvegarde
UserSchema.pre('save', async function(next) {
  if (!this.isModified('password')) return next();
  
  try {
    const salt = await bcrypt.genSalt(10);
    this.password = await bcrypt.hash(this.password, salt);
    next();
  } catch (error) {
    next(error);
  }
});

// Méthode pour vérifier le mot de passe
UserSchema.methods.comparePassword = async function(candidatePassword) {
  return bcrypt.compare(candidatePassword, this.password);
};

// Méthode pour vérifier si l'utilisateur a une permission
UserSchema.methods.hasPermission = function(permission) {
  // Les admins ont toutes les permissions
  if (this.role === 'admin') return true;
  
  // Vérifier la permission spécifique pour les gestionnaires
  return this.permissions[permission] === true;
};

// Méthode pour obtenir toutes les permissions
UserSchema.methods.getAllPermissions = function() {
  if (this.role === 'admin') {
    return {
      canManageNavigation: true,
      canManageHomePage: true,
      canManageAboutPage: true,
      canManageHistoryPage: true,
      canManageTeamPage: true,
      canManageContactPage: true,
      canManageJuridicalPage: true,
      canManageUsers: true
    };
  }
  return this.permissions;
};

module.exports = mongoose.model('User', UserSchema);
