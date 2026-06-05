<?php
require './utils/header.php';
require_once __DIR__ . '/utils/content-store.php';
// Base de données optionnelle (peut être absente en local)
if (file_exists(__DIR__ . '/config/database.php')) {
    require_once __DIR__ . '/config/database.php';
}

$videoId = (int) ($_GET['video_id'] ?? 0);
$videoPath = '';
$videoName = 'Vidéo';
$videoDescription = '';
$videoDuration = '--:--';
$videoCategory = 'Vidéos';
$relatedVideos = [];
$usingDatabaseVideo = false;

if ($videoId > 0) {
    try {
        $video = db_query('SELECT * FROM videos WHERE id = :id AND is_published = 1', ['id' => $videoId])->fetch();
        if ($video) {
            $usingDatabaseVideo = true;
            $videoPath = $video['video_path'];
            $videoName = $video['title'];
            $videoDescription = $video['description'] ?? '';
            $videoDuration = $video['duration'] ?: '--:--';
            $videoCategory = $video['category'] ?? 'Vidéos';

            $relatedVideos = db_query(
                'SELECT id, title, duration, category 
                 FROM videos 
                 WHERE is_published = 1 AND id <> :id AND (category = :category OR :category IS NULL)
                 ORDER BY display_order DESC, created_at DESC
                 LIMIT 6',
                [
                    'id' => $videoId,
                    'category' => $video['category'],
                ]
            )->fetchAll();
        }
    } catch (Throwable $e) {
        $usingDatabaseVideo = false;
    }
}

if (!$usingDatabaseVideo) {
    $videoPath = urldecode($_GET['video'] ?? '');

$allowed_videos = [
    'Teaser TMK.mp4' => [
        'title' => 'Teaser TMK',
        'description' => 'Découvrez le teaser TMK.',
        'duration' => '--:--',
        'category' => 'Vidéo'
    ],
    'Teaser The Miracle Kingdom.mp4' => [
        'title' => 'Teaser The Miracle Kingdom',
        'description' => 'Découvrez le teaser de The Miracle Kingdom.',
        'duration' => '--:--',
        'category' => 'Vidéo'
    ],
    '1.mp4' => [
        'title' => 'Réalisation Vidéo 1',
        'description' => 'Découvrez cette réalisation vidéo',
        'duration' => '--:--',
        'category' => 'Vidéo'
    ],
    '2.mp4' => [
        'title' => 'Réalisation Vidéo 2',
        'description' => 'Découvrez cette réalisation vidéo',
        'duration' => '--:--',
        'category' => 'Vidéo'
    ],
    'videos/video.mp4' => [
        'title' => 'Nos Réalisations TMK',
        'description' => 'Découvrez un aperçu complet de nos réalisations et de l\'impact positif que nous avons sur les communautés.',
        'duration' => '10:15',
        'category' => 'Réalisations TMK'
    ],
    'images/miracle_kingdom/1.mp4' => [
        'title' => 'Miracle Kingdom - Partie 1',
        'description' => 'Découvrez la première partie de notre projet Miracle Kingdom, un aperçu inspirant de nos réalisations.',
        'duration' => '5:30',
        'category' => 'Projets Humanitaires'
    ],
    'images/miracle_kingdom/2.mp4' => [
        'title' => 'Miracle Kingdom - Partie 2',
        'description' => 'La suite de notre aventure au Miracle Kingdom, montrant l\'impact de nos actions sur la communauté.',
        'duration' => '7:45',
        'category' => 'Projets Humanitaires'
    ],
    'images/miracle_kingdom/3.mp4' => [
        'title' => 'Miracle Kingdom - Partie 3',
        'description' => 'Le chapitre final de notre série Miracle Kingdom, célébrant les résultats obtenus ensemble.',
        'duration' => '6:20',
        'category' => 'Projets Humanitaires'
    ]
];

// Autoriser également les vidéos ajoutées depuis l'administration (/content/videos.json)
$adminVideos = tmk_content('videos', tmk_defaults('videos'))['videos'] ?? [];
foreach ($adminVideos as $av) {
    if (!empty($av['video_path'])) {
        $allowed_videos[$av['video_path']] = [
            'title' => $av['title'] ?? 'Vidéo',
            'description' => $av['description'] ?? '',
            'duration' => '--:--',
            'category' => $av['category'] ?? 'Vidéo',
        ];
    }
}

if (!array_key_exists($videoPath, $allowed_videos) || !file_exists($videoPath)) {
    die("<h2 style='text-align:center; color:#d4202c; margin-top:100px;'>Vidéo non trouvée ou inaccessible.</h2>");
}

$videoData = $allowed_videos[$videoPath];
$videoName = $videoData['title'];
$videoDescription = $videoData['description'];
$videoDuration = $videoData['duration'];
$videoCategory = $videoData['category'];

    $relatedVideos = array_filter($allowed_videos, function ($data) use ($videoCategory) {
    return $data['category'] === $videoCategory;
});
}
?>

<!-- Page Header : bannière TMK (comme sur les autres pages) -->
<section id="page-header" class="parallax page-header--logo">
  <div class="page-header-logo">
    <img src="images/tmk-header.png" alt="TMK - The Miracle Kingdom" class="tmk-logo-img">
  </div>
  <div class="overlay"></div>
</section>

<main class="main-content">
    <div class="container">
        <!-- Lecteur vidéo principal -->
        <div class="video-section">
            <div class="video-player-container">
                <div class="video-wrapper">
                    <video 
                        id="mainVideo" 
                        class="main-video"
                        poster="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAwIiBoZWlnaHQ9IjQ1MCIgdmlld0JveD0iMCAwIDgwMCA0NTAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI4MDAiIGhlaWdodD0iNDUwIiBmaWxsPSJsaW5lYXItZ3JhZGllbnQoMTM1ZGVnLCAjMWEyMDJjLCAjMmQzNzQ4KSIvPgo8Y2lyY2xlIGN4PSI0MDAiIGN5PSIyMjUiIHI9IjUwIiBmaWxsPSJyZ2JhKDI1NSwgMjU1LCAyNTUsIDAuMSkiLz4KPHN2ZyB4PSIzNzUiIHk9IjIwMCIgd2lkdGg9IjUwIiBoZWlnaHQ9IjUwIiB2aWV3Qm94PSIwIDAgMjQgMjQiIGZpbGw9IndoaXRlIj4KPHA+PHBhdGggZD0iTTggNXYxNGwxMS03eiIvPjwvcD4KPC9zdmc+Cjwvc3ZnPg=="
                        preload="metadata">
                        <source src="<?= htmlspecialchars($videoPath) ?>" type="video/mp4">
                        Votre navigateur ne supporte pas les vidéos HTML5.
                    </video>
                    
                    <!-- Contrôles personnalisés -->
                    <div class="video-controls" id="videoControls">
                        <div class="progress-container">
                            <div class="progress-bar">
                                <div class="progress-filled" id="progressFilled"></div>
                                <div class="progress-handle" id="progressHandle"></div>
                            </div>
                            <div class="time-display">
                                <span id="currentTime">00:00</span> / <span id="totalTime">00:00</span>
                            </div>
                        </div>
                        
                        <div class="controls-bar">
                            <div class="controls-left">
                                <button class="control-btn" id="playPauseBtn">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button class="control-btn" id="muteBtn">
                                    <i class="fas fa-volume-up"></i>
                                </button>
                                <div class="volume-container">
                                    <input type="range" class="volume-slider" id="volumeSlider" min="0" max="1" step="0.1" value="1">
                                </div>
                            </div>
                            
                            <div class="controls-right">
                                <button class="control-btn" id="speedBtn" title="Vitesse de lecture">
                                    <span>1x</span>
                                </button>
                                <button class="control-btn" id="pipBtn" title="Picture-in-Picture">
                                    <i class="fas fa-external-link-alt"></i>
                                </button>
                                <button class="control-btn" id="fullscreenBtn">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Overlay de chargement -->
                    <div class="video-loader" id="videoLoader">
                        <div class="loader-spinner"></div>
                        <p>Chargement de la vidéo...</p>
                    </div>
                    
                    <!-- Overlay de pause -->
                    <div class="video-overlay" id="videoOverlay">
                        <button class="play-overlay-btn" id="playOverlayBtn">
                            <i class="fas fa-play"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Informations vidéo -->
            <div class="video-info">
                <div class="video-header">
                    <h2 class="video-title"><?= htmlspecialchars($videoName) ?></h2>
                    <div class="video-actions">
                        <button class="action-btn" onclick="shareVideo()" title="Partager">
                            <i class="fas fa-share-alt"></i>
                            <span>Partager</span>
                        </button>
                        <button class="action-btn" onclick="downloadVideo()" title="Télécharger">
                            <i class="fas fa-download"></i>
                            <span>Télécharger</span>
                        </button>
                    </div>
                </div>
                
                <div class="video-details" id="video-details">
                    <p class="video-description"><?= htmlspecialchars($videoDescription) ?></p>
                    <div class="video-meta">
                        <span class="meta-badge">
                            <i class="fas fa-tag"></i>
                            <?= htmlspecialchars($videoCategory) ?>
                        </span>
                        <span class="meta-badge">
                            <i class="fas fa-clock"></i>
                            Durée: <?= htmlspecialchars($videoDuration) ?>
                        </span>
                        <span class="meta-badge">
                            <i class="fas fa-calendar"></i>
                            <?= date('Y') ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navigation -->
        <div class="navigation-section">
            <a href="realisationsvideo.php" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                <span>Retour aux réalisations</span>
            </a>
        </div>
    </div>
</main>

<style>
    :root {
        --primary-color: #d4202c;
        --primary-light: #ff4757;
        --secondary-color: #003366;
        --accent-color: #2c5282;
        --light-color: #f8f9fa;
        --text-color: #2d3748;
        --text-light: #718096;
        --white: #ffffff;
        --black: #000000;
        --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
        --shadow-light: 0 4px 15px rgba(0, 0, 0, 0.08);
        --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        --gradient-dark: linear-gradient(135deg, #1a202c, #2d3748);
        --transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        --border-radius: 16px;
        --border-radius-lg: 24px;
    }

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        line-height: 1.6;
        color: var(--text-color);
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Hero Section */
    .hero-section {
        position: relative;
        height: 60vh;
        background: var(--gradient-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 30% 20%, rgba(212, 32, 44, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 70% 80%, rgba(44, 82, 130, 0.15) 0%, transparent 50%);
    }

    .hero-particles {
        position: absolute;
        inset: 0;
        background-image: 
            radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
            radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        background-size: 60px 60px, 100px 100px;
        animation: float 25s infinite linear;
    }

    @keyframes float {
        0% { transform: translate(0, 0); }
        100% { transform: translate(-60px, -60px); }
    }

    .hero-content {
        text-align: center;
        z-index: 2;
        color: white;
        max-width: 800px;
        padding: 0 20px;
    }

    .hero-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .hero-title {
        font-size: clamp(2rem, 4vw, 3.5rem);
        font-weight: 800;
        margin-bottom: 20px;
        background: linear-gradient(135deg, #ffffff, #e2e8f0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1.1;
    }

    .hero-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 30px;
        font-weight: 400;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-meta {
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .scroll-indicator {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2;
        cursor: pointer;
    }

    .scroll-arrow {
        width: 30px;
        height: 30px;
        border: 2px solid white;
        border-top: none;
        border-left: none;
        transform: rotate(45deg);
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0) rotate(45deg); }
        40% { transform: translateY(-10px) rotate(45deg); }
        60% { transform: translateY(-5px) rotate(45deg); }
    }

    /* Section principale */
    .main-content {
        padding: 60px 0;
        background: var(--light-color);
    }

    .video-section {
        background: white;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow);
        overflow: hidden;
        margin-bottom: 60px;
    }

    /* Lecteur vidéo */
    .video-player-container {
        position: relative;
        background: #000;
    }

    .video-wrapper {
        position: relative;
        width: 100%;
        padding-bottom: 56.25%; /* Ratio 16:9 */
        height: 0;
        overflow: hidden;
    }

    .main-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #000;
    }

    /* Contrôles vidéo personnalisés */
    .video-controls {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
        padding: 20px;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 10;
    }

    .video-wrapper:hover .video-controls,
    .video-controls.visible {
        opacity: 1;
    }

    .progress-container {
        margin-bottom: 15px;
    }

    .progress-bar {
        position: relative;
        height: 6px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
        cursor: pointer;
        margin-bottom: 10px;
    }

    .progress-filled {
        height: 100%;
        background: var(--primary-color);
        border-radius: 3px;
        width: 0%;
        transition: width 0.1s ease;
    }

    .progress-handle {
        position: absolute;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 16px;
        height: 16px;
        background: var(--primary-color);
        border-radius: 50%;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.3s ease;
        left: 0%;
    }

    .progress-bar:hover .progress-handle {
        opacity: 1;
    }

    .time-display {
        color: white;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .controls-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .controls-left,
    .controls-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .control-btn {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        padding: 8px;
        border-radius: 6px;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
    }

    .control-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.1);
    }

    .control-btn i {
        font-size: 1.1rem;
    }

    .volume-container {
        display: flex;
        align-items: center;
    }

    .volume-slider {
        width: 80px;
        height: 4px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 2px;
        outline: none;
        cursor: pointer;
    }

    .volume-slider::-webkit-slider-thumb {
        appearance: none;
        width: 14px;
        height: 14px;
        background: var(--primary-color);
        border-radius: 50%;
        cursor: pointer;
    }

    /* Overlays */
    .video-loader {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        z-index: 5;
    }

    .loader-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        border-top: 4px solid var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 20px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .video-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.3);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 8;
    }

    .video-overlay.visible {
        opacity: 1;
    }

    .play-overlay-btn {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 50%;
        color: var(--primary-color);
        font-size: 2rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .play-overlay-btn:hover {
        background: white;
        transform: scale(1.1);
    }

    /* Informations vidéo */
    .video-info {
        padding: 30px;
    }

    .video-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        gap: 20px;
    }

    .video-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-color);
        margin: 0;
        flex: 1;
    }

    .video-actions {
        display: flex;
        gap: 10px;
        flex-shrink: 0;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background: var(--light-color);
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        color: var(--text-color);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
        cursor: pointer;
        font-size: 0.9rem;
    }

    .action-btn:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-light);
    }

    .video-details {
        border-top: 1px solid #e2e8f0;
        padding-top: 20px;
    }

    .video-description {
        font-size: 1rem;
        color: var(--text-light);
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .video-meta {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .meta-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        background: var(--light-color);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        color: var(--text-light);
        font-weight: 500;
    }

    .meta-badge i {
        color: var(--primary-color);
    }

    /* Vidéos similaires */
    .related-videos {
        background: white;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow);
        padding: 40px;
        margin-bottom: 40px;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title:before {
        content: '';
        width: 4px;
        height: 30px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
    }

    .related-item {
        display: block;
        background: var(--light-color);
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: var(--transition);
        text-decoration: none;
        color: inherit;
        box-shadow: var(--shadow-light);
    }

    .related-item:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow);
    }

    .related-thumbnail {
        position: relative;
        height: 160px;
        background: var(--gradient-dark);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .thumbnail-placeholder {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .duration-badge {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .related-info {
        padding: 20px;
    }

    .related-info h4 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 8px 0;
        color: var(--text-color);
    }

    .related-info p {
        font-size: 0.9rem;
        color: var(--text-light);
        margin: 0;
    }

    /* Navigation */
    .navigation-section {
        text-align: center;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 15px 30px;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: var(--border-radius);
        color: var(--text-color);
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: var(--transition);
        box-shadow: var(--shadow-light);
    }

    .btn-back:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        transform: translateY(-3px);
        box-shadow: var(--shadow);
    }

    .btn-back i {
        font-size: 1.1rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-section {
            height: 50vh;
        }
        
        .hero-meta {
            flex-direction: column;
            gap: 15px;
        }
        
        .video-header {
            flex-direction: column;
            align-items: stretch;
        }
        
        .video-actions {
            justify-content: center;
        }
        
        .action-btn {
            flex: 1;
            justify-content: center;
        }
        
        .video-meta {
            justify-content: center;
        }
        
        .related-grid {
            grid-template-columns: 1fr;
        }
        
        .controls-bar {
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .volume-container {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .hero-title {
            font-size: 1.8rem;
        }
        
        .video-info {
            padding: 20px;
        }
        
        .related-videos {
            padding: 25px;
        }
        
        .btn-back {
            padding: 12px 24px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const video = document.getElementById('mainVideo');
        const playPauseBtn = document.getElementById('playPauseBtn');
        const playOverlayBtn = document.getElementById('playOverlayBtn');
        const muteBtn = document.getElementById('muteBtn');
        const volumeSlider = document.getElementById('volumeSlider');
        const progressFilled = document.getElementById('progressFilled');
        const progressHandle = document.getElementById('progressHandle');
        const progressBar = document.querySelector('.progress-bar');
        const currentTimeEl = document.getElementById('currentTime');
        const totalTimeEl = document.getElementById('totalTime');
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        const speedBtn = document.getElementById('speedBtn');
        const pipBtn = document.getElementById('pipBtn');
        const videoControls = document.getElementById('videoControls');
        const videoOverlay = document.getElementById('videoOverlay');
        const videoLoader = document.getElementById('videoLoader');
        
        let controlsTimeout;
        let isPlaying = false;
        let isMuted = false;
        let currentSpeed = 1;
        const speeds = [0.5, 0.75, 1, 1.25, 1.5, 2];
        let speedIndex = 2; // 1x par défaut

        // Initialisation
        init();

        function init() {
            video.addEventListener('loadstart', showLoader);
            video.addEventListener('canplay', hideLoader);
            video.addEventListener('loadedmetadata', updateTotalTime);
            video.addEventListener('timeupdate', updateProgress);
            video.addEventListener('ended', onVideoEnded);
            video.addEventListener('waiting', showLoader);
            video.addEventListener('playing', hideLoader);
            
            // Gestion des contrôles
            setupControls();
            
            // Masquer les contrôles natifs
            video.controls = false;
            
            // Afficher l'overlay de démarrage
            videoOverlay.classList.add('visible');
        }

        function setupControls() {
            // Play/Pause
            playPauseBtn.addEventListener('click', togglePlayPause);
            playOverlayBtn.addEventListener('click', togglePlayPause);
            video.addEventListener('click', togglePlayPause);
            
            // Volume
            muteBtn.addEventListener('click', toggleMute);
            volumeSlider.addEventListener('input', updateVolume);
            
            // Barre de progression
            progressBar.addEventListener('click', seek);
            progressBar.addEventListener('mousedown', startDrag);
            
            // Plein écran
            fullscreenBtn.addEventListener('click', toggleFullscreen);
            
            // Vitesse
            speedBtn.addEventListener('click', changeSpeed);
            
            // Picture-in-Picture
            if ('pictureInPictureEnabled' in document) {
                pipBtn.addEventListener('click', togglePiP);
            } else {
                pipBtn.style.display = 'none';
            }
            
            // Gestion de l'affichage des contrôles
            const videoWrapper = document.querySelector('.video-wrapper');
            videoWrapper.addEventListener('mouseenter', showControls);
            videoWrapper.addEventListener('mouseleave', hideControlsDelayed);
            videoWrapper.addEventListener('mousemove', showControls);
            
            // Raccourcis clavier
            document.addEventListener('keydown', handleKeyboard);
        }

        function showLoader() {
            videoLoader.style.display = 'flex';
        }

        function hideLoader() {
            videoLoader.style.display = 'none';
        }

        function togglePlayPause() {
            if (video.paused) {
                video.play();
                isPlaying = true;
                playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
                playOverlayBtn.innerHTML = '<i class="fas fa-pause"></i>';
                videoOverlay.classList.remove('visible');
            } else {
                video.pause();
                isPlaying = false;
                playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
                playOverlayBtn.innerHTML = '<i class="fas fa-play"></i>';
                videoOverlay.classList.add('visible');
            }
        }

        function toggleMute() {
            if (video.muted) {
                video.muted = false;
                isMuted = false;
                muteBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
                volumeSlider.value = video.volume;
            } else {
                video.muted = true;
                isMuted = true;
                muteBtn.innerHTML = '<i class="fas fa-volume-mute"></i>';
            }
        }

        function updateVolume() {
            const volume = volumeSlider.value;
            video.volume = volume;
            video.muted = false;
            isMuted = false;
            
            if (volume == 0) {
                muteBtn.innerHTML = '<i class="fas fa-volume-mute"></i>';
            } else if (volume < 0.5) {
                muteBtn.innerHTML = '<i class="fas fa-volume-down"></i>';
            } else {
                muteBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
            }
        }

        function updateTotalTime() {
            totalTimeEl.textContent = formatTime(video.duration);
        }

        function updateProgress() {
            const percentage = (video.currentTime / video.duration) * 100;
            progressFilled.style.width = percentage + '%';
            progressHandle.style.left = percentage + '%';
            currentTimeEl.textContent = formatTime(video.currentTime);
        }

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        function seek(e) {
            const rect = progressBar.getBoundingClientRect();
            const percentage = (e.clientX - rect.left) / rect.width;
            video.currentTime = percentage * video.duration;
        }

        function startDrag(e) {
            e.preventDefault();
            
            function onMouseMove(e) {
                const rect = progressBar.getBoundingClientRect();
                const percentage = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
                video.currentTime = percentage * video.duration;
            }
            
            function onMouseUp() {
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
            }
            
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        }

        function toggleFullscreen() {
            const videoWrapper = document.querySelector('.video-wrapper');
            
            if (!document.fullscreenElement) {
                videoWrapper.requestFullscreen().then(() => {
                    fullscreenBtn.innerHTML = '<i class="fas fa-compress"></i>';
                });
            } else {
                document.exitFullscreen().then(() => {
                    fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
                });
            }
        }

        function changeSpeed() {
            speedIndex = (speedIndex + 1) % speeds.length;
            currentSpeed = speeds[speedIndex];
            video.playbackRate = currentSpeed;
            speedBtn.innerHTML = `<span>${currentSpeed}x</span>`;
        }

        function togglePiP() {
            if (document.pictureInPictureElement) {
                document.exitPictureInPicture();
            } else {
                video.requestPictureInPicture();
            }
        }

        function showControls() {
            videoControls.classList.add('visible');
            clearTimeout(controlsTimeout);
        }

        function hideControlsDelayed() {
            controlsTimeout = setTimeout(() => {
                if (isPlaying) {
                    videoControls.classList.remove('visible');
                }
            }, 3000);
        }

        function onVideoEnded() {
            isPlaying = false;
            playPauseBtn.innerHTML = '<i class="fas fa-replay"></i>';
            playOverlayBtn.innerHTML = '<i class="fas fa-replay"></i>';
            videoOverlay.classList.add('visible');
        }

        function handleKeyboard(e) {
            // Vérifier si l'utilisateur tape dans un champ de saisie
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
                return;
            }

            switch(e.code) {
                case 'Space':
                    e.preventDefault();
                    togglePlayPause();
                    break;
                case 'KeyM':
                    toggleMute();
                    break;
                case 'KeyF':
                    toggleFullscreen();
                    break;
                case 'ArrowLeft':
                    video.currentTime = Math.max(0, video.currentTime - 10);
                    break;
                case 'ArrowRight':
                    video.currentTime = Math.min(video.duration, video.currentTime + 10);
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    video.volume = Math.min(1, video.volume + 0.1);
                    volumeSlider.value = video.volume;
                    updateVolume();
                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    video.volume = Math.max(0, video.volume - 0.1);
                    volumeSlider.value = video.volume;
                    updateVolume();
                    break;
                case 'Digit0':
                case 'Numpad0':
                    video.currentTime = 0;
                    break;
                case 'Digit1':
                case 'Numpad1':
                    video.currentTime = video.duration * 0.1;
                    break;
                case 'Digit2':
                case 'Numpad2':
                    video.currentTime = video.duration * 0.2;
                    break;
                case 'Digit3':
                case 'Numpad3':
                    video.currentTime = video.duration * 0.3;
                    break;
                case 'Digit4':
                case 'Numpad4':
                    video.currentTime = video.duration * 0.4;
                    break;
                case 'Digit5':
                case 'Numpad5':
                    video.currentTime = video.duration * 0.5;
                    break;
                case 'Digit6':
                case 'Numpad6':
                    video.currentTime = video.duration * 0.6;
                    break;
                case 'Digit7':
                case 'Numpad7':
                    video.currentTime = video.duration * 0.7;
                    break;
                case 'Digit8':
                case 'Numpad8':
                    video.currentTime = video.duration * 0.8;
                    break;
                case 'Digit9':
                case 'Numpad9':
                    video.currentTime = video.duration * 0.9;
                    break;
            }
        }

        // Gestion tactile pour mobile
        let touchStartX = 0;
        let touchStartTime = 0;

        video.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
            touchStartTime = video.currentTime;
        });

        video.addEventListener('touchmove', (e) => {
            e.preventDefault();
            const touchCurrentX = e.touches[0].clientX;
            const diff = touchCurrentX - touchStartX;
            const timeDiff = (diff / window.innerWidth) * 30; // 30 secondes max
            video.currentTime = Math.max(0, Math.min(video.duration, touchStartTime + timeDiff));
        });

        // Gestes de double tap pour play/pause
        let lastTapTime = 0;
        video.addEventListener('touchend', (e) => {
            const currentTime = new Date().getTime();
            const tapLength = currentTime - lastTapTime;
            
            if (tapLength < 500 && tapLength > 0) {
                togglePlayPause();
            }
            
            lastTapTime = currentTime;
        });

        // Affichage de notifications temporaires
        function showNotification(message) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(0, 0, 0, 0.8);
                color: white;
                padding: 15px 25px;
                border-radius: 25px;
                font-size: 1.1rem;
                font-weight: 600;
                z-index: 1000;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.3s ease;
            `;
            notification.textContent = message;
            
            document.querySelector('.video-wrapper').appendChild(notification);
            
            // Animation d'apparition
            setTimeout(() => notification.style.opacity = '1', 10);
            
            // Suppression après 2 secondes
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 2000);
        }

        // Notifications pour les actions
        const originalTogglePlayPause = togglePlayPause;
        togglePlayPause = function() {
            originalTogglePlayPause();
            showNotification(isPlaying ? 'Lecture' : 'Pause');
        };

        const originalToggleMute = toggleMute;
        toggleMute = function() {
            originalToggleMute();
            showNotification(isMuted ? 'Audio activé' : 'Audio coupé');
        };

        const originalChangeSpeed = changeSpeed;
        changeSpeed = function() {
            originalChangeSpeed();
            showNotification(`Vitesse: ${currentSpeed}x`);
        };
    });

    // Fonctions globales pour les boutons
    function shareVideo() {
        const videoTitle = document.querySelector('.video-title').textContent;
        const videoUrl = window.location.href;
        
        if (navigator.share) {
            navigator.share({
                title: videoTitle,
                text: `Regardez cette vidéo: ${videoTitle}`,
                url: videoUrl
            }).catch(console.error);
        } else {
            // Fallback: copier l'URL
            navigator.clipboard.writeText(videoUrl).then(() => {
                alert('Lien copié dans le presse-papiers!');
            }).catch(() => {
                // Fallback pour les navigateurs plus anciens
                const textArea = document.createElement('textarea');
                textArea.value = videoUrl;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                alert('Lien copié dans le presse-papiers!');
            });
        }
    }

    function downloadVideo() {
        const video = document.getElementById('mainVideo');
        const videoSrc = video.querySelector('source').src;
        const videoTitle = document.querySelector('.video-title').textContent;
        
        const link = document.createElement('a');
        link.href = videoSrc;
        link.download = `${videoTitle}.mp4`;
        link.style.display = 'none';
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Scroll smooth pour l'indicateur
    document.querySelector('.scroll-indicator')?.addEventListener('click', () => {
        document.querySelector('.main-content').scrollIntoView({
            behavior: 'smooth'
        });
    });

    // Animation des éléments au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observer les sections
    document.querySelectorAll('.video-section, .related-videos, .navigation-section').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(el);
    });

    // Gestion du redimensionnement
    window.addEventListener('resize', () => {
        // Réajuster les contrôles si nécessaire
        const videoControls = document.getElementById('videoControls');
        if (window.innerWidth < 768) {
            videoControls?.classList.add('mobile-controls');
        } else {
            videoControls?.classList.remove('mobile-controls');
        }
    });

    console.log('Lecteur vidéo amélioré chargé avec succès!');
</script>

<?php require './utils/footer.php'; ?>