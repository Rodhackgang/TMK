<?php
require './utils/header.php';
require_once __DIR__ . '/config/database.php';

$videos = [];
$dbError = false;

try {
    $videos = db_query(
        'SELECT * FROM videos WHERE is_published = 1 ORDER BY display_order DESC, created_at DESC'
    )->fetchAll();
} catch (Throwable $e) {
    $dbError = true;
}

$staticVideos = [
    [
        'id' => null,
        'video_path' => 'Teaser TMK.mp4',
        'preview_image' => '',
        'title' => 'Teaser TMK',
        'description' => 'Découvrez le teaser TMK.',
        'category' => 'Vidéo'
    ],
    [
        'id' => null,
        'video_path' => 'Teaser The Miracle Kingdom.mp4',
        'preview_image' => '',
        'title' => 'Teaser The Miracle Kingdom',
        'description' => 'Découvrez le teaser de The Miracle Kingdom.',
        'category' => 'Vidéo'
    ],
    [
        'id' => null,
        'video_path' => '1.mp4',
        'preview_image' => '',
        'title' => 'Réalisation Vidéo 1',
        'description' => 'Découvrez cette réalisation vidéo',
        'category' => 'Vidéo'
    ],
    [
        'id' => null,
        'video_path' => '2.mp4',
        'preview_image' => '',
        'title' => 'Réalisation Vidéo 2',
        'description' => 'Découvrez cette réalisation vidéo',
        'category' => 'Vidéo'
    ]
];

if (!is_array($videos)) {
    $videos = [];
}
$videos = array_merge($staticVideos, $videos);
?>

<!-- Page Header : logo TMK (The Miracle Kingdom) – image en fond plein écran -->
<section id="page-header" class="parallax page-header--logo">
  <div class="page-header-logo">
    <img src="images/tmk-header.png" alt="TMK - Nos Réalisations Vidéos" class="tmk-logo-img">
  </div>
  <div class="overlay"></div>
</section>

<!-- Section Vidéos -->
<section class="video-section" id="realisation">
    <div class="container">
        <h2 class="section-title">
            <i class="fas fa-video"></i>
            Nos Vidéos
        </h2>
        <div class="video-grid">
            <?php if ($dbError && empty($videos)): ?>
                <p class="text-center w-100 text-danger">Impossible de charger les vidéos. Vérifiez MySQL.</p>
            <?php elseif (empty($videos)): ?>
                <p class="text-center w-100 text-muted">Aucune vidéo publiée pour le moment.</p>
            <?php else: ?>
            <?php foreach ($videos as $video): ?>
                <?php
                $videoLink = !empty($video['id']) 
                    ? 'video.php?video_id=' . (int) $video['id']
                    : 'video.php?video=' . urlencode($video['video_path']);
                ?>
                <a href="<?= htmlspecialchars($videoLink); ?>" class="video-card-link">
                    <div class="video-item-preview">
                        <div class="video-image-container">
                            <!-- Logo TMK en overlay -->
                            <div class="tmk-logo-overlay">
                                <?php if (file_exists('images/tmk-logo.png')): ?>
                                    <img src="images/tmk-logo.png" alt="Logo TMK" class="tmk-logo">
                                <?php else: ?>
                                    <div class="tmk-logo-placeholder">TMK</div>
                                <?php endif; ?>
                            </div>
                            <!-- Image de fond de la vidéo -->
                            <div class="video-preview-image"
                                 style="background-image: url('<?= htmlspecialchars($video['preview_image'] ?: 'images/tmk-video-default.jpg'); ?>');">
                                <div class="play-overlay">
                                    <i class="fas fa-play-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="video-info">
                            <h3 class="video-title"><?= htmlspecialchars($video['title']) ?></h3>
                            <p class="video-description"><?= htmlspecialchars($video['description'] ?? '') ?></p>
                            <span class="video-type">
                                <i class="fas fa-play"></i>
                                <?= htmlspecialchars($video['category'] ?? 'Vidéo'); ?>
                            </span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    :root {
        --primary-color: #d4202c;   /* Rouge TMK */
        --secondary-color: #003366; /* Bleu foncé TMK */
        --accent-color: #f0a500;    /* Orange pour accents */
        --text-color: #333;
        --text-light: #666;
        --shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        --shadow-hover: 0 10px 25px rgba(0, 0, 0, 0.2);
        --border-radius: 12px;
    }

    /* Empêcher le défilement horizontal */
    body {
        overflow-x: hidden;
    }

    .video-section {
        margin-top: 0;
        padding: 20px;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }

    .albums-section {
        margin-top: 0;
        padding: 20px;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        width: 100%;
        box-sizing: border-box;
    }

    .section-title {
        text-align: center;
        font-size: 2.5rem;
        color: var(--secondary-color);
        margin-bottom: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .section-title i {
        color: var(--primary-color);
    }

    .album-grid, .video-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(min(100%, 300px), 1fr));
        gap: 30px;
        margin-top: 40px;
        width: 100%;
    }

    .album-card-link, .video-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
        width: 100%;
    }

    .album-card-preview, .video-item-preview {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 100%;
    }

    .album-card-preview:hover, .video-item-preview:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-hover);
    }

    .album-image-container, .video-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
        width: 100%;
    }

    .tmk-logo-overlay {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 3;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 50%;
        padding: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    }

    .tmk-logo {
        height: 120px;
        width: 120px;
        object-fit: contain;
    }

    .tmk-logo-placeholder {
        font-weight: bold;
        color: var(--primary-color);
        font-size: 12px;
    }

    .album-main-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .album-card-preview:hover .album-main-image {
        transform: scale(1.1);
    }

    .album-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
        color: #aaa;
        font-size: 50px;
        width: 100%;
        height: 100%;
    }

    .video-preview-image {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .play-overlay {
        font-size: 60px;
        color: rgba(255, 255, 255, 0.9);
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        transition: transform 0.3s ease;
    }

    .video-item-preview:hover .play-overlay {
        transform: scale(1.2);
    }

    .album-info, .video-info {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        width: 100%;
        box-sizing: border-box;
    }

    .album-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .album-type, .video-type {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .album-type {
        background: var(--primary-color);
        color: white;
    }

    .video-type {
        background: var(--accent-color);
        color: white;
    }

    .album-year {
        background: var(--accent-color);
        color: white;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: bold;
    }

    .album-title, .video-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: var(--secondary-color);
        margin-bottom: 15px;
        line-height: 1.3;
        word-wrap: break-word;
    }

    .album-description, .video-description {
        color: var(--text-light);
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 20px;
        flex-grow: 1;
        word-wrap: break-word;
    }

    .album-stats {
        margin-top: auto;
    }

    .photo-count {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        background: linear-gradient(135deg, var(--secondary-color), #34495e);
        color: white;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: bold;
    }

    /* Responsive - Tablettes */
    @media (max-width: 992px) {
        .album-grid, .video-grid {
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr));
            gap: 25px;
        }
    }

    /* Responsive - Mobiles */
    @media (max-width: 768px) {
        .video-section, .albums-section {
            margin-top: 0;
            padding: 15px;
        }

        .container {
            padding: 0 10px;
        }

        .section-title {
            font-size: 1.8rem;
            gap: 10px;
            margin-bottom: 30px;
        }

        .album-grid, .video-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .album-image-container, .video-image-container {
            height: 180px;
        }

        .album-info, .video-info {
            padding: 20px;
        }

        .album-header {
            gap: 8px;
        }

        .album-title, .video-title {
            font-size: 1.1rem;
        }

        .album-description, .video-description {
            font-size: 0.9rem;
        }

        .tmk-logo {
            height: 80px;
            width: 80px;
        }

        .tmk-logo-overlay {
            top: 10px;
            right: 10px;
            padding: 6px;
        }
    }

    /* Responsive - Très petits écrans */
    @media (max-width: 480px) {
        .video-section, .albums-section {
            margin-top: 0;
            padding: 10px;
        }

        .container {
            padding: 0 5px;
        }

        .section-title {
            font-size: 1.5rem;
            margin-bottom: 25px;
        }

        .album-grid, .video-grid {
            gap: 15px;
        }

        .album-image-container, .video-image-container {
            height: 160px;
        }

        .album-info, .video-info {
            padding: 15px;
        }

        .album-title, .video-title {
            font-size: 1rem;
        }

        .album-description, .video-description {
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .album-type, .video-type,
        .album-year {
            font-size: 0.75rem;
            padding: 4px 10px;
        }

        .photo-count {
            font-size: 0.85rem;
            padding: 6px 12px;
        }

        .play-overlay {
            font-size: 50px;
        }
    }

    /* Fix pour les très très petits écrans */
    @media (max-width: 320px) {
        .section-title {
            font-size: 1.3rem;
        }

        .album-image-container, .video-image-container {
            height: 140px;
        }

        .album-info, .video-info {
            padding: 12px;
        }
    }
</style>

<?php require './utils/footer.php'; ?>