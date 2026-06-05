<?php
require './utils/header.php';
require_once './utils/content-store.php';

// Contenu administrable (/content/juridique.json)
$juridicalContent = tmk_content('juridique', tmk_defaults('juridique'));

$pageTitle    = 'Statut Juridique';
$mainTitle    = $juridicalContent['mainTitle'] ?? "Le Statut Juridique de l'Entreprise";
$introduction = $juridicalContent['introduction'] ?? '';
$listTitle    = $juridicalContent['listTitle'] ?? 'Points clés des documents :';
$summary      = $juridicalContent['summary'] ?? '';
$items        = $juridicalContent['items'] ?? [];
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
