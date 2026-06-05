<?php
require './utils/header.php';
require_once './utils/api-config.php';

// Charger le contenu depuis le fichier JSON ou l'API
$jsonPath = __DIR__ . '/Backend/juridical-content.json';
$juridicalContent = getContentFromJsonOrApi($jsonPath, '/api/content/juridical');

// Valeurs par défaut si le fichier JSON n'existe pas
$pageTitle = $juridicalContent['pageTitle'] ?? 'Statut Juridique';
$mainTitle = $juridicalContent['mainTitle'] ?? 'Le Statut Juridique de l\'Entreprise';
$introduction = $juridicalContent['introduction'] ?? 'Les documents concernent l\'<strong>Association Sans But Lucratif (ASBL)</strong> dénommée <strong>"THE MIRACLE KINGDOM" (TMK)</strong> située à Kinshasa, République Démocratique du Congo. Ils retracent le processus d\'obtention de la personnalité juridique et de l\'autorisation d\'opérer de l\'association.';
$listTitle = $juridicalContent['listTitle'] ?? 'Points clés des documents :';
$summary = $juridicalContent['summary'] ?? 'En résumé, les documents montrent les démarches administratives et légales entreprises par l\'ASBL "THE MIRACLE KINGDOM" pour être reconnue et autorisée à opérer en République Démocratique du Congo.';

// Items par défaut
$defaultItems = [
    ['icon' => 'fa-file-text', 'title' => 'Acte Notarié', 'description' => 'Un acte notarié a été établi par le Ministère de la Justice et Garde des Sceaux, certifiant la présentation des statuts de l\'association "THE MIRACLE KINGDOM".'],
    ['icon' => 'fa-book', 'title' => 'Statuts et Règlement Intérieur', 'description' => 'Les statuts et le règlement intérieur de l\'ASBL "THE MIRACLE KINGDOM" ont été rédigés en janvier 2023.'],
    ['icon' => 'fa-envelope', 'title' => 'Accusé de Réception', 'description' => 'Le Ministère de la Justice a accusé réception de la demande de personnalité juridique de l\'association, et a fourni des instructions pour la constitution du dossier.'],
    ['icon' => 'fa-check-circle', 'title' => 'Arrêté Ministériel et Notification', 'description' => 'Le Ministère des Affaires Sociales, Actions Humanitaires et Solidarité Nationale a accordé un avis favorable à l\'ASBL "THE MIRACLE KINGDOM", l\'autorisant à exercer ses activités sur toute l\'étendue de la République Démocratique du Congo.']
];

$items = $juridicalContent['items'] ?? $defaultItems;
?>

<!-- Page Header : bannière TMK -->
<section id="page-header" class="parallax page-header--logo">
  <div class="page-header-logo">
    <img src="images/tmk-header.png" alt="TMK - The Miracle Kingdom" class="tmk-logo-img">
  </div>
  <div class="overlay"></div>
</section>

<!-- Section Statut Juridique -->
<section id="juridique-content" class="section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="title-box text-center">
          <h2 class="title"><?php echo htmlspecialchars($mainTitle); ?></h2>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-md-12">
        <div class="juridique-box">
          <div class="juridique-intro">
            <p><?php echo $introduction; ?></p>
          </div>

          <div class="juridique-details">
            <h3><?php echo htmlspecialchars($listTitle); ?></h3>
            
            <?php foreach ($items as $item): ?>
            <div class="juridique-item">
              <div class="juridique-icon">
                <i class="fa <?php echo htmlspecialchars($item['icon']); ?>"></i>
              </div>
              <div class="juridique-content">
                <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                <p><?php echo $item['description']; ?></p>
              </div>
            </div>
            <?php endforeach; ?>
          </div>

          <div class="juridique-summary">
            <div class="summary-box">
              <i class="fa fa-info-circle"></i>
              <p><?php echo $summary; ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
require './utils/footer.php'
?>
