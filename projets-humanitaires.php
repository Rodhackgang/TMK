<?php
require './utils/header.php';

$pageTitle = 'Projets humanitaires';
$content = 'Soutien spécialisé pour les réfugiés, déplacés internes et autres groupes vulnérables avec programmes de réinsertion.';

// Données structurées : même format que projets humanitaires (timeline + galerie)
$realisations = [
    [
        'annee' => '2025',
        'date' => 'Réalisations 2025',
        'titre' => 'Descente au Camp Militaire Lieutenant KOKOLO',
        'lieu' => 'Camp Militaire Lieutenant Kokolo',
        'description' => "Depuis des années, l'Est de la RDC est meurtri par un conflit récurrent. Beaucoup de militaires ont payé le prix fort, laissant derrière eux des familles, des épouses et des enfants trop souvent livrés à une précarité silencieuse.\n\nFace à cette réalité, la fondation TMK s'est engagée pour soutenir les forces armées et venir en aide aux familles des héros tombés au champ de bataille. À travers un soutien matériel, social et humain, elle apporte réconfort, dignité et amour.\n\nLa Fondation est venue en aide à cent (100) femmes veuves du camp : à chacune un sac de riz, un pagne — symbole de la femme forte et résiliente —, une enveloppe d'aide financière et des vivres frais pour se nourrir dignement. Elle a également exprimé sa gratitude au commandement en offrant des ventilateurs en signe de remerciement pour l'appui logistique.\n\nL'activité a connu un franc succès ; les femmes bénéficiaires ont été profondément émues et ont exprimé une vive gratitude envers la Fondation pour ce geste de solidarité et de soutien.",
        'image' => 'images/aide-marginalises/groupe-soutenons-les-veuves.png',
        'images' => [
            ['src' => 'images/aide-marginalises/groupe-soutenons-les-veuves.png', 'alt' => 'Équipe TMK – Soutenons les veuves de militaires – Camp Lieutenant Kokolo'],
            ['src' => 'images/aide-marginalises/camp-kokolo-sacs-riz.png', 'alt' => 'Sacs de riz et vivres – préparation des dons pour les veuves du camp Kokolo'],
            ['src' => 'images/aide-marginalises/preparation-dons-interieur.png', 'alt' => 'Équipe TMK – organisation et conditionnement des dons en intérieur'],
            ['src' => 'images/aide-marginalises/distribution-veuves-camp-kokolo.png', 'alt' => 'Distribution des dons aux veuves – sac de riz et pagne – TMK 2025'],
            ['src' => 'images/aide-marginalises/pagnes-camp-kokolo.png', 'alt' => 'Pagnes préparés pour les veuves – symbole de la femme forte et résiliente'],
            ['src' => 'images/aide-marginalises/vivres-frais-camp-kokolo.png', 'alt' => 'Vivres frais pour les bénéficiaires'],
            ['src' => 'images/aide-marginalises/remise-enveloppe-pagne.png', 'alt' => 'Remise de l\'enveloppe d\'aide financière et du pagne aux veuves – TMK'],
            ['src' => 'images/aide-marginalises/ventilateurs-commandement.png', 'alt' => 'Remise des ventilateurs au commandement – remerciement TMK'],
            ['src' => 'images/aide-marginalises/femmes-beneficiaires-camp-kokolo.png', 'alt' => 'Femmes bénéficiaires – émotion et gratitude au camp Kokolo'],
            ['src' => 'images/aide-marginalises/beneficiaires-joie-tente.png', 'alt' => 'Bénéficiaires sous la tente – joie et reconnaissance – Camp Kokolo'],
            ['src' => 'images/aide-marginalises/beneficiaires-celebration-camp-kokolo.png', 'alt' => 'Célébration des femmes bénéficiaires – TMK 2025']
        ]
    ]
];
?>
<!-- Page Header : bannière TMK -->
<section id="page-header" class="parallax page-header--logo">
  <div class="page-header-logo">
    <img src="images/tmk-header.png" alt="TMK - The Miracle Kingdom" class="tmk-logo-img">
  </div>
  <div class="overlay"></div>
  <div class="container">
  </div>
</section>

<style>
/* ===== Section Projets humanitaires – style unifié ===== */
.section-realisations {
	background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 50%, #fff 100%);
	padding-top: 2.5rem;
	padding-bottom: 3rem;
}
.realisations-content-box {
	max-width: 960px;
	margin: 0 auto;
}
.realisations-lead {
	font-size: 1.12rem;
	line-height: 1.8;
	color: #475569;
	text-align: center;
	margin-bottom: 2.5rem;
	padding: 0 1rem;
	max-width: 720px;
	margin-left: auto;
	margin-right: auto;
	letter-spacing: 0.01em;
	font-weight: 400;
}
.realisations-title,
#domain-content .realisations-content-box h2.realisations-title {
	margin: 0 0 2.5rem;
	font-size: 1.75rem;
	color: #0f172a !important;
	font-weight: 700 !important;
	text-align: center;
	border-bottom: none;
	padding-bottom: 0.75rem;
	letter-spacing: 0.08em;
	text-transform: uppercase;
	position: relative;
}
.realisations-title::after {
	content: '';
	display: block;
	width: 64px;
	height: 4px;
	background: linear-gradient(90deg, #1e40af, #3b82f6);
	margin: 0.6rem auto 0;
	border-radius: 2px;
}
.realisations-timeline {
	position: relative;
	padding: 0 0 2.5rem;
	max-width: 900px;
	margin: 0 auto;
}
.realisations-timeline::before {
	content: '';
	position: absolute;
	left: 50%;
	top: 0;
	bottom: 0;
	width: 3px;
	background: linear-gradient(180deg, #1e40af 0%, #60a5fa 50%, #93c5fd 100%);
	transform: translateX(-1.5px);
	border-radius: 3px;
	box-shadow: 0 0 12px rgba(30, 64, 175, 0.2);
}
.timeline-item {
	position: relative;
	margin-bottom: 3rem;
	padding-left: 0;
}
.timeline-item:last-child {
	margin-bottom: 0;
}
.timeline-date-badge {
	position: absolute;
	left: 50%;
	transform: translateX(-50%);
	top: -10px;
	z-index: 2;
	background: linear-gradient(135deg, #1e40af, #2563eb);
	color: #fff;
	font-weight: 700;
	font-size: 0.9rem;
	padding: 8px 18px;
	border-radius: 24px;
	white-space: nowrap;
	box-shadow: 0 4px 14px rgba(30, 64, 175, 0.4);
	border: 2px solid rgba(255, 255, 255, 0.3);
	letter-spacing: 0.02em;
}
.timeline-card {
	width: calc(50% - 32px);
	margin-top: 32px;
	position: relative;
}
.timeline-left .timeline-card {
	margin-left: 0;
	margin-right: auto;
	padding-right: 44px;
}
.timeline-right .timeline-card {
	margin-left: auto;
	margin-right: 0;
	padding-left: 44px;
}
.timeline-card-inner {
	background: #fff;
	border-radius: 16px;
	overflow: hidden;
	box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06), 0 2px 8px rgba(30, 64, 175, 0.06);
	border: 1px solid rgba(226, 232, 240, 0.9);
	transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.timeline-card-inner:hover {
	transform: translateY(-4px);
	box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(30, 64, 175, 0.12);
	border-color: rgba(147, 197, 253, 0.4);
}
.timeline-card-image {
	width: 100%;
	height: 200px;
	background: linear-gradient(145deg, #f1f5f9 0%, #e2e8f0 100%);
	overflow: hidden;
	position: relative;
}
.timeline-card-image > img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	display: block;
}
.timeline-gallery {
	display: grid;
	grid-template-columns: repeat(2, 1fr);
	gap: 8px;
	width: 100%;
	height: 100%;
	min-height: 200px;
	padding: 0;
}
.timeline-gallery-item {
	position: relative;
	cursor: pointer;
	overflow: hidden;
	border-radius: 10px;
	background: #e2e8f0;
}
.timeline-gallery-item img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	display: block;
	transition: transform 0.4s ease;
	min-height: 96px;
}
.timeline-gallery-item:hover img {
	transform: scale(1.08);
}
.timeline-gallery-item:focus {
	outline: 2px solid #1e40af;
	outline-offset: 2px;
}
.timeline-gallery-item .timeline-gallery-zoom {
	position: absolute;
	inset: 0;
	background: linear-gradient(180deg, transparent 30%, rgba(0, 0, 0, 0.6) 100%);
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	opacity: 0;
	transition: opacity 0.3s ease;
	color: #fff;
	font-size: 1.5rem;
	gap: 4px;
}
.timeline-gallery-item .timeline-gallery-zoom-text {
	font-size: 0.75rem;
	font-weight: 600;
	letter-spacing: 0.05em;
	text-transform: uppercase;
}
.timeline-gallery-item:hover .timeline-gallery-zoom,
.timeline-gallery-item:focus .timeline-gallery-zoom {
	opacity: 1;
}
.timeline-gallery img {
	height: 100%;
	min-height: 96px;
}
@media (min-width: 768px) {
	.timeline-gallery {
		grid-template-columns: repeat(3, 1fr);
		gap: 10px;
	}
	.timeline-card-image {
		height: 220px;
	}
	.timeline-gallery {
		min-height: 220px;
	}
}
.timeline-image-placeholder {
	width: 100%;
	height: 100%;
	min-height: 200px;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	color: #94a3b8;
	font-size: 0.95rem;
	font-weight: 500;
	letter-spacing: 0.02em;
	background: linear-gradient(145deg, #f1f5f9 0%, #e2e8f0 100%);
}
.timeline-image-placeholder::before {
	content: '';
	display: block;
	width: 48px;
	height: 48px;
	margin-bottom: 10px;
	border: 3px dashed #cbd5e1;
	border-radius: 12px;
	opacity: 0.8;
}
.timeline-image-placeholder small {
	font-size: 0.72rem;
	margin-top: 6px;
	color: #cbd5e1;
	max-width: 90%;
	text-align: center;
	word-break: break-all;
	letter-spacing: 0.01em;
}
.timeline-card-content {
	padding: 1.4rem 1.5rem 1.6rem;
}
.timeline-meta {
	font-size: 0.8rem;
	color: #64748b;
	margin-bottom: 0.6rem;
	line-height: 1.5;
	letter-spacing: 0.02em;
	font-weight: 500;
}
.timeline-card-title {
	font-size: 1.2rem;
	font-weight: 700;
	color: #0f172a;
	margin: 0 0 0.75rem;
	line-height: 1.4;
	letter-spacing: 0.01em;
}
.timeline-card-desc {
	font-size: 0.98rem;
	line-height: 1.75;
	color: #475569;
	margin: 0;
	letter-spacing: 0.01em;
}
.timeline-card-desc br + * { margin-top: 0.5em; }
/* Lien Retour */
.realisations-back-wrap {
	margin-top: 2.5rem;
	margin-bottom: 0;
	text-align: center;
}
.realisations-back-link {
	display: inline-flex;
	align-items: center;
	gap: 0.5rem;
	padding: 0.65rem 1.25rem;
	font-size: 0.95rem;
	font-weight: 600;
	letter-spacing: 0.02em;
	color: #1e40af;
	background: #fff;
	border: 2px solid #93c5fd;
	border-radius: 12px;
	text-decoration: none;
	transition: color 0.25s ease, background 0.25s ease, border-color 0.25s ease, transform 0.2s ease;
}
.realisations-back-link:hover {
	color: #fff;
	background: linear-gradient(135deg, #1e40af, #2563eb);
	border-color: #1e40af;
	text-decoration: none;
	transform: translateX(-2px);
}
.realisations-back-link i {
	font-size: 0.85em;
}
/* Lightbox */
.timeline-lightbox {
	display: flex;
	position: fixed;
	inset: 0;
	background: rgba(15, 23, 42, 0.94);
	backdrop-filter: blur(8px);
	z-index: 10000;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	opacity: 0;
	visibility: hidden;
	pointer-events: none;
	transition: opacity 0.3s ease, visibility 0.3s ease;
}
.timeline-lightbox.active {
	opacity: 1;
	visibility: visible;
	pointer-events: auto;
}
.timeline-lightbox-header {
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding: 18px 24px;
	background: rgba(0, 0, 0, 0.5);
	color: #fff;
	z-index: 1;
}
.timeline-lightbox-title {
	font-size: 1rem;
	font-weight: 600;
	letter-spacing: 0.04em;
}
.timeline-lightbox-close {
	width: 48px;
	height: 48px;
	border: none;
	background: rgba(255, 255, 255, 0.12);
	color: #fff;
	border-radius: 50%;
	cursor: pointer;
	display: flex;
	align-items: center;
	justify-content: center;
	transition: background 0.2s, transform 0.2s;
}
.timeline-lightbox-close:hover {
	background: rgba(255, 255, 255, 0.25);
	transform: scale(1.05);
}
.timeline-lightbox-content {
	position: relative;
	display: flex;
	align-items: center;
	justify-content: center;
	width: 100%;
	max-width: 1200px;
	padding: 80px 24px;
	box-sizing: border-box;
}
.timeline-lightbox-img {
	max-width: 100%;
	max-height: 82vh;
	width: auto;
	height: auto;
	object-fit: contain;
	display: block;
	border-radius: 8px;
	box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
}
.timeline-lightbox-nav {
	position: absolute;
	top: 50%;
	transform: translateY(-50%);
	width: 52px;
	height: 52px;
	border: none;
	background: rgba(255, 255, 255, 0.15);
	color: #fff;
	border-radius: 50%;
	cursor: pointer;
	display: flex;
	align-items: center;
	justify-content: center;
	transition: background 0.2s, transform 0.2s;
	z-index: 2;
}
.timeline-lightbox-nav:hover {
	background: rgba(255, 255, 255, 0.3);
	transform: translateY(-50%) scale(1.08);
}
.timeline-lightbox-prev { left: 16px; }
.timeline-lightbox-next { right: 16px; }
/* Responsive */
@media (max-width: 768px) {
	.section-realisations {
		padding-top: 1.5rem;
		padding-bottom: 2rem;
	}
	.realisations-lead {
		margin-bottom: 1.75rem;
		font-size: 1.05rem;
		line-height: 1.75;
		padding: 0 0.5rem;
	}
	.realisations-title {
		font-size: 1.4rem;
		letter-spacing: 0.05em;
		margin-bottom: 1.75rem;
	}
	.realisations-timeline::before {
		left: 20px;
		width: 2px;
	}
	.timeline-date-badge {
		left: 20px;
		transform: none;
		padding: 6px 14px;
		font-size: 0.85rem;
	}
	.timeline-card {
		width: 100%;
		margin-left: 0 !important;
		margin-right: 0 !important;
		padding-left: 50px !important;
		padding-right: 12px !important;
		margin-top: 24px;
	}
	.timeline-card-inner:hover {
		transform: none;
	}
	.timeline-card-image {
		height: 180px;
	}
	.timeline-gallery {
		min-height: 180px;
		gap: 6px;
	}
	.timeline-card-content {
		padding: 1.15rem 1.25rem 1.35rem;
	}
	.timeline-card-title {
		font-size: 1.1rem;
		line-height: 1.35;
	}
	.timeline-card-desc {
		font-size: 0.92rem;
		line-height: 1.7;
	}
	.realisations-back-wrap {
		margin-top: 2rem;
	}
	.realisations-back-link {
		font-size: 0.9rem;
		padding: 0.6rem 1.1rem;
	}
}
</style>

<section id="domain-content" class="section section-realisations">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="domain-content-box realisations-content-box">
          <p class="lead realisations-lead"><?php echo htmlspecialchars($content); ?></p>

          <!-- Section Nos Réalisations : chronologie visuelle -->
          <h2 class="realisations-title">Nos Réalisations</h2>
          <div class="realisations-timeline">
            <?php foreach ($realisations as $i => $r): ?>
            <div class="timeline-item <?php echo $i % 2 === 0 ? 'timeline-left' : 'timeline-right'; ?>">
              <div class="timeline-card">
                <div class="timeline-date-badge"><?php echo htmlspecialchars($r['annee']); ?></div>
                <div class="timeline-card-inner">
                  <div class="timeline-card-image">
                    <?php
                    // Filter gallery images that actually exist
                    $validGallery = [];
                    if (isset($r['images']) && is_array($r['images'])) {
                        foreach ($r['images'] as $imgItem) {
                            $src = is_array($imgItem) ? $imgItem['src'] : $imgItem;
                            if (file_exists(__DIR__ . '/' . $src)) {
                                $validGallery[] = $imgItem;
                            }
                        }
                    }
                    
                    if (!empty($validGallery)): ?>
                    <div class="timeline-gallery" role="list">
                      <?php foreach ($validGallery as $idx => $img): ?>
                        <?php
                        $imgSrc = is_array($img) ? $img['src'] : $img;
                        $imgAlt = is_array($img) && isset($img['alt']) ? $img['alt'] : $r['titre'] . ' — photo ' . ($idx + 1);
                        ?>
                        <div class="timeline-gallery-item" role="button" tabindex="0" data-index="<?php echo $idx; ?>" data-src="<?php echo htmlspecialchars($imgSrc); ?>" title="Voir en grand">
                          <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="<?php echo htmlspecialchars($imgAlt); ?>" loading="lazy">
                          <span class="timeline-gallery-zoom"><i class="fas fa-search-plus"></i><span class="timeline-gallery-zoom-text">Voir</span></span>
                        </div>
                      <?php endforeach; ?>
                    </div>
                    <?php elseif (file_exists(__DIR__ . '/' . $r['image'])): ?>
                    <img src="<?php echo htmlspecialchars($r['image']); ?>" alt="<?php echo htmlspecialchars($r['titre']); ?>">
                    <?php else: ?>
                    <div class="timeline-image-placeholder">
                      <span>Image à venir</span>
                      <small><?php echo htmlspecialchars($r['image']); ?></small>
                    </div>
                    <?php endif; ?>
                  </div>
                  <div class="timeline-card-content">
                    <div class="timeline-meta"><?php echo htmlspecialchars($r['date']); ?> · <?php echo htmlspecialchars($r['lieu']); ?></div>
                    <h3 class="timeline-card-title"><?php echo htmlspecialchars($r['titre']); ?></h3>
                    <p class="timeline-card-desc"><?php echo nl2br(htmlspecialchars($r['description'])); ?></p>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>

          <p class="realisations-back-wrap"><a href="about.php" class="realisations-back-link"><i class="fas fa-arrow-left"></i> Retour à À propos</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Lightbox galerie orphelinat C.O.C -->
<div id="timelineLightbox" class="timeline-lightbox" aria-hidden="true">
  <div class="timeline-lightbox-header">
    <span class="timeline-lightbox-title">Photo <span id="timelineLightboxCurrent">1</span> / <span id="timelineLightboxTotal">1</span></span>
    <button type="button" class="timeline-lightbox-close" onclick="closeTimelineLightbox()" aria-label="Fermer"><i class="fas fa-times"></i></button>
  </div>
  <div class="timeline-lightbox-content">
    <button type="button" class="timeline-lightbox-nav timeline-lightbox-prev" onclick="navigateTimelineLightbox(-1)" aria-label="Photo précédente"><i class="fas fa-chevron-left"></i></button>
    <img id="timelineLightboxImg" src="" alt="" class="timeline-lightbox-img">
    <button type="button" class="timeline-lightbox-nav timeline-lightbox-next" onclick="navigateTimelineLightbox(1)" aria-label="Photo suivante"><i class="fas fa-chevron-right"></i></button>
  </div>
</div>

<script>
(function() {
  var timelineLightbox = document.getElementById('timelineLightbox');
  var timelineLightboxImg = document.getElementById('timelineLightboxImg');
  var items = document.querySelectorAll('.timeline-gallery-item');
  var currentIdx = 0;
  var imageList = [];

  function getGalleryImageList(galleryEl) {
    var list = [];
    if (!galleryEl) return list;
    var galleryItems = galleryEl.querySelectorAll('.timeline-gallery-item');
    galleryItems.forEach(function(it) {
      var src = it.getAttribute('data-src');
      if (src) list.push(src);
    });
    return list;
  }

  function openTimelineLightbox(el) {
    if (!el || !el.classList.contains('timeline-gallery-item')) return;
    var gallery = el.closest('.timeline-gallery');
    imageList = getGalleryImageList(gallery);
    if (imageList.length === 0) return;
    currentIdx = parseInt(el.getAttribute('data-index'), 10) || 0;
    if (currentIdx >= imageList.length) currentIdx = 0;
    timelineLightbox.setAttribute('aria-hidden', 'false');
    timelineLightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
    updateTimelineLightboxLabels();
    timelineLightboxImg.src = imageList[currentIdx];
    timelineLightboxImg.alt = 'Photo ' + (currentIdx + 1);
  }

  window.closeTimelineLightbox = function() {
    timelineLightbox.setAttribute('aria-hidden', 'true');
    timelineLightbox.classList.remove('active');
    document.body.style.overflow = '';
  };

  window.navigateTimelineLightbox = function(direction) {
    if (imageList.length === 0) return;
    currentIdx = (currentIdx + direction + imageList.length) % imageList.length;
    updateTimelineLightboxLabels();
    timelineLightboxImg.src = imageList[currentIdx];
    timelineLightboxImg.alt = 'Photo ' + (currentIdx + 1);
  };

  function updateTimelineLightboxLabels() {
    var curEl = document.getElementById('timelineLightboxCurrent');
    var totEl = document.getElementById('timelineLightboxTotal');
    if (curEl) curEl.textContent = currentIdx + 1;
    if (totEl) totEl.textContent = imageList.length;
  }

  items.forEach(function(it) {
    it.addEventListener('click', function() { openTimelineLightbox(it); });
    it.addEventListener('keydown', function(e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openTimelineLightbox(it); }
    });
  });

  timelineLightbox.addEventListener('click', function(e) {
    if (e.target === timelineLightbox) closeTimelineLightbox();
  });

  document.addEventListener('keydown', function(e) {
    if (!timelineLightbox.classList.contains('active')) return;
    if (e.key === 'Escape') closeTimelineLightbox();
    if (e.key === 'ArrowLeft') navigateTimelineLightbox(-1);
    if (e.key === 'ArrowRight') navigateTimelineLightbox(1);
  });
})();
</script>

<?php require './utils/footer.php'; ?>
