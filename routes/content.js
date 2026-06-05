const express = require('express');
const router = express.Router();
const HomeContent = require('../models/HomeContent');
const AboutContent = require('../models/AboutContent');
const HistoryContent = require('../models/HistoryContent');
const TeamContent = require('../models/TeamContent');
const ContactContent = require('../models/ContactContent');
const JuridicalContent = require('../models/JuridicalContent');
const { exportContentToJSON, exportAboutToJSON, exportHistoryToJSON, exportTeamToJSON, exportContactToJSON, exportJuridicalToJSON } = require('../utils/exportLinks');

// Récupérer le contenu de la page d'accueil
router.get('/home', async (req, res) => {
  try {
    let content = await HomeContent.findOne();
    
    // Si aucun contenu n'existe, créer le contenu par défaut
    if (!content) {
      content = new HomeContent({
        hero: {
          videoUrl: 'images/1.mp4',
          title: 'Un avenir meilleur pour tous',
          subtitle: 'Agissons ensemble pour un changement durable',
          donateButtonText: 'Faire un don',
          videoButtonText: 'Voir notre vidéo',
          uiuxText: 'Vous souhaitez créer un site web professionnel ? Contactez-nous pour donner vie à vos projets numériques avec une approche UI/UX moderne et efficace.',
          uiuxButtonText: 'Créer votre site web',
          uiuxWhatsappLink: 'https://wa.me/243974555964'
        },
        videoSection: {
          title: 'Notre Mission en Action',
          subtitle: 'Découvrez comment votre soutien transforme des vies dans les domaines de l\'éducation, de la santé et de l\'aide humanitaire.',
          videos: ['images/2.mp4'],
          youtubeUrl: 'https://www.youtube.com/embed/IUnlo_BRRBA'
        },
        donationModal: {
          title: 'Merci de votre générosité',
          subtitle: 'Votre don fait la différence !',
          note: 'Après votre don, envoyez un SMS avec votre nom au même numéro pour confirmation.'
        },
        donationSection: {
          title: 'Soutenez Notre Cause',
          description: 'Votre générosité peut changer des vies. Faites un don maintenant et aidez-nous à créer un impact durable.'
        },
        phoneNumbers: [
          { icon: 'fab fa-whatsapp', number: '0824078000', operator: 'Vodacom' },
          { icon: 'fas fa-mobile-alt', number: '0850958952', operator: 'Orange' },
          { icon: 'fas fa-phone', number: '0978219845', operator: 'Airtel' }
        ],
        contactSection: {
          title: 'Besoin d\'un site similaire ?',
          description: 'Contactez-nous pour la conception de votre site web professionnel',
          buttonText: 'Nous contacter',
          whatsappLink: 'https://wa.me/+243974555964?text=Bonjour,%20je%20suis%20intéressé%20par%20la%20conception%20d\'un%20site%20internet.'
        }
      });
      await content.save();
      await exportContentToJSON(HomeContent);
    }
    
    res.json(content);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Mettre à jour le contenu de la page d'accueil
router.put('/home', async (req, res) => {
  try {
    let content = await HomeContent.findOne();
    
    if (!content) {
      content = new HomeContent(req.body);
    } else {
      // Mettre à jour les champs
      Object.assign(content, req.body);
    }
    
    await content.save();
    await exportContentToJSON(HomeContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Mettre à jour une section spécifique
router.patch('/home/:section', async (req, res) => {
  try {
    const { section } = req.params;
    let content = await HomeContent.findOne();
    
    if (!content) {
      return res.status(404).json({ error: 'Contenu non trouvé' });
    }
    
    if (content[section] !== undefined) {
      content[section] = { ...content[section].toObject(), ...req.body };
      await content.save();
      await exportContentToJSON(HomeContent);
      res.json(content);
    } else {
      res.status(400).json({ error: 'Section non valide' });
    }
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Ajouter un numéro de téléphone
router.post('/home/phone', async (req, res) => {
  try {
    let content = await HomeContent.findOne();
    
    if (!content) {
      return res.status(404).json({ error: 'Contenu non trouvé' });
    }
    
    content.phoneNumbers.push(req.body);
    await content.save();
    await exportContentToJSON(HomeContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Supprimer un numéro de téléphone
router.delete('/home/phone/:index', async (req, res) => {
  try {
    const { index } = req.params;
    let content = await HomeContent.findOne();
    
    if (!content) {
      return res.status(404).json({ error: 'Contenu non trouvé' });
    }
    
    content.phoneNumbers.splice(parseInt(index), 1);
    await content.save();
    await exportContentToJSON(HomeContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Ajouter une vidéo
router.post('/home/video', async (req, res) => {
  try {
    let content = await HomeContent.findOne();
    
    if (!content) {
      return res.status(404).json({ error: 'Contenu non trouvé' });
    }
    
    content.videoSection.videos.push(req.body.url);
    await content.save();
    await exportContentToJSON(HomeContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Supprimer une vidéo
router.delete('/home/video/:index', async (req, res) => {
  try {
    const { index } = req.params;
    let content = await HomeContent.findOne();
    
    if (!content) {
      return res.status(404).json({ error: 'Contenu non trouvé' });
    }
    
    content.videoSection.videos.splice(parseInt(index), 1);
    await content.save();
    await exportContentToJSON(HomeContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// ============================================
// ROUTES ABOUT PAGE
// ============================================

// Récupérer le contenu de la page About
router.get('/about', async (req, res) => {
  try {
    let content = await AboutContent.findOne();
    
    if (!content) {
      content = new AboutContent({
        pageTitle: 'À Propos de Nous',
        sectionTitle: 'Nos Domaines d\'Intervention',
        sectionDescription: 'The Miracle Kingdom Foundation s\'engage dans six domaines clés pour transformer les communautés et créer un impact durable.',
        services: [
          { icon: 'fa fa-heart', iconClass: 'humanitarian', title: 'Projets Humanitaires', description: 'Interventions dans les zones vulnérables pour fournir aide alimentaire et soins médicaux d\'urgence aux populations dans le besoin.', statNumber: '500+', statLabel: 'Familles aidées' },
          { icon: 'fa fa-graduation-cap', iconClass: 'education', title: 'Éducation pour Tous', description: 'Programmes éducatifs innovants pour les enfants et jeunes des communautés défavorisées, avec un focus sur l\'alphabétisation.', statNumber: '1000+', statLabel: 'Élèves scolarisés' },
          { icon: 'fa fa-stethoscope', iconClass: 'health', title: 'Services de Santé', description: 'Accès aux soins primaires et campagnes de prévention dans les zones reculées pour améliorer la santé communautaire.', statNumber: '2000+', statLabel: 'Consultations' },
          { icon: 'fa fa-users', iconClass: 'marginalized', title: 'Aide aux Marginalisés', description: 'Soutien spécialisé pour les réfugiés, déplacés internes et autres groupes vulnérables avec programmes de réinsertion.', statNumber: '300+', statLabel: 'Personnes réinsérées' },
          { icon: 'fa fa-dove', iconClass: 'peace', title: 'Unité et Paix', description: 'Initiatives de réconciliation et programmes de cohésion sociale dans les zones post-conflit pour construire la paix.', statNumber: '15', statLabel: 'Communautés réconciliées' },
          { icon: 'fa fa-cogs', iconClass: 'development', title: 'Développement Communautaire', description: 'Projets durables pour renforcer l\'autonomie et les infrastructures locales avec approche participative communautaire.', statNumber: '25', statLabel: 'Projets réalisés' }
        ],
        mission: {
          title: 'Notre Mission',
          description: 'The Miracle Kingdom Foundation s\'engage à transformer les vies et les communautés à travers des interventions humanitaires, éducatives et de développement durable. Nous croyons en la dignité de chaque être humain et nous nous efforçons de créer un monde où chacun peut vivre dans la paix, la prospérité et l\'harmonie.',
          values: [
            { icon: 'fa fa-heart', label: 'Compassion' },
            { icon: 'fa fa-handshake', label: 'Intégrité' },
            { icon: 'fa fa-star', label: 'Excellence' },
            { icon: 'fa fa-globe', label: 'Impact' }
          ],
          impactNumber: '10,000+',
          impactLabel: 'Vies Transformées'
        }
      });
      await content.save();
      await exportAboutToJSON(AboutContent);
    }
    
    res.json(content);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Mettre à jour le contenu About
router.put('/about', async (req, res) => {
  try {
    let content = await AboutContent.findOne();
    
    if (!content) {
      content = new AboutContent(req.body);
    } else {
      Object.assign(content, req.body);
    }
    
    await content.save();
    await exportAboutToJSON(AboutContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Ajouter un service
router.post('/about/service', async (req, res) => {
  try {
    let content = await AboutContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    content.services.push(req.body);
    await content.save();
    await exportAboutToJSON(AboutContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Modifier un service
router.put('/about/service/:index', async (req, res) => {
  try {
    let content = await AboutContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    const index = parseInt(req.params.index);
    if (content.services[index]) {
      content.services[index] = { ...content.services[index].toObject(), ...req.body };
      await content.save();
      await exportAboutToJSON(AboutContent);
    }
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Supprimer un service
router.delete('/about/service/:index', async (req, res) => {
  try {
    let content = await AboutContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    content.services.splice(parseInt(req.params.index), 1);
    await content.save();
    await exportAboutToJSON(AboutContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Ajouter une valeur
router.post('/about/value', async (req, res) => {
  try {
    let content = await AboutContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    content.mission.values.push(req.body);
    await content.save();
    await exportAboutToJSON(AboutContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Supprimer une valeur
router.delete('/about/value/:index', async (req, res) => {
  try {
    let content = await AboutContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    content.mission.values.splice(parseInt(req.params.index), 1);
    await content.save();
    await exportAboutToJSON(AboutContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// ============================================
// ROUTES HISTORY PAGE
// ============================================

// Contenu par défaut de la page histoire
const defaultHistorySections = [
  { type: 'heading', level: 3, content: '1. Préambule' },
  { type: 'paragraph', content: 'Il n\'est donc pas un secret de connaitre que sur cette terre, il existe plusieurs types de problèmes que vivent les êtres humains et qui leur empêchent de s\'épanouir dans leur vie. En effet, tout le monde n\'a pas toujours la chance d\'avoir les moyens nécessaires pour vivre une vie capable de leur permettre d\'avancer ou d\'être heureux, suite à plusieurs circonstances de la vie telles que :' },
  { type: 'list', items: ['La pauvreté', 'La marginalisation, etc.'] },
  { type: 'paragraph', content: 'Ces circonstances jouent un rôle négatif en engendrant une longévité réduite, une mauvaise santé, une malnutrition, l\'analphabétisme, un manque de confiance en soi, etc.' },
  { type: 'heading', level: 3, content: '2. Fondation THE MIRACLE KINGDOM' },
  { type: 'paragraph', content: 'Suite aux problèmes cités ci-dessus, l\'idée de créer une fondation a été jugée utile afin de réduire la pauvreté et les inégalités, ainsi que d\'améliorer le train de vie des êtres humains.' },
  { type: 'images', images: ['../images/logos.png', '../images/logo.png'], centered: true },
  { type: 'paragraph', content: 'Ladite fondation, appelé « THE MIRACLE KINGDOM », « TMK » en sigle, est une association qui consiste à contribuer à l\'amélioration et au développement de la vie sociale des êtres humains tout à leur aidant à être utiles en eux-mêmes et à la société.' },
  { type: 'image', content: '../images/enfan.png', centered: true },
  { type: 'heading', level: 4, content: 'Elle consiste également à influencer de façon positive les générations pour bâtir un avenir meilleur.' },
  { type: 'heading', level: 3, content: '2.1 Objectifs poursuivis par la fondation' },
  { type: 'list', items: ['Assainir l\'environnement', 'Soutenir les personnes marginalisées et désavantagées', 'Aider les personnes démunies', 'Réduire la pauvreté et les inégalités', 'Créer des orphelinats', 'Instruire et former les individus en leadership et entrepreneuriat', 'Accroître l\'accès aux biens et services', 'Créer des emplois'] },
  { type: 'heading', level: 3, content: '2.2 Pourquoi le nom « THE MIRACLE KINGDOM » ?' },
  { type: 'paragraph', content: '« THE MIRACLE KINGDOM » signifie « Royaume de miracle ». Il est important de noter que la fondation est avant tout chrétienne, réunissant plusieurs personnes distinguées, apportant chacune leurs objectifs individuels dans un même projet. Son slogan est : « Espérance, amour, union et foi ».' },
  { type: 'heading', level: 3, content: '2.3 Création de la fondation' },
  { type: 'paragraph', content: 'L\'initiative du projet TMK a commencé en mai 2021, dans le but d\'améliorer la vie sociale dans le monde.' },
  { type: 'heading', level: 3, content: '3. Fonctionnement de TMK' },
  { type: 'paragraph', content: 'Comme toute association ou organisation sociale, la fondation TMK fonctionne grâce aux cotisations mensuelles de ses membres, qui contribuent à la caisse de la fondation.' },
  { type: 'heading', level: 2, content: '4. Les réalisations de TMK en 2021' },
  { type: 'heading', level: 4, content: '4.1 Première descente à l\'orphelinat C.O.C' },
  { type: 'image', content: '../images/orphelinat.png', centered: true },
  { type: 'paragraph', content: 'Le 02 juillet 2021, la fondation TMK fait sa première descente à l\'orphelinat C.O.C qui se trouve à bandal tshibangu (derrière alimentation kin marché).' },
  { type: 'image', content: '../images/enfants.png', centered: true },
  { type: 'heading', level: 2, content: '5. Soutien aux hôpitaux et lutte contre la drépanocytose' },
  { type: 'heading', level: 2, content: '6. Nos réalisations pour l\'année 2023' },
  { type: 'paragraph', content: 'Etant une année jugée décisives, pour 2023, THE MIRACLE KINGDOM avait décidé d\'améliorer et de diversifier ses activités dans plusieurs secteurs.' }
];

// Récupérer le contenu de la page Histoire
router.get('/history', async (req, res) => {
  try {
    let content = await HistoryContent.findOne();
    
    if (!content) {
      content = new HistoryContent({
        pageTitle: 'Histoire de TMK Foundation',
        logoUrl: '../images/logo.png',
        mainTitle: 'The Miracle Kingdom',
        sections: defaultHistorySections
      });
      await content.save();
      await exportHistoryToJSON(HistoryContent);
    }
    
    res.json(content);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Mettre à jour le contenu Histoire
router.put('/history', async (req, res) => {
  try {
    let content = await HistoryContent.findOne();
    
    if (!content) {
      content = new HistoryContent(req.body);
    } else {
      Object.assign(content, req.body);
    }
    
    await content.save();
    await exportHistoryToJSON(HistoryContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Ajouter une section
router.post('/history/section', async (req, res) => {
  try {
    let content = await HistoryContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    content.sections.push(req.body);
    await content.save();
    await exportHistoryToJSON(HistoryContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Modifier une section
router.put('/history/section/:index', async (req, res) => {
  try {
    let content = await HistoryContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    const index = parseInt(req.params.index);
    if (content.sections[index]) {
      content.sections[index] = { ...content.sections[index].toObject(), ...req.body };
      await content.save();
      await exportHistoryToJSON(HistoryContent);
    }
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Supprimer une section
router.delete('/history/section/:index', async (req, res) => {
  try {
    let content = await HistoryContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    content.sections.splice(parseInt(req.params.index), 1);
    await content.save();
    await exportHistoryToJSON(HistoryContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Réorganiser les sections
router.put('/history/reorder', async (req, res) => {
  try {
    let content = await HistoryContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    const { fromIndex, toIndex } = req.body;
    const sections = [...content.sections];
    const [removed] = sections.splice(fromIndex, 1);
    sections.splice(toIndex, 0, removed);
    
    content.sections = sections;
    await content.save();
    await exportHistoryToJSON(HistoryContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// ============================================
// ROUTES TEAM PAGE
// ============================================

// Membres par défaut
const defaultMembers = [
  { name: 'Franck Nsinga', photo: 'images/1.jpeg', order: 1 },
  { name: 'Leaticia Abibu', photo: 'images/2.jpeg', order: 2 },
  { name: 'Patrick Nsapu', photo: 'images/3.jpeg', order: 3 },
  { name: 'Nkulu Justine', photo: 'images/4.jpeg', order: 4 },
  { name: 'Nkongolo Kabeji Isabelle', photo: 'images/5.jpeg', order: 5 },
  { name: 'Yambanu Ndugbia Glody', photo: 'images/6.jpeg', order: 6 },
  { name: 'Nono Olivera', photo: 'images/7.jpeg', order: 7 },
  { name: 'Elie Tshilongo', photo: 'images/8.jpeg', order: 8 },
  { name: 'Nsumbu Ramath', photo: 'images/9.jpeg', order: 9 },
  { name: 'Kabeya Kayembe Manassé', photo: 'images/10.jpeg', order: 10 },
  { name: 'Ngoie Mulongo Anthony Alfred', photo: 'images/11.jpeg', order: 11 },
  { name: 'Lareine NDUME', photo: 'images/12.jpeg', order: 12 },
  { name: 'Michelange Manda', photo: 'images/13.jpeg', order: 13 },
  { name: 'Mwitubile Mwebe Paola', photo: 'images/14.jpeg', order: 14 },
  { name: 'Hodd Senguime', photo: 'images/15.jpeg', order: 15 },
  { name: 'Roy Kasanda', photo: 'images/16.jpeg', order: 16 },
  { name: 'Joel Massamba', photo: 'images/17.jpeg', order: 17 },
  { name: 'Nathan masiala', photo: 'images/18.jpeg', order: 18 },
  { name: 'Esther Ngoie', photo: 'images/19.jpeg', order: 19 },
  { name: 'Malaïka Kubua Veronica', photo: 'images/20.jpeg', order: 20 },
  { name: 'Aziza Mponga Trésor', photo: 'images/21.jpeg', order: 21 }
];

// Récupérer le contenu de la page Équipe
router.get('/team', async (req, res) => {
  try {
    let content = await TeamContent.findOne();
    
    if (!content) {
      content = new TeamContent({
        sectionTitle: 'Notre Communauté',
        members: defaultMembers
      });
      await content.save();
      await exportTeamToJSON(TeamContent);
    }
    
    res.json(content);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Mettre à jour le contenu Équipe
router.put('/team', async (req, res) => {
  try {
    let content = await TeamContent.findOne();
    
    if (!content) {
      content = new TeamContent(req.body);
    } else {
      Object.assign(content, req.body);
    }
    
    await content.save();
    await exportTeamToJSON(TeamContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Ajouter un membre
router.post('/team/member', async (req, res) => {
  try {
    let content = await TeamContent.findOne();
    if (!content) {
      content = new TeamContent({ sectionTitle: 'Notre Communauté', members: [] });
    }
    
    const newMember = {
      ...req.body,
      order: content.members.length + 1
    };
    
    content.members.push(newMember);
    await content.save();
    await exportTeamToJSON(TeamContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Modifier un membre
router.put('/team/member/:index', async (req, res) => {
  try {
    let content = await TeamContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    const index = parseInt(req.params.index);
    if (content.members[index]) {
      content.members[index] = { ...content.members[index].toObject(), ...req.body };
      await content.save();
      await exportTeamToJSON(TeamContent);
    }
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Supprimer un membre
router.delete('/team/member/:index', async (req, res) => {
  try {
    let content = await TeamContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    content.members.splice(parseInt(req.params.index), 1);
    await content.save();
    await exportTeamToJSON(TeamContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Réorganiser les membres
router.put('/team/reorder', async (req, res) => {
  try {
    let content = await TeamContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    const { fromIndex, toIndex } = req.body;
    const members = [...content.members];
    const [removed] = members.splice(fromIndex, 1);
    members.splice(toIndex, 0, removed);
    
    // Mettre à jour l'ordre
    members.forEach((m, i) => m.order = i + 1);
    
    content.members = members;
    await content.save();
    await exportTeamToJSON(TeamContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// ============================================
// ROUTES CONTACT PAGE
// ============================================

// Liens sociaux par défaut
const defaultSocialLinks = [
  { platform: 'Facebook', icon: 'fa fa-facebook', url: '#' },
  { platform: 'Twitter', icon: 'fa fa-twitter', url: '#' },
  { platform: 'Instagram', icon: 'fa fa-instagram', url: '#' },
  { platform: 'LinkedIn', icon: 'fa fa-linkedin', url: '#' }
];

// Récupérer le contenu de la page Contact
router.get('/contact', async (req, res) => {
  try {
    let content = await ContactContent.findOne();
    
    if (!content) {
      content = new ContactContent({
        pageTitle: 'Contactez-nous',
        sectionTitle: 'Contactez TMK',
        contactInfo: {
          title: 'Informations de Contact',
          phone: { label: 'Téléphone', number: '+243 900 000 000' },
          email: { label: 'Email', address: 'contact@tmkfoundation.org' },
          address: { label: 'Adresse', line1: 'A108 Rue Adam', line2: 'Kinshasa, RDC' }
        },
        socialTitle: 'Suivez-nous',
        socialLinks: defaultSocialLinks,
        formSection: {
          title: 'Envoyez-nous un Message',
          description: 'Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais.',
          submitButtonText: 'Envoyer le Message'
        }
      });
      await content.save();
      await exportContactToJSON(ContactContent);
    }
    
    res.json(content);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Mettre à jour le contenu Contact
router.put('/contact', async (req, res) => {
  try {
    let content = await ContactContent.findOne();
    
    if (!content) {
      content = new ContactContent(req.body);
    } else {
      Object.assign(content, req.body);
    }
    
    await content.save();
    await exportContactToJSON(ContactContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Ajouter un lien social
router.post('/contact/social', async (req, res) => {
  try {
    let content = await ContactContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    content.socialLinks.push(req.body);
    await content.save();
    await exportContactToJSON(ContactContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Modifier un lien social
router.put('/contact/social/:index', async (req, res) => {
  try {
    let content = await ContactContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    const index = parseInt(req.params.index);
    if (content.socialLinks[index]) {
      content.socialLinks[index] = { ...content.socialLinks[index].toObject(), ...req.body };
      await content.save();
      await exportContactToJSON(ContactContent);
    }
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Supprimer un lien social
router.delete('/contact/social/:index', async (req, res) => {
  try {
    let content = await ContactContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    content.socialLinks.splice(parseInt(req.params.index), 1);
    await content.save();
    await exportContactToJSON(ContactContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// ============================================
// ROUTES JURIDICAL PAGE
// ============================================

// Items juridiques par défaut
const defaultJuridicalItems = [
  { 
    icon: 'fa-file-text', 
    title: 'Acte Notarié', 
    description: 'Un acte notarié a été établi par le Ministère de la Justice et Garde des Sceaux, certifiant la présentation des statuts de l\'association "THE MIRACLE KINGDOM".',
    order: 1
  },
  { 
    icon: 'fa-book', 
    title: 'Statuts et Règlement Intérieur', 
    description: 'Les statuts et le règlement intérieur de l\'ASBL "THE MIRACLE KINGDOM" ont été rédigés en janvier 2023.',
    order: 2
  },
  { 
    icon: 'fa-envelope', 
    title: 'Accusé de Réception', 
    description: 'Le Ministère de la Justice a accusé réception de la demande de personnalité juridique de l\'association, et a fourni des instructions pour la constitution du dossier.',
    order: 3
  },
  { 
    icon: 'fa-check-circle', 
    title: 'Arrêté Ministériel et Notification', 
    description: 'Le Ministère des Affaires Sociales, Actions Humanitaires et Solidarité Nationale a accordé un avis favorable à l\'ASBL "THE MIRACLE KINGDOM", l\'autorisant à exercer ses activités sur toute l\'étendue de la République Démocratique du Congo.',
    order: 4
  }
];

// Récupérer le contenu de la page Juridique
router.get('/juridical', async (req, res) => {
  try {
    let content = await JuridicalContent.findOne();
    
    if (!content) {
      content = new JuridicalContent({
        pageTitle: 'Statut Juridique',
        mainTitle: 'Le Statut Juridique de l\'Entreprise',
        introduction: 'Les documents concernent l\'<strong>Association Sans But Lucratif (ASBL)</strong> dénommée <strong>"THE MIRACLE KINGDOM" (TMK)</strong> située à Kinshasa, République Démocratique du Congo. Ils retracent le processus d\'obtention de la personnalité juridique et de l\'autorisation d\'opérer de l\'association.',
        listTitle: 'Points clés des documents :',
        items: defaultJuridicalItems,
        summary: 'En résumé, les documents montrent les démarches administratives et légales entreprises par l\'ASBL "THE MIRACLE KINGDOM" pour être reconnue et autorisée à opérer en République Démocratique du Congo.'
      });
      await content.save();
      await exportJuridicalToJSON(JuridicalContent);
    }
    
    res.json(content);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Mettre à jour le contenu Juridique
router.put('/juridical', async (req, res) => {
  try {
    let content = await JuridicalContent.findOne();
    
    if (!content) {
      content = new JuridicalContent(req.body);
    } else {
      Object.assign(content, req.body);
    }
    
    await content.save();
    await exportJuridicalToJSON(JuridicalContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Ajouter un item juridique
router.post('/juridical/item', async (req, res) => {
  try {
    let content = await JuridicalContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    const newItem = {
      ...req.body,
      order: content.items.length + 1
    };
    
    content.items.push(newItem);
    await content.save();
    await exportJuridicalToJSON(JuridicalContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Modifier un item juridique
router.put('/juridical/item/:index', async (req, res) => {
  try {
    let content = await JuridicalContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    const index = parseInt(req.params.index);
    if (content.items[index]) {
      content.items[index] = { ...content.items[index].toObject(), ...req.body };
      await content.save();
      await exportJuridicalToJSON(JuridicalContent);
    }
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Supprimer un item juridique
router.delete('/juridical/item/:index', async (req, res) => {
  try {
    let content = await JuridicalContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    content.items.splice(parseInt(req.params.index), 1);
    
    // Recalculer l'ordre
    content.items.forEach((item, i) => item.order = i + 1);
    
    await content.save();
    await exportJuridicalToJSON(JuridicalContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

// Réorganiser les items juridiques
router.put('/juridical/reorder', async (req, res) => {
  try {
    let content = await JuridicalContent.findOne();
    if (!content) return res.status(404).json({ error: 'Contenu non trouvé' });
    
    const { fromIndex, toIndex } = req.body;
    const items = [...content.items];
    const [removed] = items.splice(fromIndex, 1);
    items.splice(toIndex, 0, removed);
    
    // Mettre à jour l'ordre
    items.forEach((item, i) => item.order = i + 1);
    
    content.items = items;
    await content.save();
    await exportJuridicalToJSON(JuridicalContent);
    
    res.json(content);
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
});

module.exports = router;
