const jwt = require('jsonwebtoken');
const User = require('../models/User');

// Clé secrète pour JWT (en production, utiliser une variable d'environnement)
const JWT_SECRET = process.env.JWT_SECRET || 'tmk-foundation-secret-key-2024';
const JWT_EXPIRES_IN = '7d';

// Middleware pour vérifier l'authentification
const authenticateToken = async (req, res, next) => {
  try {
    // Récupérer le token depuis le cookie ou l'en-tête Authorization
    let token = req.cookies?.authToken;
    
    if (!token && req.headers.authorization) {
      const authHeader = req.headers.authorization;
      if (authHeader.startsWith('Bearer ')) {
        token = authHeader.substring(7);
      }
    }

    if (!token) {
      // Pour les requêtes API, renvoyer une erreur JSON
      if (req.xhr || req.headers.accept?.includes('application/json')) {
        return res.status(401).json({ error: 'Non authentifié' });
      }
      // Pour les pages web, rediriger vers la page de login
      return res.status(401).json({ error: 'Non authentifié' });
    }

    // Vérifier le token
    const decoded = jwt.verify(token, JWT_SECRET);
    
    // Récupérer l'utilisateur
    const user = await User.findById(decoded.userId);
    
    if (!user || !user.isActive) {
      if (req.xhr || req.headers.accept?.includes('application/json')) {
        return res.status(401).json({ error: 'Utilisateur non trouvé ou désactivé' });
      }
      return res.status(401).json({ error: 'Non authentifié' });
    }

    // Attacher l'utilisateur à la requête
    req.user = user;
    next();
  } catch (error) {
    console.error('Erreur d\'authentification:', error);
    if (req.xhr || req.headers.accept?.includes('application/json')) {
      return res.status(401).json({ error: 'Token invalide' });
    }
    return res.redirect('/admin/login');
  }
};

// Middleware pour vérifier une permission spécifique
const requirePermission = (permission) => {
  return (req, res, next) => {
    if (!req.user) {
      return res.status(401).json({ error: 'Non authentifié' });
    }

    if (!req.user.hasPermission(permission)) {
      return res.status(403).json({ 
        error: 'Accès refusé', 
        message: 'Vous n\'avez pas la permission d\'effectuer cette action' 
      });
    }

    next();
  };
};

// Middleware pour vérifier si l'utilisateur est admin
const requireAdmin = (req, res, next) => {
  if (!req.user) {
    return res.status(401).json({ error: 'Non authentifié' });
  }

  if (req.user.role !== 'admin') {
    return res.status(403).json({ 
      error: 'Accès refusé', 
      message: 'Cette action est réservée aux administrateurs' 
    });
  }

  next();
};

// Générer un token JWT
const generateToken = (userId) => {
  return jwt.sign({ userId }, JWT_SECRET, { expiresIn: JWT_EXPIRES_IN });
};

module.exports = {
  authenticateToken,
  requirePermission,
  requireAdmin,
  generateToken,
  JWT_SECRET
};
