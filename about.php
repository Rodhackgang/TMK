<?php
require './utils/header.php';
require_once './utils/content-store.php';

// Contenu administrable (/content/about.json)
$aboutContent = tmk_content('about', tmk_defaults('about'));

$pageTitle = 'À Propos de Nous';
$sectionTitle = $aboutContent['sectionTitle'] ?? "Nos Domaines d'Intervention";
$sectionDescription = $aboutContent['sectionDescription'] ?? '';
$services = $aboutContent['services'] ?? [];

// Section "Notre mission" (non éditée ici, valeurs par défaut)
$missionTitle = 'Notre Mission';
$missionDescription = "The Miracle Kingdom Foundation s'engage à transformer les vies et les communautés à travers des interventions humanitaires, éducatives et de développement durable.";
$missionValues = [
    ['icon' => 'fa fa-heart', 'label' => 'Compassion'],
    ['icon' => 'fa fa-handshake', 'label' => 'Intégrité'],
    ['icon' => 'fa fa-star', 'label' => 'Excellence'],
    ['icon' => 'fa fa-globe', 'label' => 'Impact'],
];
$impactNumber = '10,000+';
$impactLabel = 'Vies Transformées';
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
