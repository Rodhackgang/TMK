<?php
    require './utils/header.php';
    require_once './utils/api-config.php';
    
    // Charger le contenu de la page d'accueil depuis le fichier JSON ou l'API
    $contentFile = __DIR__ . '/Backend/home-content.json';
    $content = getContentFromJsonOrApi($contentFile, '/api/content/home');
    
    // Valeurs par défaut si le contenu n'est pas disponible
    $hero = $content['hero'] ?? [
        'videoUrl' => 'images/1.mp4',
        'title' => 'Un avenir meilleur pour tous',
        'subtitle' => 'Agissons ensemble pour un changement durable',
        'donateButtonText' => 'Faire un don',
        'videoButtonText' => 'Voir notre vidéo',
        'uiuxButtonText' => 'Si vous avez besoin d\'avoir votre propre Site web cliquez sur ce bouton',
        'uiuxWhatsappLink' => 'https://wa.me/243974555964'
    ];
    // Forcer le texte du bouton site web (prioritaire sur l'API)
    $hero['uiuxButtonText'] = 'Si vous avez besoin d\'avoir votre propre Site web cliquez sur ce bouton';

    $videoSection = $content['videoSection'] ?? [
        'title' => 'Notre Mission en Action',
        'subtitle' => 'Découvrez comment votre soutien transforme des vies dans les domaines de l\'éducation, de la santé et de l\'aide humanitaire.',
        'videos' => ['images/2.mp4'],
        'youtubeUrl' => 'https://www.youtube.com/embed/IUnlo_BRRBA'
    ];
    
    $donationModal = $content['donationModal'] ?? [
        'title' => 'Merci de votre générosité',
        'subtitle' => 'Votre don fait la différence !',
        'note' => 'Après votre don, envoyez un SMS avec votre nom au même numéro pour confirmation.'
    ];
    
    $donationSection = $content['donationSection'] ?? [
        'title' => 'Soutenez Notre Cause',
        'description' => 'Votre générosité peut changer des vies. Faites un don maintenant et aidez-nous à créer un impact durable.'
    ];
    
    $phoneNumbers = $content['phoneNumbers'] ?? [
        ['icon' => 'fab fa-whatsapp', 'number' => '0824078000', 'operator' => 'Vodacom'],
        ['icon' => 'fas fa-mobile-alt', 'number' => '0850958952', 'operator' => 'Orange'],
        ['icon' => 'fas fa-phone', 'number' => '0978219845', 'operator' => 'Airtel']
    ];
    
    $contactSection = $content['contactSection'] ?? [
        'title' => 'Besoin d\'un site similaire ?',
        'description' => 'Contactez-nous pour la conception de votre site web professionnel',
        'buttonText' => 'Nous contacter',
        'whatsappLink' => 'https://wa.me/+243974555964?text=Bonjour,%20je%20suis%20intéressé%20par%20la%20conception%20d\'un%20site%20internet.'
    ];
    
    // Préparer la liste des vidéos pour JavaScript
    $videosJson = json_encode($videoSection['videos'] ?? ['images/2.mp4']);

    // Helper : lien cliquable pour chaque numéro (WhatsApp ou tel)
    $phoneLinks = array_map(function ($phone) {
        $num = $phone['number'];
        $isWhatsApp = (strpos($phone['icon'] ?? '', 'whatsapp') !== false);
        if ($isWhatsApp) {
            $waNum = '243' . ltrim($num, '0');
            return ['url' => 'https://wa.me/' . $waNum, 'aria' => 'Ouvrir la conversation WhatsApp'];
        }
        return ['url' => 'tel:' . $num, 'aria' => 'Appeler'];
    }, $phoneNumbers);
?>

<!-- Polices Google -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        line-height: 1.6;
        color: #333; /* Texte sombre sur fond blanc */
        overflow-x: hidden;
        background-color: #ffffff; /* Fond blanc */
    }

    /* Section Hero */
    .hero {
        position: relative;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        overflow: hidden;
    }

    .hero-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -2;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4));
        z-index: -1;
    }

    .hero-content {
        max-width: 800px;
        padding: 2rem;
        animation: fadeInUp 1s ease-out;
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 4rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .hero-subtitle {
        font-size: 1.5rem;
        color: #f0f0f0;
        margin-bottom: 2rem;
        font-weight: 300;
    }

    .cta-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }

    .ui-ux-section {
        margin-top: 1.5rem;
        padding: 1.25rem 1.5rem;
        border: 2px solid rgba(255, 255, 255, 0.4);
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.08);
        display: inline-block;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .hero .ui-ux-text,
    .hero .btn-ui-ux {
        color: #fff;
    }

    .btn {
        padding: 1rem 2rem;
        border: none;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-primary {
        background: linear-gradient(45deg, #4a6cf7, #8fb4ff); /* Bleu cobalt pâle */
        color: white;
        box-shadow: 0 4px 15px rgba(74, 108, 247, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 108, 247, 0.4);
    }

    .btn-outline {
        background: transparent;
        color: #333;
        border: 2px solid #333;
    }

    .btn-outline:hover {
        background: #333;
        color: white;
        transform: translateY(-2px);
    }

    /* Sur la section Hero (fond vidéo sombre), garder le bouton outline lisible */
    .hero .btn-outline {
        color: white;
        border: 2px solid white;
    }
    .hero .btn-outline:hover {
        background: white;
        color: #333;
    }

    /* Section Vidéos - Style fond blanc */
    .video-section {
        padding: 5rem 0;
        background-color: #ffffff;
        color: #333;
        border-top: 1px solid rgba(0, 0, 0, 0.08);
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }
    
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }
    
    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        text-align: center;
        margin-bottom: 1rem;
        font-weight: 600;
        color: #1a1a1a;
    }
    
    .section-subtitle {
        font-size: 1.2rem;
        text-align: center;
        margin-bottom: 3rem;
        opacity: 0.9;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        color: #555;
    }

    /* Section Mission & Vision */
    .mission-vision-section {
        padding: 4rem 0;
        background-color: #ffffff;
    }

    .mission-vision-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: center;
        margin-top: 2rem;
    }

    .mission-vision-block {
        flex: 1 1 280px;
        max-width: 500px;
        background: #f8f9fa;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.06);
    }

    .mission-vision-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        margin-bottom: 1rem;
        color: #1a1a1a;
    }

    .mission-vision-text {
        font-size: 1rem;
        color: #555;
    }

    /* Section Actualités - design soigné avec overflow élégant */
    .news-section {
        padding: 5rem 0;
        background: linear-gradient(165deg, #f0f7ff 0%, #f8fafc 35%, #f1f5f9 100%);
        overflow: hidden;
        position: relative;
    }

    .news-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(91, 143, 217, 0.2), transparent);
        opacity: 0.8;
    }

    .news-section .news-container {
        max-width: 1920px;
        margin: 0 auto;
        padding: 0 2.5rem;
    }

    .news-section .section-title {
        position: relative;
        padding-bottom: 0.5rem;
        color: #0f172a;
        font-size: 2rem;
        letter-spacing: -0.02em;
    }

    .news-section .section-title::after {
        content: '';
        display: block;
        width: 72px;
        height: 5px;
        background: linear-gradient(90deg, #5B8FD9, #93c5fd, #8fb4ff);
        margin: 0.75rem 0 0;
        border-radius: 3px;
        box-shadow: 0 2px 8px rgba(91, 143, 217, 0.25);
    }

    .news-section .section-subtitle {
        max-width: 640px;
        font-size: 1.1rem;
        line-height: 1.75;
        margin-bottom: 2.5rem;
        color: #64748b;
    }

    /* Wrapper overflow avec fades latéraux */
    .news-scroll-wrapper {
        overflow: hidden;
        margin-top: 2.5rem;
        margin-left: -0.5rem;
        margin-right: -0.5rem;
        position: relative;
        border-radius: 20px;
        background: linear-gradient(90deg, rgba(248, 250, 252, 0.95) 0%, transparent 8%, transparent 92%, rgba(248, 250, 252, 0.95) 100%);
        padding: 1.5rem 0 2rem;
        box-shadow: inset 0 2px 20px rgba(15, 23, 42, 0.04);
    }

    .news-scroll-wrapper::before,
    .news-scroll-wrapper::after {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        width: 80px;
        z-index: 2;
        pointer-events: none;
    }

    .news-scroll-wrapper::before {
        left: 0;
        background: linear-gradient(90deg, rgba(240, 247, 255, 0.98), transparent);
    }

    .news-scroll-wrapper::after {
        right: 0;
        background: linear-gradient(270deg, rgba(240, 247, 255, 0.98), transparent);
    }

    .news-grid {
        display: flex;
        flex-wrap: nowrap;
        gap: 1.75rem;
        margin: 0;
        padding: 0.5rem 1.5rem 1.5rem;
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        scrollbar-width: thin;
        scrollbar-color: #5B8FD9 #e0e7ff;
        -webkit-overflow-scrolling: touch;
        animation: scrollNews 14s linear infinite;
    }

    .news-grid:hover {
        animation-play-state: paused;
    }

    .news-grid::-webkit-scrollbar {
        height: 10px;
    }

    .news-grid::-webkit-scrollbar-track {
        background: linear-gradient(90deg, #e0e7ff, #e2e8f0);
        border-radius: 10px;
        margin: 0 1rem;
    }

    .news-grid::-webkit-scrollbar-thumb {
        background: linear-gradient(90deg, #5B8FD9, #7ea8e8);
        border-radius: 10px;
        box-shadow: 0 1px 3px rgba(91, 143, 217, 0.3);
    }

    .news-grid::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(90deg, #4a7bc7, #5B8FD9);
    }

    @keyframes scrollNews {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    .news-card {
        flex: 0 0 380px;
        min-width: 380px;
        background: linear-gradient(180deg, #ffffff 0%, #fafbff 100%);
        border-radius: 20px;
        padding: 2.25rem 2rem;
        border: 1px solid rgba(226, 232, 240, 0.9);
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease, border-color 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06), 0 1px 3px rgba(91, 143, 217, 0.06);
    }

    .news-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #5B8FD9, #93c5fd, #8fb4ff);
        border-radius: 20px 20px 0 0;
        opacity: 1;
    }

    .news-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 20px;
        padding: 1px;
        background: linear-gradient(135deg, rgba(91, 143, 217, 0.15), transparent 40%, transparent 60%, rgba(147, 197, 253, 0.1));
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
    }

    .news-card:hover {
        transform: translateY(-8px) scale(1.01);
        border-color: rgba(91, 143, 217, 0.35);
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.1), 0 8px 24px rgba(91, 143, 217, 0.15);
    }

    .news-meta {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1.8px;
        color: #5B8FD9;
        font-weight: 700;
        display: inline-block;
        padding: 0.35rem 0.75rem;
        background: linear-gradient(135deg, rgba(91, 143, 217, 0.12), rgba(147, 197, 253, 0.08));
        border-radius: 100px;
        border: 1px solid rgba(91, 143, 217, 0.2);
    }

    .news-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        line-height: 1.4;
        color: #0f172a;
        font-weight: 600;
        letter-spacing: -0.01em;
    }

    .news-text {
        font-size: 0.95rem;
        line-height: 1.65;
        color: #475569;
        flex: 1;
    }

    .news-link {
        margin-top: 0.35rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: #5B8FD9;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.2s ease, gap 0.25s ease;
    }

    .news-link:hover {
        color: #2563eb;
        gap: 0.65rem;
    }

    .news-link::after {
        content: '→';
        font-size: 1em;
        transition: transform 0.25s ease;
    }

    .news-card:hover .news-link::after {
        transform: translateX(4px);
    }

    .video-container {
        position: relative;
        max-width: 500px;
        margin: 0 auto;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .video-player {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    .video-controls {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 2rem;
    }

    .video-btn {
        background: #f0f0f0;
        border: 2px solid #ddd;
        color: #333;
        padding: 0.8rem 1.5rem;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .video-btn:hover {
        background: #e0e0e0;
        transform: translateY(-2px);
    }

    /* Section Don - Style fond blanc */
    .donation-section {
        padding: 5rem 0;
        background-color: #ffffff;
    }

    .donation-card {
        background: #f8f9fa;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        text-align: center;
        max-width: 600px;
        margin: 0 auto;
        border: 1px solid rgba(0, 0, 0, 0.08);
        color: #000;
    }

    .donation-card > p {
        color: #000;
    }

    .donation-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
    }

    .donation-list {
        list-style: none;
        margin: 2rem 0;
    }

    .donation-list li {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        padding: 1rem;
        margin: 0.5rem 0;
        background: linear-gradient(45deg, #8BB3DB, #A8C5E8);
        border-radius: 15px;
        color: #000;
        font-weight: 500;
        transition: transform 0.3s ease;
    }

    .donation-list li:hover {
        transform: translateY(-2px);
    }

    .donation-list-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        width: 100%;
        color: inherit;
        text-decoration: none;
        padding: inherit;
        margin: -1rem;
        padding: 1rem;
    }

    .donation-list-link:hover {
        color: inherit;
    }

    .donation-list i {
        font-size: 1.5rem;
    }

    .contact-section {
        position: relative;
        background: linear-gradient(135deg, #f8fafc, #e3f2ff);
        color: #000;
        padding: 2.5rem 2rem;
        border-radius: 24px;
        margin-top: 2.5rem;
        text-align: center;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .contact-section::before {
        content: "";
        position: absolute;
        inset: -40%;
        background: radial-gradient(circle at top left, rgba(74, 108, 247, 0.16), transparent 55%),
                    radial-gradient(circle at bottom right, rgba(37, 211, 102, 0.18), transparent 55%);
        opacity: 0.9;
        pointer-events: none;
    }

    .contact-section-inner {
        position: relative;
        z-index: 1;
        max-width: 520px;
        margin: 0 auto;
    }

    .contact-section h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.9rem;
        margin-bottom: 0.75rem;
        color: #0f172a;
    }

    .contact-section p {
        font-size: 1rem;
        color: #475569;
        margin-bottom: 1.5rem;
    }

    .contact-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        background: linear-gradient(120deg, #25d366, #16a34a);
        color: white !important;
        padding: 0.9rem 2.3rem;
        border-radius: 999px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        font-size: 0.9rem;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        box-shadow: 0 14px 30px rgba(34, 197, 94, 0.35);
    }

    .contact-btn i {
        font-size: 1.1rem;
    }

    .contact-btn:hover {
        transform: translateY(-3px) scale(1.01);
        box-shadow: 0 20px 40px rgba(34, 197, 94, 0.45);
        background: linear-gradient(120deg, #22c55e, #15803d);
    }

    .donation-modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
        align-items: center;
        justify-content: center;
    }

    .donation-modal-content {
        background: rgba(255, 255, 255, 0.1); /* Couleur demandée */
        border-radius: 25px;
        padding: 3rem;
        width: 90%;
        max-width: 600px;
        position: relative;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        animation: modalAppear 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white; /* Texte blanc */
    }

    .donation-modal-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .donation-modal-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        color: #ff6b6b;
        margin-bottom: 0.5rem;
    }

    .donation-modal-subtitle {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.8); /* Texte blanc avec transparence */
    }

    .donation-modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 2rem;
        color: rgba(255, 255, 255, 0.7);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .donation-modal-close:hover {
        color: #ff6b6b;
        transform: rotate(90deg);
    }

    .donation-modal-list {
        list-style: none;
        margin: 2rem 0;
    }

    .donation-modal-list li {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.2rem;
        margin: 1rem 0;
        background: linear-gradient(45deg, #8BB3DB, #A8C5E8);
        border-radius: 15px;
        color: #000;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(139, 179, 219, 0.4);
    }

    .donation-modal-list li:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(139, 179, 219, 0.6);
    }

    .donation-modal-link {
        display: flex;
        align-items: center;
        gap: 1rem;
        width: 100%;
        color: inherit;
        text-decoration: none;
    }

    .donation-modal-link:hover {
        color: inherit;
    }

    .donation-modal-list i {
        font-size: 1.8rem;
        min-width: 40px;
        text-align: center;
    }

    .donation-note {
        text-align: center;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7); /* Texte blanc avec transparence */
        margin-top: 2rem;
        padding: 1rem;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        border-left: 4px solid #ff6b6b;
    }

    @keyframes modalAppear {
        from {
            opacity: 0;
            transform: translateY(60px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.2rem;
        }

        .cta-buttons {
            flex-direction: column;
            align-items: center;
        }

        .section-title {
            font-size: 2rem;
        }

        .video-container {
            margin: 0 1rem;
        }

        .news-section .news-container {
            padding: 0 1.25rem;
        }

        .news-card {
            min-width: 300px;
            flex: 0 0 300px;
            padding: 1.5rem 1.75rem;
        }

        .news-title {
            font-size: 1.2rem;
        }
    }
</style>
</head>
<body>
    <!-- Section Hero -->
    <section id="home" class="hero">
        <video class="hero-video" autoplay muted loop>
            <source src="<?= htmlspecialchars($hero['videoUrl']) ?>" type="video/mp4">
            Votre navigateur ne supporte pas la vidéo HTML5.
        </video>
        <div class="hero-overlay"></div>

        <div class="hero-content">
            <h1 class="hero-title"><?= htmlspecialchars($hero['title']) ?></h1>
            <p class="hero-subtitle"><?= htmlspecialchars($hero['subtitle']) ?></p>
            <div class="cta-buttons">
                <button class="btn btn-primary" id="donateBtn"><?= htmlspecialchars($hero['donateButtonText']) ?></button>
                <button class="btn btn-outline" id="videoBtn"><?= htmlspecialchars($hero['videoButtonText']) ?></button>
            </div>
        </div>


    </section>

    <?php
    // Section Mission & Vision (administrable via l'admin -> Accueil)
    $mv = $content['missionVision'] ?? [];
    $mvSectionTitle = $mv['sectionTitle'] ?? 'Notre mission & notre vision';
    $mvMissionTitle = $mv['missionTitle'] ?? 'Notre mission';
    $mvMissionText  = $mv['missionText'] ?? "La mission de la fondation THE MIRACLE KINGDOM est de mettre en œuvre des actions d’intérêt général visant à soutenir les personnes démunies et vulnérables, et à aider les populations à devenir actrices de leur propre développement, grâce à des interventions adaptées, structurées et à fort impact social.";
    $mvVisionTitle  = $mv['visionTitle'] ?? 'Notre vision';
    $mvVisionText   = $mv['visionText'] ?? "Par sa vision, The Miracle Kingdom œuvre à la construction de sociétés plus justes, solidaires et résilientes, où chacun, en particulier les plus défavorisés, peut accéder à des conditions de vie dignes et à de réelles opportunités d’avenir.";
    ?>
    <!-- Section Mission & Vision -->
    <section class="mission-vision-section">
        <div class="container">
            <h2 class="section-title"><?= htmlspecialchars($mvSectionTitle) ?></h2>
            <div class="mission-vision-grid">
                <div class="mission-vision-block">
                    <h3 class="mission-vision-title"><?= htmlspecialchars($mvMissionTitle) ?></h3>
                    <p class="mission-vision-text">
                        <?= nl2br(htmlspecialchars($mvMissionText)) ?>
                    </p>
                </div>
                <div class="mission-vision-block">
                    <h3 class="mission-vision-title"><?= htmlspecialchars($mvVisionTitle) ?></h3>
                    <p class="mission-vision-text">
                        <?= nl2br(htmlspecialchars($mvVisionText)) ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <?php
    // Section Actualités (administrable via l'admin -> Accueil)
    $newsC = $content['news'] ?? [];
    $newsTitle = $newsC['sectionTitle'] ?? 'Actualités';
    $newsSubtitle = $newsC['subtitle'] ?? "Découvrez les dernières actions et événements de la fondation THE MIRACLE KINGDOM sur le terrain.";
    $newsItems = $newsC['items'] ?? [];
    // Si l'admin n'a pas encore défini d'actualités, afficher les actualités par défaut
    if (empty($newsItems)) {
        $newsItems = [
            ['meta' => 'Dernière action', 'title' => 'Distribution de kits alimentaires aux familles vulnérables', 'text' => "La fondation a organisé une campagne de solidarité pour soutenir les ménages les plus touchés par l’insécurité alimentaire, en partenariat avec des acteurs locaux engagés.", 'linkText' => 'En savoir plus', 'link' => '#'],
            ['meta' => 'Éducation', 'title' => 'Lancement d’un programme de soutien scolaire pour les enfants défavorisés', 'text' => "Des séances d’appui scolaire et d’accompagnement psychologique ont été mises en place afin d’offrir aux enfants un cadre propice à la réussite et à l’épanouissement.", 'linkText' => 'Découvrir le programme', 'link' => '#'],
            ['meta' => 'Santé & bien-être', 'title' => 'Campagne de sensibilisation et de prévention en milieu rural', 'text' => "Des activités de prévention et de sensibilisation ont été menées pour promouvoir la santé, l’hygiène et le bien-être des communautés les plus isolées.", 'linkText' => 'Voir les résultats', 'link' => '#'],
        ];
    }
    ?>
    <!-- Section Actualités -->
    <section class="news-section">
        <div class="news-container">
            <h2 class="section-title"><?= htmlspecialchars($newsTitle) ?></h2>
            <p class="section-subtitle">
                <?= htmlspecialchars($newsSubtitle) ?>
            </p>
            <div class="news-scroll-wrapper">
                <div class="news-grid">
                <?php
                // Les cartes sont dupliquées pour l'effet de défilement continu (animation CSS)
                for ($pass = 0; $pass < 2; $pass++):
                    foreach ($newsItems as $item):
                ?>
                <article class="news-card">
                    <?php if (!empty($item['meta'])): ?><span class="news-meta"><?= htmlspecialchars($item['meta']) ?></span><?php endif; ?>
                    <h3 class="news-title"><?= htmlspecialchars($item['title'] ?? '') ?></h3>
                    <p class="news-text">
                        <?= htmlspecialchars($item['text'] ?? '') ?>
                    </p>
                    <a href="<?= htmlspecialchars($item['link'] ?? '#') ?>" class="news-link"><?= htmlspecialchars($item['linkText'] ?? 'En savoir plus') ?></a>
                </article>
                <?php
                    endforeach;
                endfor;
                ?>
                </div>
            </div>
        </div>
    </section>

    <div id="donationModal" class="donation-modal">
        <div class="donation-modal-content">
            <span class="donation-modal-close">&times;</span>

            <div class="donation-modal-header">
                <h2 class="donation-modal-title"><?= htmlspecialchars($donationModal['title']) ?></h2>
                <p class="donation-modal-subtitle"><?= htmlspecialchars($donationModal['subtitle']) ?></p>
            </div>

            <ul class="donation-modal-list">
                <?php foreach ($phoneNumbers as $i => $phone): $link = $phoneLinks[$i]; ?>
                <li>
                    <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" rel="noopener noreferrer" class="donation-modal-link" aria-label="<?= htmlspecialchars($link['aria']) ?> - <?= htmlspecialchars($phone['number']) ?>">
                        <i class="<?= htmlspecialchars($phone['icon']) ?>"></i>
                        <span><?= htmlspecialchars($phone['number']) ?> (<?= htmlspecialchars($phone['operator']) ?>)</span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>

            <p class="donation-note">
                <i class="fas fa-info-circle"></i> <?= htmlspecialchars($donationModal['note']) ?>
            </p>
        </div>
    </div>

    <!-- Section Don -->
    <section class="donation-section">
        <div class="container">
            <div class="donation-card">
                <h2 class="donation-title"><?= htmlspecialchars($donationSection['title']) ?></h2>
                <p><?= htmlspecialchars($donationSection['description']) ?></p>

                <ul class="donation-list">
                    <?php foreach ($phoneNumbers as $i => $phone): $link = $phoneLinks[$i]; ?>
                    <li>
                        <a href="<?= htmlspecialchars($link['url']) ?>" target="_blank" rel="noopener noreferrer" class="donation-list-link" aria-label="<?= htmlspecialchars($link['aria']) ?> - <?= htmlspecialchars($phone['number']) ?>">
                            <i class="<?= htmlspecialchars($phone['icon']) ?>"></i>
                            <span><?= htmlspecialchars($phone['number']) ?> (<?= htmlspecialchars($phone['operator']) ?>)</span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <div class="contact-section">
                    <h3><?= htmlspecialchars($contactSection['title']) ?></h3>
                    <p><?= htmlspecialchars($contactSection['description']) ?></p>
                    <a href="<?= htmlspecialchars($contactSection['whatsappLink']) ?>" target="_blank" rel="noopener noreferrer" class="contact-btn">
                        <i class="fab fa-whatsapp"></i> <?= htmlspecialchars($contactSection['buttonText']) ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script>
        const donationModal = document.getElementById('donationModal');
        const donateBtn = document.getElementById('donateBtn');
        const donationClose = document.querySelector('.donation-modal-close');

        // Ouvrir le modal de donation
        donateBtn.addEventListener('click', function() {
            donationModal.style.display = 'flex';
            setTimeout(() => {
                donationModal.style.opacity = '1';
            }, 10);
        });

        // Fermer le modal de donation
        donationClose.addEventListener('click', function() {
            donationModal.style.opacity = '0';
            setTimeout(() => {
                donationModal.style.display = 'none';
            }, 300);
        });

        // Fermer en cliquant en dehors du modal
        window.addEventListener('click', function(e) {
            if (e.target === donationModal) {
                donationModal.style.opacity = '0';
                setTimeout(() => {
                    donationModal.style.display = 'none';
                }, 300);
            }
        });
    </script>

<?php
require './utils/footer.php';
?>