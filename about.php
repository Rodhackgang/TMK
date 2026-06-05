<?php
require './utils/header.php';
require_once './utils/api-config.php';

// Lire le contenu depuis le fichier JSON ou l'API
$jsonFile = __DIR__ . '/Backend/about-content.json';
$aboutContent = getContentFromJsonOrApi($jsonFile, '/api/content/about');

// Valeurs par défaut
$pageTitle = $aboutContent['pageTitle'] ?? 'À Propos de Nous';
$sectionTitle = $aboutContent['sectionTitle'] ?? 'Nos Domaines d\'Intervention';
$sectionDescription = $aboutContent['sectionDescription'] ?? 'The Miracle Kingdom Foundation s\'engage dans six domaines clés pour transformer les communautés et créer un impact durable.';
$services = $aboutContent['services'] ?? [];
$mission = $aboutContent['mission'] ?? [];

// Valeurs mission par défaut
$missionTitle = $mission['title'] ?? 'Notre Mission';
$missionDescription = $mission['description'] ?? 'The Miracle Kingdom Foundation s\'engage à transformer les vies et les communautés à travers des interventions humanitaires, éducatives et de développement durable.';
$missionValues = $mission['values'] ?? [];
$impactNumber = $mission['impactNumber'] ?? '10,000+';
$impactLabel = $mission['impactLabel'] ?? 'Vies Transformées';

// Services par défaut si vide
if (empty($services)) {
    $services = [
        ['icon' => 'fa fa-heart', 'iconClass' => 'humanitarian', 'title' => 'Aide humanitaire', 'description' => 'Actions humanitaires menées au cœur des zones vulnérables pour répondre aux besoins alimentaires urgents des populations les plus démunis.', 'buttonText' => 'LIRE', 'buttonLink' => 'aide-humanitaire.php'],
        ['icon' => 'fa fa-graduation-cap', 'iconClass' => 'education', 'title' => 'Éducation pour tous', 'description' => 'Programmes éducatifs innovantes pour les enfants et jeunes des communautés défavorisées, avec un focus sur l\'alphabétisation.', 'buttonText' => 'LIRE', 'buttonLink' => 'education.php'],
        ['icon' => 'fa fa-stethoscope', 'iconClass' => 'health', 'title' => 'Services de Santé', 'description' => 'Accès aux soins primaires et campagnes de prévention dans les zones reculées pour améliorer la santé communautaire.', 'buttonText' => 'LIRE', 'buttonLink' => 'sante.php'],
        ['icon' => 'fa fa-users', 'iconClass' => 'marginalized', 'title' => 'Projets humanitaires', 'description' => 'Soutien spécialisé pour les réfugiés, déplacés internes et autres groupes vulnérables avec programmes de réinsertion.', 'buttonText' => 'LIRE', 'buttonLink' => 'projets-humanitaires.php']
    ];
}

// Forcer la première carte (Aide humanitaire) avec le nouveau contenu : titre, description, bouton LIRE (sans statistique)
$firstCard = [
    'icon' => 'fa fa-heart',
    'iconClass' => 'humanitarian',
    'title' => 'Aide humanitaire',
    'description' => 'Actions humanitaires menées au cœur des zones vulnérables pour répondre aux besoins alimentaires urgents des populations les plus démunis.',
    'buttonText' => 'LIRE',
    'buttonLink' => 'aide-humanitaire.php'
];
if (!empty($services)) {
    $services[0] = $firstCard;
}

// Forcer la deuxième carte (Éducation pour tous) : titre, description, bouton LIRE (sans statistique)
$secondCard = [
    'icon' => 'fa fa-graduation-cap',
    'iconClass' => 'education',
    'title' => 'Éducation pour tous',
    'description' => 'Programmes éducatifs innovantes pour les enfants et jeunes des communautés défavorisées, avec un focus sur l\'alphabétisation.',
    'buttonText' => 'LIRE',
    'buttonLink' => 'education.php'
];
if (isset($services[1])) {
    $services[1] = $secondCard;
}

// Forcer la troisième carte (Services de Santé) : titre, description, bouton LIRE (sans statistique)
$thirdCard = [
    'icon' => 'fa fa-stethoscope',
    'iconClass' => 'health',
    'title' => 'Services de Santé',
    'description' => 'Accès aux soins primaires et campagnes de prévention dans les zones reculées pour améliorer la santé communautaire.',
    'buttonText' => 'LIRE',
    'buttonLink' => 'sante.php'
];
if (isset($services[2])) {
    $services[2] = $thirdCard;
}

// Forcer la quatrième carte (Projets humanitaires) : titre, description, bouton LIRE (sans statistique)
$fourthCard = [
    'icon' => 'fa fa-users',
    'iconClass' => 'marginalized',
    'title' => 'Projets humanitaires',
    'description' => 'Soutien spécialisé pour les réfugiés, déplacés internes et autres groupes vulnérables avec programmes de réinsertion.',
    'buttonText' => 'LIRE',
    'buttonLink' => 'projets-humanitaires.php'
];
if (isset($services[3])) {
    $services[3] = $fourthCard;
}

// Ne garder que les 4 premières cartes (suppression Unité et Paix, Développement Communautaire)
$services = array_slice($services, 0, 4);

// Valeurs par défaut si vide
if (empty($missionValues)) {
    $missionValues = [
        ['icon' => 'fa fa-heart', 'label' => 'Compassion'],
        ['icon' => 'fa fa-handshake', 'label' => 'Intégrité'],
        ['icon' => 'fa fa-star', 'label' => 'Excellence'],
        ['icon' => 'fa fa-globe', 'label' => 'Impact']
    ];
}
?>

<!-- Page Header : logo TMK (The Miracle Kingdom) – image en fond plein écran -->
<section id="page-header" class="parallax page-header--logo">
  <div class="page-header-logo">
    <img src="images/tmk-header.png" alt="TMK - The Miracle Kingdom" class="tmk-logo-img">
  </div>
  <div class="overlay"></div>
  </div>
</section>

<!-- About Content -->
<section id="about-content" class="section">
  <div class="container">
    
    <!-- Section Header -->
    <div class="title-box text-center title-box--about">
      <h2 class="title"><?php echo htmlspecialchars($sectionTitle); ?></h2>
      <p class="lead lead--about"><?php echo htmlspecialchars($sectionDescription); ?></p>
    </div>

    <!-- Services Grid -->
    <div class="services-grid">
      
      <?php foreach ($services as $service): ?>
      <div class="service-card">
        <div class="service-icon <?php echo htmlspecialchars($service['iconClass'] ?? 'humanitarian'); ?>">
          <i class="<?php echo htmlspecialchars($service['icon'] ?? 'fa fa-heart'); ?>"></i>
        </div>
        <div class="service-content">
          <h3><?php echo htmlspecialchars($service['title'] ?? ''); ?></h3>
          <p><?php echo htmlspecialchars($service['description'] ?? ''); ?></p>
          <?php if (!empty($service['buttonText'])): ?>
          <a href="<?php echo htmlspecialchars($service['buttonLink'] ?? '#'); ?>" class="service-btn"><?php echo htmlspecialchars($service['buttonText']); ?></a>
          <?php elseif (!empty($service['statNumber']) || !empty($service['statLabel'])): ?>
          <div class="service-stats">
            <span class="stat-number"><?php echo htmlspecialchars($service['statNumber'] ?? '0'); ?></span>
            <span class="stat-label"><?php echo htmlspecialchars($service['statLabel'] ?? ''); ?></span>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>

    </div>

    <!-- Mission Statement -->
    <div class="mission-section">
      <div class="mission-content">
        <div class="mission-text">
          <h3 class="mission-title"><?php echo htmlspecialchars($missionTitle); ?></h3>
          <p class="mission-description"><?php echo htmlspecialchars($missionDescription); ?></p>
          <div class="mission-values">
            <?php foreach ($missionValues as $value): ?>
            <div class="value-item">
              <i class="<?php echo htmlspecialchars($value['icon'] ?? 'fa fa-star'); ?>"></i>
              <span><?php echo htmlspecialchars($value['label'] ?? ''); ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="mission-visual">
          <div class="impact-circle">
            <div class="impact-number"><?php echo htmlspecialchars($impactNumber); ?></div>
            <div class="impact-label"><?php echo htmlspecialchars($impactLabel); ?></div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<?php
require './utils/footer.php'
?>
