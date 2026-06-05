<?php
require './utils/header.php';
require_once __DIR__ . '/config/database.php';

$albumTitle = 'Album Photos';
$images = [];
$albumId = (int) ($_GET['album_id'] ?? 0);
$folder = '';
$usingDatabase = false;

if ($albumId > 0) {
    try {
        $album = db_query('SELECT * FROM photo_albums WHERE id = :id AND is_published = 1', ['id' => $albumId])->fetch();
        if ($album) {
            $albumTitle = $album['title'];
            $usingDatabase = true;
            $photosStmt = db()->prepare('SELECT file_path FROM album_photos WHERE album_id = :album_id ORDER BY display_order DESC, id DESC');
            $photosStmt->execute(['album_id' => $albumId]);
            $images = array_map(static fn ($row) => $row['file_path'], $photosStmt->fetchAll());
        }
    } catch (Throwable $e) {
        $usingDatabase = false;
    }
}

if (!$usingDatabase) {
    $folder = urldecode($_GET['album'] ?? '');

$allowed_folders = [
    'images/centre_accueil_etat/',
    'images/orphelinat_coc_2021/',
    'images/hopital_mabanga_yolo_2023/',
    'images/orphelinat_marie_2024/',
    'images/complexe_scolaire_elohim_2024/'
];

    if (!in_array($folder, $allowed_folders, true) || !is_dir($folder)) {
    die("<h2 style='text-align:center; color:#d4202c;'>Album non trouvé ou inaccessible.</h2>");
}

$albumTitlesMap = [
    'CENTRE D\'ACCUEIL DE L\'ETAT' => 'images/centre_accueil_etat/',
    'ORPHELINAT C.O.C 2021' => 'images/orphelinat_coc_2021/',
    'HÔPITAL MABANGA YOLO MEDICAL 2021' => 'images/hopital_mabanga_yolo_2023/',
    'ORPHELINAT MISSION DE MARIE MÈRE DES PAUVRES 2024' => 'images/orphelinat_marie_2024/',
    'COMPLEXE SCOLAIRE ELOHIM 2024' => 'images/complexe_scolaire_elohim_2024/'
];

foreach ($albumTitlesMap as $title => $path) {
    if ($path === $folder) {
        $albumTitle = $title;
        break;
    }
    }

    $images = glob($folder . '*.jpg');
}
?>


<main id="realisation" class="main-content">
    <div class="container">
    

        <div class="photo-gallery" id="photoGallery">
            <?php
            if (empty($images)):
                echo "<div class='no-images'>
                        <div class='no-images-icon'>📷</div>
                        <h3>Aucune image disponible</h3>
                        <p>Cet album ne contient actuellement aucune photo.</p>
                      </div>";
            else:
                foreach ($images as $index => $img):
                    echo '
                    <div class="photo-item" 
                         data-index="' . $index . '"
                         data-src="' . htmlspecialchars($img) . '"
                         onclick="openLightbox(this)"
                         style="--delay: ' . ($index * 0.1) . 's">
                        <div class="card-wrapper">
                            <div class="image-overlay">
                                <div class="overlay-content">
                                    <i class="fas fa-expand-alt"></i>
                                    <span>Voir en grand</span>
                                </div>
                            </div>
                            <img src="' . htmlspecialchars($img) . '" 
                                 alt="Photo ' . ($index + 1) . '" 
                                 class="gallery-image"
                                 loading="lazy">
                            <div class="image-info">
                                <span class="image-number">' . ($index + 1) . '</span>
                            </div>
                        </div>
                    </div>';
                endforeach;
            endif;
            ?>
        </div>

        <!-- Navigation -->
        <div class="navigation-section">
            <a href="realisationsphoto.php" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                <span>Retour aux albums photos</span>
            </a>
        </div>
    </div>
</main>

<!-- Lightbox Améliorée -->
<div id="lightbox" class="lightbox">
    <div class="lightbox-header">
        <div class="lightbox-title">Photo <span id="current">1</span> / <span id="total">1</span></div>
        <button class="close-btn" onclick="closeLightbox()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="lightbox-content">
        <button class="nav-btn nav-prev" onclick="navigateLightbox(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        
        <div class="image-container">
            <img src="" id="lightbox-img" class="lightbox-img">
            <div class="image-loader">
                <div class="loader-spinner"></div>
            </div>
        </div>
        
        <button class="nav-btn nav-next" onclick="navigateLightbox(1)">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
    
    <div class="lightbox-footer">
        <div class="lightbox-actions">
            <button class="action-btn" onclick="downloadImage()" title="Télécharger">
                <i class="fas fa-download"></i>
            </button>
            <button class="action-btn" onclick="shareImage()" title="Partager">
                <i class="fas fa-share-alt"></i>
            </button>
        </div>
    </div>
</div>

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

    .main-content {
        margin-top: 200px;
    }
    /* Hero Section Améliorée */
    .hero-section {
        position: relative;
        height: 70vh;
        background: var(--gradient-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 30% 20%, rgba(212, 32, 44, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 70% 80%, rgba(44, 82, 130, 0.1) 0%, transparent 50%);
    }

    .hero-particles {
        position: absolute;
        inset: 0;
        background-image: 
            radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
            radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        background-size: 50px 50px, 80px 80px;
        animation: float 20s infinite linear;
    }

    @keyframes float {
        0% { transform: translate(0, 0); }
        100% { transform: translate(-50px, -50px); }
    }

    .hero-content {
        text-align: center;
        z-index: 2;
        color: white;
        max-width: 800px;
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
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 800;
        margin-bottom: 20px;
        background: linear-gradient(135deg, #ffffff, #e2e8f0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1.1;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 30px;
        font-weight: 400;
    }

    .hero-stats {
        display: flex;
        justify-content: center;
        gap: 40px;
        margin-top: 40px;
    }

    .stat {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-light);
        line-height: 1;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .scroll-indicator {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2;
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

    /* Contrôles de galerie */
    .gallery-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 40px 0;
        padding: 20px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
    }

    .view-options {
        display: flex;
        gap: 10px;
    }

    .view-btn {
        width: 45px;
        height: 45px;
        border: 2px solid #e2e8f0;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        color: var(--text-light);
    }

    .view-btn:hover,
    .view-btn.active {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-light);
    }

    .gallery-info {
        font-size: 0.9rem;
        color: var(--text-light);
        font-weight: 500;
    }

    /* Galerie améliorée */
    .photo-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        padding: 20px 0 80px;
    }

    .photo-gallery.masonry {
        columns: 4;
        column-gap: 30px;
    }

    .photo-gallery.masonry .photo-item {
        break-inside: avoid;
        margin-bottom: 30px;
    }

    .no-images {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 40px;
        background: white;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-light);
    }

    .no-images-icon {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .no-images h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: var(--text-color);
    }

    .no-images p {
        color: var(--text-light);
        font-size: 1rem;
    }

    /* Cards 3D améliorées */
    .photo-item {
        perspective: 1000px;
        cursor: pointer;
        opacity: 0;
        transform: translateY(40px);
        animation: fadeInUp 0.8s ease forwards;
        animation-delay: var(--delay);
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-wrapper {
        position: relative;
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        transform-style: preserve-3d;
        transition: var(--transition);
        box-shadow: var(--shadow);
        height: 280px;
        group: hover;
    }

    .photo-item:hover .card-wrapper {
        transform: rotateX(5deg) rotateY(5deg) translateY(-15px);
        box-shadow: var(--shadow-hover);
    }

    .gallery-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.6s ease;
    }

    .photo-item:hover .gallery-image {
        transform: scale(1.1);
    }

    .image-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(212, 32, 44, 0.8), rgba(44, 82, 130, 0.8));
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: var(--transition);
        z-index: 2;
    }

    .photo-item:hover .image-overlay {
        opacity: 1;
    }

    .overlay-content {
        text-align: center;
        color: white;
        transform: translateY(20px);
        transition: var(--transition);
    }

    .photo-item:hover .overlay-content {
        transform: translateY(0);
    }

    .overlay-content i {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
    }

    .overlay-content span {
        font-weight: 600;
        font-size: 1rem;
    }

    .image-info {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 3;
    }

    .image-number {
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }

    /* Lightbox moderne */
    .lightbox {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.95);
        z-index: 10000;
        backdrop-filter: blur(10px);
    }

    .lightbox.active {
        display: flex;
        flex-direction: column;
    }

    .lightbox-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 30px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
    }

    .lightbox-title {
        color: white;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .close-btn {
        width: 50px;
        height: 50px;
        border: none;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 50%;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .close-btn:hover {
        background: var(--primary-color);
        transform: rotate(90deg);
    }

    .lightbox-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        position: relative;
    }

    .image-container {
        position: relative;
        max-width: 90%;
        max-height: 80vh;
    }

    .lightbox-img {
        max-width: 100%;
        max-height: 80vh;
        border-radius: var(--border-radius);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
        opacity: 0;
        transform: scale(0.95);
        transition: all 0.4s ease;
    }

    .lightbox-img.loaded {
        opacity: 1;
        transform: scale(1);
    }

    .image-loader {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.3);
        border-radius: var(--border-radius);
    }

    .loader-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-top: 3px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 60px;
        height: 60px;
        border: none;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 50%;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        backdrop-filter: blur(10px);
    }

    .nav-btn:hover {
        background: var(--primary-color);
        transform: translateY(-50%) scale(1.1);
    }

    .nav-prev {
        left: 30px;
    }

    .nav-next {
        right: 30px;
    }

    .lightbox-footer {
        padding: 20px 30px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        display: flex;
        justify-content: center;
    }

    .lightbox-actions {
        display: flex;
        gap: 15px;
    }

    .action-btn {
        width: 45px;
        height: 45px;
        border: none;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 12px;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .action-btn:hover {
        background: var(--primary-color);
        transform: translateY(-2px);
    }

    /* Navigation Section */
    .navigation-section {
        margin: 50px 0;
        padding: 30px 0;
        text-align: center;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 15px 30px;
        background: var(--gradient-primary);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        transition: var(--transition);
        box-shadow: var(--shadow);
    }

    .btn-back:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
        color: white;
    }

    .btn-back i {
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }

    .btn-back:hover i {
        transform: translateX(-5px);
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .photo-gallery.masonry {
            columns: 3;
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            height: 60vh;
        }
        
        .hero-stats {
            gap: 20px;
        }
        
        .gallery-controls {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }
        
        .photo-gallery {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .photo-gallery.masonry {
            columns: 2;
            column-gap: 20px;
        }
        
        .card-wrapper {
            height: 240px;
        }
        
        .nav-btn {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }
        
        .nav-prev {
            left: 20px;
        }
        
        .nav-next {
            right: 20px;
        }
    }

    @media (max-width: 480px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .photo-gallery {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        
        .photo-gallery.masonry {
            columns: 1;
        }
        
        .card-wrapper {
            height: 220px;
        }
        
        .lightbox-header,
        .lightbox-footer {
            padding: 15px 20px;
        }
        
        .nav-btn {
            width: 45px;
            height: 45px;
        }
    }
</style>

<script>
    // Compteur d'images
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.photo-item');
        const imageCount = images.length;
        document.getElementById('imageCount').textContent = imageCount;
        document.getElementById('loadedCount').textContent = imageCount;
        
        // Animation staggered pour les cartes
        images.forEach((item, index) => {
            item.style.setProperty('--delay', `${index * 0.1}s`);
        });
    });

    // Basculer entre les vues
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const view = this.dataset.view;
            const gallery = document.getElementById('photoGallery');
            
            if (view === 'masonry') {
                gallery.classList.add('masonry');
            } else {
                gallery.classList.remove('masonry');
            }
        });
    });

    // Effet 3D amélioré
    document.querySelectorAll('.photo-item').forEach(item => {
        const wrapper = item.querySelector('.card-wrapper');
        let isHovered = false;

        item.addEventListener('mouseenter', () => {
            isHovered = true;
        });

        item.addEventListener('mouseleave', () => {
            isHovered = false;
            wrapper.style.transform = 'rotateX(0) rotateY(0) translateY(0)';
        });

        item.addEventListener('mousemove', (e) => {
            if (!isHovered) return;
            
            const rect = wrapper.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateY = ((x - centerX) / centerX) * 8;
            const rotateX = ((centerY - y) / centerY) * 8;

            wrapper.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-15px)`;
        });
    });

    // Variables globales pour la lightbox
    let currentImageIndex = 0;
    let allImages = [];
    let isLightboxOpen = false;

    function openLightbox(element) {
        allImages = Array.from(document.querySelectorAll('.photo-item')).map(el => el.dataset.src);
        currentImageIndex = parseInt(element.dataset.index);
        isLightboxOpen = true;

        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const loader = document.querySelector('.image-loader');
        
        // Réinitialiser l'état
        lightboxImg.classList.remove('loaded');
        loader.style.display = 'flex';
        
        // Mettre à jour les informations
        document.getElementById('current').textContent = currentImageIndex + 1;
        document.getElementById('total').textContent = allImages.length;

        // Afficher la lightbox
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';

        // Charger l'image
        loadLightboxImage(element.dataset.src);
    }

    function loadLightboxImage(src) {
        const lightboxImg = document.getElementById('lightbox-img');
        const loader = document.querySelector('.image-loader');
        
        lightboxImg.onload = function() {
            loader.style.display = 'none';
            this.classList.add('loaded');
        };
        
        lightboxImg.src = src;
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        
        lightboxImg.classList.remove('loaded');
        
        setTimeout(() => {
            lightbox.classList.remove('active');
            document.body.style.overflow = 'auto';
            isLightboxOpen = false;
        }, 300);
    }

    function navigateLightbox(direction) {
        if (!isLightboxOpen) return;
        
        currentImageIndex = (currentImageIndex + direction + allImages.length) % allImages.length;
        
        const lightboxImg = document.getElementById('lightbox-img');
        const loader = document.querySelector('.image-loader');
        
        lightboxImg.classList.remove('loaded');
        loader.style.display = 'flex';
        
        setTimeout(() => {
            document.getElementById('current').textContent = currentImageIndex + 1;
            loadLightboxImage(allImages[currentImageIndex]);
        }, 150);
    }

    function downloadImage() {
        const lightboxImg = document.getElementById('lightbox-img');
        const link = document.createElement('a');
        link.href = lightboxImg.src;
        link.download = `photo_${currentImageIndex + 1}.jpg`;
        link.click();
    }

    function shareImage() {
        if (navigator.share) {
            navigator.share({
                title: 'Photo de la galerie',
                text: `Photo ${currentImageIndex + 1} de ${allImages.length}`,
                url: window.location.href
            });
        }
    }

    // Navigation clavier
    document.addEventListener('keydown', (e) => {
        if (!isLightboxOpen) return;
        
        switch(e.key) {
            case 'Escape':
                closeLightbox();
                break;
            case 'ArrowLeft':
                navigateLightbox(-1);
                break;
            case 'ArrowRight':
                navigateLightbox(1);
                break;
        }
    });

    // Fermer la lightbox en cliquant à l'extérieur
    document.getElementById('lightbox').addEventListener('click', (e) => {
        if (e.target === document.getElementById('lightbox') || 
            e.target === document.querySelector('.lightbox-content')) {
            closeLightbox();
        }
    });

    // Smooth scroll pour l'indicateur de défilement
    document.querySelector('.scroll-indicator')?.addEventListener('click', () => {
        document.querySelector('.main-content').scrollIntoView({
            behavior: 'smooth'
        });
    });

    // Préchargement des images suivantes
    function preloadImages() {
        if (!isLightboxOpen) return;
        
        const nextIndex = (currentImageIndex + 1) % allImages.length;
        const prevIndex = (currentImageIndex - 1 + allImages.length) % allImages.length;
        
        [nextIndex, prevIndex].forEach(index => {
            const img = new Image();
            img.src = allImages[index];
        });
    }

    // Démarrer le préchargement après ouverture de la lightbox
    setInterval(() => {
        if (isLightboxOpen) {
            preloadImages();
        }
    }, 1000);

    // Gestion du redimensionnement de la fenêtre
    window.addEventListener('resize', () => {
        if (isLightboxOpen) {
            // Réajuster la taille de l'image si nécessaire
            const lightboxImg = document.getElementById('lightbox-img');
            if (lightboxImg.src) {
                lightboxImg.style.maxHeight = '80vh';
            }
        }
    });

    // Animation de chargement progressive des images
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '50px 0px'
    };

    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target.querySelector('.gallery-image');
                if (img && !img.classList.contains('loaded')) {
                    img.addEventListener('load', () => {
                        img.classList.add('loaded');
                        entry.target.style.opacity = '1';
                    });
                    
                    // Si l'image est déjà chargée
                    if (img.complete) {
                        img.classList.add('loaded');
                        entry.target.style.opacity = '1';
                    }
                }
                imageObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observer toutes les images
    document.querySelectorAll('.photo-item').forEach(item => {
        imageObserver.observe(item);
    });

    // Gestion des gestes tactiles pour mobile
    let touchStartX = 0;
    let touchStartY = 0;

    document.getElementById('lightbox').addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].clientX;
        touchStartY = e.touches[0].clientY;
    });

    document.getElementById('lightbox').addEventListener('touchend', (e) => {
        if (!isLightboxOpen) return;
        
        const touchEndX = e.changedTouches[0].clientX;
        const touchEndY = e.changedTouches[0].clientY;
        const deltaX = touchEndX - touchStartX;
        const deltaY = touchEndY - touchStartY;
        
        // Swipe horizontal
        if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 50) {
            if (deltaX > 0) {
                navigateLightbox(-1); // Swipe droite = image précédente
            } else {
                navigateLightbox(1);  // Swipe gauche = image suivante
            }
        }
        
        // Swipe vertical vers le bas pour fermer
        if (deltaY > 100 && Math.abs(deltaX) < 50) {
            closeLightbox();
        }
    });

    // Zoom sur l'image dans la lightbox (double tap)
    let lastTap = 0;
    let isZoomed = false;

    document.getElementById('lightbox-img').addEventListener('touchend', (e) => {
        const currentTime = new Date().getTime();
        const tapLength = currentTime - lastTap;
        
        if (tapLength < 500 && tapLength > 0) {
            // Double tap détecté
            e.preventDefault();
            const img = e.target;
            
            if (isZoomed) {
                img.style.transform = 'scale(1)';
                img.style.cursor = 'default';
                isZoomed = false;
            } else {
                img.style.transform = 'scale(2)';
                img.style.cursor = 'zoom-out';
                isZoomed = true;
            }
        }
        lastTap = currentTime;
    });

    // Réinitialiser le zoom lors du changement d'image
    const originalNavigateLightbox = navigateLightbox;
    navigateLightbox = function(direction) {
        const img = document.getElementById('lightbox-img');
        img.style.transform = 'scale(1)';
        img.style.cursor = 'default';
        isZoomed = false;
        originalNavigateLightbox(direction);
    };

    // Effet parallaxe subtil sur le hero
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallax = document.querySelector('.hero-particles');
        if (parallax) {
            parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });

    // Mode plein écran
    function toggleFullscreen() {
        if (!document.fullscreenElement) {
            document.getElementById('lightbox').requestFullscreen?.() ||
            document.getElementById('lightbox').webkitRequestFullscreen?.() ||
            document.getElementById('lightbox').msRequestFullscreen?.();
        } else {
            document.exitFullscreen?.() ||
            document.webkitExitFullscreen?.() ||
            document.msExitFullscreen?.();
        }
    }

    // Raccourci clavier pour le plein écran
    document.addEventListener('keydown', (e) => {
        if (isLightboxOpen && e.key === 'f') {
            toggleFullscreen();
        }
    });

    // Ajouter le bouton plein écran dans les actions
    const fullscreenBtn = document.createElement('button');
    fullscreenBtn.className = 'action-btn';
    fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
    fullscreenBtn.title = 'Plein écran (F)';
    fullscreenBtn.onclick = toggleFullscreen;
    
    document.querySelector('.lightbox-actions').appendChild(fullscreenBtn);

    // Mettre à jour l'icône du bouton plein écran
    document.addEventListener('fullscreenchange', () => {
        const icon = fullscreenBtn.querySelector('i');
        if (document.fullscreenElement) {
            icon.className = 'fas fa-compress';
            fullscreenBtn.title = 'Quitter le plein écran (F)';
        } else {
            icon.className = 'fas fa-expand';
            fullscreenBtn.title = 'Plein écran (F)';
        }
    });

    // Mode diaporama automatique
    let slideshowInterval;
    let isSlideshow = false;

    function toggleSlideshow() {
        if (isSlideshow) {
            clearInterval(slideshowInterval);
            isSlideshow = false;
            slideshowBtn.innerHTML = '<i class="fas fa-play"></i>';
            slideshowBtn.title = 'Lancer le diaporama';
        } else {
            slideshowInterval = setInterval(() => {
                if (isLightboxOpen) {
                    navigateLightbox(1);
                }
            }, 3000);
            isSlideshow = true;
            slideshowBtn.innerHTML = '<i class="fas fa-pause"></i>';
            slideshowBtn.title = 'Arrêter le diaporama';
        }
    }

    // Ajouter le bouton diaporama
    const slideshowBtn = document.createElement('button');
    slideshowBtn.className = 'action-btn';
    slideshowBtn.innerHTML = '<i class="fas fa-play"></i>';
    slideshowBtn.title = 'Lancer le diaporama';
    slideshowBtn.onclick = toggleSlideshow;
    
    document.querySelector('.lightbox-actions').insertBefore(slideshowBtn, fullscreenBtn);

    // Arrêter le diaporama si l'utilisateur navigue manuellement
    const originalNavigate = window.navigateLightbox;
    window.navigateLightbox = function(direction) {
        if (isSlideshow) {
            toggleSlideshow();
        }
        originalNavigate(direction);
    };

    console.log('Galerie photo améliorée chargée avec succès!');
</script>

<?php require './utils/footer.php'; ?>