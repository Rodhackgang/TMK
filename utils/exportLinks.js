const fs = require('fs');
const path = require('path');

// Chemins des fichiers JSON pour le PHP
const JSON_FILE_PATH = path.join(__dirname, '..', 'nav-links.json');
const CONTENT_FILE_PATH = path.join(__dirname, '..', 'home-content.json');
const ABOUT_FILE_PATH = path.join(__dirname, '..', 'about-content.json');
const HISTORY_FILE_PATH = path.join(__dirname, '..', 'history-content.json');
const TEAM_FILE_PATH = path.join(__dirname, '..', 'team-content.json');
const CONTACT_FILE_PATH = path.join(__dirname, '..', 'contact-content.json');
const JURIDICAL_FILE_PATH = path.join(__dirname, '..', 'juridical-content.json');
const FOOTER_FILE_PATH = path.join(__dirname, '..', 'footer-content.json');
const PHOTOS_FILE_PATH = path.join(__dirname, '..', 'photos-content.json');
const VIDEOS_FILE_PATH = path.join(__dirname, '..', 'videos-content.json');
const MEMBERS_FILE_PATH = path.join(__dirname, '..', 'members-content.json');

// Fonction pour exporter les liens vers un fichier JSON
async function exportLinksToJSON(NavLink) {
  try {
    const links = await NavLink.find({ isActive: true })
      .sort({ order: 1 })
      .lean();
    
    fs.writeFileSync(JSON_FILE_PATH, JSON.stringify(links, null, 2), 'utf8');
    console.log('✅ Fichier nav-links.json mis à jour');
    return true;
  } catch (error) {
    console.error('❌ Erreur lors de l\'export JSON:', error);
    return false;
  }
}

// Fonction pour exporter le contenu de la page d'accueil vers un fichier JSON
async function exportContentToJSON(HomeContent) {
  try {
    const content = await HomeContent.findOne().lean();
    
    if (content) {
      fs.writeFileSync(CONTENT_FILE_PATH, JSON.stringify(content, null, 2), 'utf8');
      console.log('✅ Fichier home-content.json mis à jour');
    }
    return true;
  } catch (error) {
    console.error('❌ Erreur lors de l\'export du contenu:', error);
    return false;
  }
}

// Fonction pour exporter le contenu de la page About vers un fichier JSON
async function exportAboutToJSON(AboutContent) {
  try {
    const content = await AboutContent.findOne().lean();
    
    if (content) {
      fs.writeFileSync(ABOUT_FILE_PATH, JSON.stringify(content, null, 2), 'utf8');
      console.log('✅ Fichier about-content.json mis à jour');
    }
    return true;
  } catch (error) {
    console.error('❌ Erreur lors de l\'export About:', error);
    return false;
  }
}

// Fonction pour exporter le contenu de la page Histoire vers un fichier JSON
async function exportHistoryToJSON(HistoryContent) {
  try {
    const content = await HistoryContent.findOne().lean();
    
    if (content) {
      fs.writeFileSync(HISTORY_FILE_PATH, JSON.stringify(content, null, 2), 'utf8');
      console.log('✅ Fichier history-content.json mis à jour');
    }
    return true;
  } catch (error) {
    console.error('❌ Erreur lors de l\'export History:', error);
    return false;
  }
}

// Fonction pour exporter le contenu de la page Équipe vers un fichier JSON
async function exportTeamToJSON(TeamContent) {
  try {
    const content = await TeamContent.findOne().lean();
    
    if (content) {
      fs.writeFileSync(TEAM_FILE_PATH, JSON.stringify(content, null, 2), 'utf8');
      console.log('✅ Fichier team-content.json mis à jour');
    }
    return true;
  } catch (error) {
    console.error('❌ Erreur lors de l\'export Team:', error);
    return false;
  }
}

// Fonction pour exporter le contenu de la page Contact vers un fichier JSON
async function exportContactToJSON(ContactContent) {
  try {
    const content = await ContactContent.findOne().lean();
    
    if (content) {
      fs.writeFileSync(CONTACT_FILE_PATH, JSON.stringify(content, null, 2), 'utf8');
      console.log('✅ Fichier contact-content.json mis à jour');
    }
    return true;
  } catch (error) {
    console.error('❌ Erreur lors de l\'export Contact:', error);
    return false;
  }
}

// Fonction pour exporter le contenu de la page Juridique vers un fichier JSON
async function exportJuridicalToJSON(JuridicalContent) {
  try {
    const content = await JuridicalContent.findOne().lean();
    
    if (content) {
      fs.writeFileSync(JURIDICAL_FILE_PATH, JSON.stringify(content, null, 2), 'utf8');
      console.log('✅ Fichier juridical-content.json mis à jour');
    }
    return true;
  } catch (error) {
    console.error('❌ Erreur lors de l\'export Juridical:', error);
    return false;
  }
}

// Export générique d'un document unique vers un fichier JSON
async function exportSingleDoc(Model, filePath, label) {
  try {
    const content = await Model.findOne().lean();
    if (content) {
      fs.writeFileSync(filePath, JSON.stringify(content, null, 2), 'utf8');
      console.log('✅ Fichier ' + label + ' mis à jour');
    }
    return true;
  } catch (error) {
    console.error('❌ Erreur lors de l\'export ' + label + ':', error);
    return false;
  }
}

const exportFooterToJSON = (FooterContent) => exportSingleDoc(FooterContent, FOOTER_FILE_PATH, 'footer-content.json');
const exportPhotosToJSON = (AlbumContent) => exportSingleDoc(AlbumContent, PHOTOS_FILE_PATH, 'photos-content.json');
const exportVideosToJSON = (VideoContent) => exportSingleDoc(VideoContent, VIDEOS_FILE_PATH, 'videos-content.json');
const exportMembersToJSON = (ServiceMemberContent) => exportSingleDoc(ServiceMemberContent, MEMBERS_FILE_PATH, 'members-content.json');

module.exports = {
  exportLinksToJSON,
  exportContentToJSON,
  exportAboutToJSON,
  exportHistoryToJSON,
  exportTeamToJSON,
  exportContactToJSON,
  exportJuridicalToJSON,
  exportFooterToJSON,
  exportPhotosToJSON,
  exportVideosToJSON,
  exportMembersToJSON,
  JSON_FILE_PATH,
  CONTENT_FILE_PATH,
  ABOUT_FILE_PATH,
  HISTORY_FILE_PATH,
  TEAM_FILE_PATH,
  CONTACT_FILE_PATH,
  JURIDICAL_FILE_PATH,
  FOOTER_FILE_PATH,
  PHOTOS_FILE_PATH,
  VIDEOS_FILE_PATH,
  MEMBERS_FILE_PATH
};
