const express = require('express');
const router = express.Router();
const NavLink = require('../models/NavLink');
const { exportLinksToJSON, JSON_FILE_PATH } = require('../utils/exportLinks');

// Wrapper pour appeler exportLinksToJSON avec le modèle
async function exportLinks() {
  return await exportLinksToJSON(NavLink);
}

// Récupérer tous les liens
router.get('/links', async (req, res) => {
  try {
    const links = await NavLink.find({ isActive: true })
      .sort({ order: 1 })
      .lean();
    res.json(links);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Récupérer tous les liens (admin - inclut les inactifs)
router.get('/admin/links', async (req, res) => {
  try {
    const links = await NavLink.find()
      .sort({ order: 1 })
      .lean();
    res.json(links);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Récupérer un lien par ID
router.get('/admin/links/:id', async (req, res) => {
  try {
    const link = await NavLink.findById(req.params.id);
    if (!link) {
      return res.status(404).json({ error: 'Lien non trouvé' });
    }
    res.json(link);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Créer un nouveau lien
router.post('/admin/links', async (req, res) => {
  try {
    const link = new NavLink(req.body);
    await link.save();
    
    // Exporter vers JSON après création
    await exportLinks();
    
    res.status(201).json(link);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Mettre à jour un lien
router.put('/admin/links/:id', async (req, res) => {
  try {
    const link = await NavLink.findByIdAndUpdate(
      req.params.id,
      req.body,
      { new: true, runValidators: true }
    );
    if (!link) {
      return res.status(404).json({ error: 'Lien non trouvé' });
    }
    
    // Exporter vers JSON après modification
    await exportLinks();
    
    res.json(link);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Supprimer un lien
router.delete('/admin/links/:id', async (req, res) => {
  try {
    const link = await NavLink.findByIdAndDelete(req.params.id);
    if (!link) {
      return res.status(404).json({ error: 'Lien non trouvé' });
    }
    
    // Exporter vers JSON après suppression
    await exportLinks();
    
    res.json({ message: 'Lien supprimé avec succès' });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Route pour forcer l'export JSON
router.post('/admin/export', async (req, res) => {
  try {
    const success = await exportLinks();
    if (success) {
      res.json({ message: 'Export réussi', path: JSON_FILE_PATH });
    } else {
      res.status(500).json({ error: 'Erreur lors de l\'export' });
    }
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

module.exports = router;
