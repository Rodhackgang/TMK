const express = require('express');
const router = express.Router();
const User = require('../models/User');
const { authenticateToken, requireAdmin, generateToken } = require('../middleware/auth');

// Email de l'admin par défaut
const DEFAULT_ADMIN_EMAIL = 'samarodrigue690@gmail.com';

// Initialiser l'admin par défaut au démarrage
async function initializeDefaultAdmin() {
  try {
    const adminExists = await User.findOne({ email: DEFAULT_ADMIN_EMAIL.toLowerCase() });
    
    if (!adminExists) {
      const admin = new User({
        email: DEFAULT_ADMIN_EMAIL.toLowerCase(),
        password: 'Admin@TMK2024', // Mot de passe par défaut à changer
        name: 'Super Admin',
        role: 'admin',
        permissions: {
          canManageNavigation: true,
          canManageHomePage: true,
          canManageAboutPage: true,
          canManageHistoryPage: true,
          canManageTeamPage: true,
          canManageContactPage: true,
          canManageJuridicalPage: true,
          canManageUsers: true
        }
      });
      
      await admin.save();
      console.log('✅ Admin par défaut créé:', DEFAULT_ADMIN_EMAIL);
      console.log('🔑 Mot de passe par défaut: Admin@TMK2024');
    }
  } catch (error) {
    console.error('❌ Erreur lors de la création de l\'admin par défaut:', error);
  }
}

// Route de connexion
router.post('/login', async (req, res) => {
  try {
    const { email, password } = req.body;

    if (!email || !password) {
      return res.status(400).json({ error: 'Email et mot de passe requis' });
    }

    // Trouver l'utilisateur
    const user = await User.findOne({ email: email.toLowerCase() });
    
    if (!user) {
      return res.status(401).json({ error: 'Email ou mot de passe incorrect' });
    }

    // Vérifier si l'utilisateur est actif
    if (!user.isActive) {
      return res.status(401).json({ error: 'Compte désactivé. Contactez un administrateur.' });
    }

    // Vérifier le mot de passe
    const isMatch = await user.comparePassword(password);
    
    if (!isMatch) {
      return res.status(401).json({ error: 'Email ou mot de passe incorrect' });
    }

    // Mettre à jour la dernière connexion
    user.lastLogin = new Date();
    await user.save();

    // Générer le token
    const token = generateToken(user._id);

    // Envoyer le token en cookie et en réponse
    res.cookie('authToken', token, {
      httpOnly: true,
      secure: process.env.NODE_ENV === 'production',
      maxAge: 7 * 24 * 60 * 60 * 1000 // 7 jours
    });

    res.json({
      message: 'Connexion réussie',
      token,
      user: {
        id: user._id,
        email: user.email,
        name: user.name,
        role: user.role,
        permissions: user.getAllPermissions()
      }
    });
  } catch (error) {
    console.error('Erreur de connexion:', error);
    res.status(500).json({ error: 'Erreur serveur' });
  }
});

// Route de déconnexion
router.post('/logout', (req, res) => {
  res.clearCookie('authToken');
  res.json({ message: 'Déconnexion réussie' });
});

// Obtenir l'utilisateur actuel
router.get('/me', authenticateToken, async (req, res) => {
  res.json({
    user: {
      id: req.user._id,
      email: req.user.email,
      name: req.user.name,
      role: req.user.role,
      permissions: req.user.getAllPermissions()
    }
  });
});

// Changer son mot de passe
router.put('/change-password', authenticateToken, async (req, res) => {
  try {
    const { currentPassword, newPassword } = req.body;

    if (!currentPassword || !newPassword) {
      return res.status(400).json({ error: 'Les deux mots de passe sont requis' });
    }

    if (newPassword.length < 6) {
      return res.status(400).json({ error: 'Le nouveau mot de passe doit contenir au moins 6 caractères' });
    }

    // Vérifier le mot de passe actuel
    const isMatch = await req.user.comparePassword(currentPassword);
    
    if (!isMatch) {
      return res.status(401).json({ error: 'Mot de passe actuel incorrect' });
    }

    // Mettre à jour le mot de passe
    req.user.password = newPassword;
    await req.user.save();

    res.json({ message: 'Mot de passe modifié avec succès' });
  } catch (error) {
    console.error('Erreur changement mot de passe:', error);
    res.status(500).json({ error: 'Erreur serveur' });
  }
});

// ============================================
// ROUTES DE GESTION DES UTILISATEURS (Admin uniquement)
// ============================================

// Obtenir tous les utilisateurs
router.get('/users', authenticateToken, requireAdmin, async (req, res) => {
  try {
    const users = await User.find()
      .select('-password')
      .populate('createdBy', 'name email')
      .sort({ createdAt: -1 });
    
    res.json(users);
  } catch (error) {
    console.error('Erreur récupération utilisateurs:', error);
    res.status(500).json({ error: 'Erreur serveur' });
  }
});

// Créer un nouvel utilisateur (gestionnaire)
router.post('/users', authenticateToken, requireAdmin, async (req, res) => {
  try {
    const { email, password, name, role, permissions } = req.body;

    if (!email || !password || !name) {
      return res.status(400).json({ error: 'Email, mot de passe et nom requis' });
    }

    if (password.length < 6) {
      return res.status(400).json({ error: 'Le mot de passe doit contenir au moins 6 caractères' });
    }

    // Vérifier si l'email existe déjà
    const existingUser = await User.findOne({ email: email.toLowerCase() });
    if (existingUser) {
      return res.status(400).json({ error: 'Cet email est déjà utilisé' });
    }

    // Créer l'utilisateur
    const newUser = new User({
      email: email.toLowerCase(),
      password,
      name,
      role: role || 'gestionnaire',
      permissions: permissions || {},
      createdBy: req.user._id
    });

    await newUser.save();

    res.status(201).json({
      message: 'Utilisateur créé avec succès',
      user: {
        id: newUser._id,
        email: newUser.email,
        name: newUser.name,
        role: newUser.role,
        permissions: newUser.permissions
      }
    });
  } catch (error) {
    console.error('Erreur création utilisateur:', error);
    res.status(500).json({ error: 'Erreur serveur' });
  }
});

// Modifier un utilisateur
router.put('/users/:id', authenticateToken, requireAdmin, async (req, res) => {
  try {
    const { name, role, permissions, isActive } = req.body;
    const userId = req.params.id;

    const user = await User.findById(userId);
    
    if (!user) {
      return res.status(404).json({ error: 'Utilisateur non trouvé' });
    }

    // Empêcher la modification de l'admin par défaut (sauf lui-même)
    if (user.email === DEFAULT_ADMIN_EMAIL.toLowerCase() && req.user.email !== DEFAULT_ADMIN_EMAIL.toLowerCase()) {
      return res.status(403).json({ error: 'Impossible de modifier le super administrateur' });
    }

    // Mettre à jour les champs
    if (name) user.name = name;
    if (role && req.user.email === DEFAULT_ADMIN_EMAIL.toLowerCase()) {
      user.role = role; // Seul le super admin peut changer les rôles
    }
    if (permissions) user.permissions = permissions;
    if (typeof isActive === 'boolean') {
      // Empêcher la désactivation de son propre compte
      if (userId === req.user._id.toString()) {
        return res.status(400).json({ error: 'Vous ne pouvez pas désactiver votre propre compte' });
      }
      user.isActive = isActive;
    }

    await user.save();

    res.json({
      message: 'Utilisateur modifié avec succès',
      user: {
        id: user._id,
        email: user.email,
        name: user.name,
        role: user.role,
        permissions: user.permissions,
        isActive: user.isActive
      }
    });
  } catch (error) {
    console.error('Erreur modification utilisateur:', error);
    res.status(500).json({ error: 'Erreur serveur' });
  }
});

// Réinitialiser le mot de passe d'un utilisateur
router.put('/users/:id/reset-password', authenticateToken, requireAdmin, async (req, res) => {
  try {
    const { newPassword } = req.body;
    const userId = req.params.id;

    if (!newPassword || newPassword.length < 6) {
      return res.status(400).json({ error: 'Le nouveau mot de passe doit contenir au moins 6 caractères' });
    }

    const user = await User.findById(userId);
    
    if (!user) {
      return res.status(404).json({ error: 'Utilisateur non trouvé' });
    }

    user.password = newPassword;
    await user.save();

    res.json({ message: 'Mot de passe réinitialisé avec succès' });
  } catch (error) {
    console.error('Erreur réinitialisation mot de passe:', error);
    res.status(500).json({ error: 'Erreur serveur' });
  }
});

// Supprimer un utilisateur
router.delete('/users/:id', authenticateToken, requireAdmin, async (req, res) => {
  try {
    const userId = req.params.id;
    const user = await User.findById(userId);
    
    if (!user) {
      return res.status(404).json({ error: 'Utilisateur non trouvé' });
    }

    // Empêcher la suppression de l'admin par défaut
    if (user.email === DEFAULT_ADMIN_EMAIL.toLowerCase()) {
      return res.status(403).json({ error: 'Impossible de supprimer le super administrateur' });
    }

    // Empêcher la suppression de son propre compte
    if (userId === req.user._id.toString()) {
      return res.status(400).json({ error: 'Vous ne pouvez pas supprimer votre propre compte' });
    }

    await User.findByIdAndDelete(userId);

    res.json({ message: 'Utilisateur supprimé avec succès' });
  } catch (error) {
    console.error('Erreur suppression utilisateur:', error);
    res.status(500).json({ error: 'Erreur serveur' });
  }
});

module.exports = { router, initializeDefaultAdmin };
