const express = require('express');
const router = express.Router();
const multer = require('multer');
const path = require('path');
const fs = require('fs');

// Configuration du stockage
const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    const uploadDir = path.join(__dirname, '..', 'uploads');
    if (!fs.existsSync(uploadDir)) {
      fs.mkdirSync(uploadDir, { recursive: true });
    }
    cb(null, uploadDir);
  },
  filename: (req, file, cb) => {
    // Générer un nom unique avec timestamp
    const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9);
    const ext = path.extname(file.originalname);
    cb(null, file.fieldname + '-' + uniqueSuffix + ext);
  }
});

// Filtrer les types de fichiers (images uniquement)
const fileFilter = (req, file, cb) => {
  const allowedImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
  
  if (allowedImageTypes.includes(file.mimetype)) {
    cb(null, true);
  } else {
    cb(new Error('Type de fichier non supporté. Utilisez JPG, PNG, GIF, WEBP pour les images.'), false);
  }
};

// Configuration de multer
const upload = multer({
  storage: storage,
  fileFilter: fileFilter,
  limits: {
    fileSize: 100 * 1024 * 1024 // 100MB max
  }
});

// Upload d'un seul fichier
router.post('/single', upload.single('file'), (req, res) => {
  try {
    if (!req.file) {
      return res.status(400).json({ error: 'Aucun fichier uploadé' });
    }
    
    // Retourner le chemin relatif pour le frontend PHP
    const relativePath = '/Backend/uploads/' + req.file.filename;
    
    res.json({
      success: true,
      filename: req.file.filename,
      originalname: req.file.originalname,
      path: relativePath,
      size: req.file.size,
      mimetype: req.file.mimetype
    });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Upload de plusieurs fichiers
router.post('/multiple', upload.array('files', 10), (req, res) => {
  try {
    if (!req.files || req.files.length === 0) {
      return res.status(400).json({ error: 'Aucun fichier uploadé' });
    }
    
    const files = req.files.map(file => ({
      filename: file.filename,
      originalname: file.originalname,
      path: '/Backend/uploads/' + file.filename,
      size: file.size,
      mimetype: file.mimetype
    }));
    
    res.json({
      success: true,
      files: files
    });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Lister les fichiers uploadés
router.get('/list', (req, res) => {
  try {
    const uploadDir = path.join(__dirname, '..', 'uploads');
    
    if (!fs.existsSync(uploadDir)) {
      return res.json({ files: [] });
    }
    
    const files = fs.readdirSync(uploadDir).map(filename => {
      const filePath = path.join(uploadDir, filename);
      const stats = fs.statSync(filePath);
      const ext = path.extname(filename).toLowerCase();
      const isVideo = ['.mp4', '.webm', '.ogg', '.mov'].includes(ext);
      
      return {
        filename: filename,
        path: '/Backend/uploads/' + filename,
        size: stats.size,
        isVideo: isVideo,
        createdAt: stats.birthtime
      };
    });
    
    // Trier par date de création (plus récent en premier)
    files.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
    
    res.json({ files });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Supprimer un fichier
router.delete('/:filename', (req, res) => {
  try {
    const filePath = path.join(__dirname, '..', 'uploads', req.params.filename);
    
    if (fs.existsSync(filePath)) {
      fs.unlinkSync(filePath);
      res.json({ success: true, message: 'Fichier supprimé' });
    } else {
      res.status(404).json({ error: 'Fichier non trouvé' });
    }
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Gestion des erreurs multer
router.use((error, req, res, next) => {
  if (error instanceof multer.MulterError) {
    if (error.code === 'LIMIT_FILE_SIZE') {
      return res.status(400).json({ error: 'Fichier trop volumineux. Maximum 100MB.' });
    }
    return res.status(400).json({ error: error.message });
  }
  next(error);
});

module.exports = router;
