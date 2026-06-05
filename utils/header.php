<!DOCTYPE html>
<html lang="fr" class="no-js">
<head>
  <meta charset="utf-8" />
  <title>Groupe TMK - Accueil</title>
  <meta name="description" content="THE MIRACLE KINGDOM FOUNDATION - TMK, œuvre pour améliorer la vie sociale et influencer positivement la nouvelle génération pour un avenir meilleur." />
  <meta name="keywords" content="TMK, THE MIRACLE KINGDOM FOUNDATION, projets, réalisations, bien-être, communauté, avenir" />
  
  <!-- Open Graph Meta Tags -->
  <meta property="og:title" content="Groupe TMK - Accueil" />
  <meta property="og:description" content="Découvrez l'engagement de TMK pour améliorer la vie sociale et l'avenir des individus." />
  <meta property="og:image" content="https://www.tmkfoundation.com/images/logo.png" />
  <meta property="og:url" content="<?= htmlspecialchars("https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>" />

  <!-- Twitter Card Meta Tags -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:image" content="https://www.tmkfoundation.com/images/logo.png" />
  <meta name="twitter:title" content="Groupe TMK - Accueil" />
  <meta name="twitter:description" content="Découvrez l'engagement de TMK pour améliorer la vie sociale et l'avenir des individus." />
  
  <!-- Favicon -->
  <link href="images/logo.png" rel="icon" />

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

  <!-- Stylesheets -->
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <link href="css/font-awesome.css" rel="stylesheet" />
  <link href="js/owl-carousel/owl.carousel.css" rel="stylesheet" />
  <link href="js/owl-carousel/owl.theme.css" rel="stylesheet" />
  <link href="js/owl-carousel/owl.transitions.css" rel="stylesheet" />
  <link href="css/magnific-popup.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="css/animate.css" />
  <link rel="stylesheet" href="css/etlinefont.css" />
  <link href="css/style.css" type="text/css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <!-- Tailwind CSS (used primarily for the new footer) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            tmkAccent: '#6b8cce',        /* Bleu cobalt doux */
            tmkAccentHover: '#8ba8e0'    /* Bleu cobalt doux (hover) */
          }
        }
      }
    };
  </script>

  <style>
    /* ===== NOUVEAU HEADER SYSTEM ===== */
    
    /* Container principal du header */
    .tmk-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 99999;
      background: #ffffff; /* Fond blanc */
      transition: background 0.3s ease, box-shadow 0.3s ease;
      height: 70px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.06);
    }
    
    .tmk-header.scrolled {
      background: #ffffff; /* Fond blanc au scroll */
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
    
    /* Container du contenu */
    .tmk-header-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 70px;
      padding: 0 20px;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    /* Logo */
    .tmk-logo {
      flex-shrink: 0;
      width: 100px;
    }
    
    .tmk-logo img {
      width: 100%;
      height: auto;
      filter: brightness(0); /* Logo foncé pour fond clair */
      transition: filter 0.3s ease;
    }
    
    /* Menu principal */
    .tmk-nav {
      display: flex;
      align-items: center;
      list-style: none;
      margin: 0;
      padding: 0;
      gap: 0;
    }
    
    .tmk-nav-item {
      position: relative;
    }
    
    .tmk-nav-link {
      display: block;
      padding: 25px 12px;
      color: #000000;
      text-decoration: none;
      font-weight: 700;
      font-size: 13px;
      text-transform: uppercase;
      transition: color 0.3s ease, background-color 0.3s ease;
      position: relative;
      white-space: nowrap;
    }
    
    .tmk-nav-link:hover {
      color: #ffffff; /* Texte blanc au survol */
      background-color: #5B8FD9; /* Fond bleu cobalt pâle au survol */
    }
    
    .tmk-nav-link.active {
      color: #ffffff; /* Texte blanc pour l'onglet actif */
      background-color: #5B8FD9; /* Fond bleu cobalt pâle pour l'onglet actif */
    }
    
    /* Ligne de hover désactivée (aucun soulignement) */
    .tmk-nav-link::after {
      content: none;
    }
    
    /* Dropdown */
    .tmk-dropdown {
      position: relative;
    }
    
    .tmk-dropdown-toggle {
      display: flex;
      align-items: center;
      gap: 5px;
    }
    
    /* Survol "Nos réalisations" : texte et flèche en bleu cobalt */
    .tmk-dropdown .tmk-nav-link.tmk-dropdown-toggle:hover,
    .tmk-dropdown.active .tmk-nav-link.tmk-dropdown-toggle:hover {
      color: #0047AB !important; /* Bleu cobalt au survol */
      background-color: rgba(0, 71, 171, 0.08) !important;
    }
    .tmk-dropdown .tmk-nav-link.tmk-dropdown-toggle:hover i,
    .tmk-dropdown.active .tmk-nav-link.tmk-dropdown-toggle:hover i {
      color: #0047AB !important; /* Flèche bleu cobalt au survol */
    }
    
    .tmk-dropdown-toggle i {
      font-size: 12px;
      transition: transform 0.3s ease, color 0.3s ease;
    }
    
    .tmk-dropdown.active .tmk-dropdown-toggle i {
      transform: rotate(180deg);
    }
    
    /* Menu dropdown */
    .tmk-dropdown-menu {
      position: absolute;
      top: 100%;
      left: 0;
      background: #ffffff; /* Fond blanc pour le menu déroulant */
      min-width: 220px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.08);
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.3s ease;
    }
    
    .tmk-dropdown-menu.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    
    .tmk-dropdown-item {
      display: block;
      padding: 12px 18px;
      color: #000000;
      text-decoration: none;
      font-size: 13px;
      font-weight: 700;
      border-bottom: 1px solid rgba(0,0,0,0.08);
      transition: background 0.2s ease, color 0.2s ease;
    }
    
    .tmk-dropdown-item:hover {
      background: #5B8FD9; /* Fond bleu cobalt pâle au survol des sous-menus */
      color: #ffffff;       /* Texte blanc au survol des sous-menus */
    }
    
    .tmk-dropdown-item:last-child {
      border-bottom: none;
    }
    
    .tmk-dropdown-item.active {
      background: rgba(91, 143, 217, 0.2); /* Fond bleu cobalt pâle léger */
      color: #5B8FD9; /* Texte bleu cobalt pâle */
    }
    
    /* Bouton hamburger */
    .tmk-toggle {
      display: none;
      background: none;
      border: 2px solid rgba(0,0,0,0.7);
      border-radius: 4px;
      color: #000000;
      padding: 8px;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .tmk-toggle:hover {
      border-color: #5B8FD9; /* Bordure bleu cobalt pâle au survol */
      background: rgba(91,143,217,0.08); /* Fond bleu cobalt pâle très léger */
    }
    
    /* Mobile */
    @media (max-width: 992px) {
      .tmk-nav {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #ffffff; /* Fond blanc en mobile */
        flex-direction: column;
        padding: 0;
        box-shadow: 0 4px 8px rgba(0,0,0,0.08);
      }
      
      .tmk-nav.show {
        display: flex;
      }
      
      .tmk-nav-item {
        width: 100%;
      }
      
      .tmk-nav-link {
        padding: 15px 20px;
        border-bottom: 1px solid rgba(0,0,0,0.06);
      }
      
      .tmk-nav-link::after {
        display: none;
      }
      
      .tmk-dropdown-menu {
        position: static;
        opacity: 1;
        visibility: visible;
        transform: none;
        box-shadow: none;
        background: #ffffff; /* Fond blanc pour dropdown mobile */
        margin: 0;
        border-top: 1px solid #e5e7eb;
      }
      
      .tmk-dropdown-menu.show {
        display: block;
        max-height: 1000px;
        overflow: hidden;
        transition: max-height 0.3s ease;
      }
      
      .tmk-dropdown-menu:not(.show) {
        max-height: 0;
        overflow: hidden;
      }
      
      .tmk-dropdown-item {
        padding: 12px 40px;
        font-size: 12px;
      }
      
      .tmk-toggle {
        display: block;
      }
    }
    
    /* Compensation pour le header fixe */
    body {
      padding-top: 70px;
    }
  </style>
</head>

<body data-spy="scroll" data-target="#main-menu">
  <div id="pageloader">
    <div class="loader">
      <img src="images/progress.gif" alt="Chargement..." />
    </div>
  </div>

  <!-- NOUVEAU HEADER TMK -->
  <header class="tmk-header">
    <div class="tmk-header-content">
      <!-- Logo -->
      <div class="tmk-logo">
        <a href="index.php">
          <img src="images/logo.png" alt="Logo TMK" />
        </a>
      </div>

      <!-- Menu principal -->
      <nav class="tmk-nav">
        <?php
        // Récupérer le nom du fichier sans extension
        $currentPage = basename($_SERVER['REQUEST_URI'], ".php");
        $currentPage = str_replace('?', '', $currentPage);
        $currentPage = explode('&', $currentPage)[0];
        
        // Inclure la configuration de l'API
        require_once __DIR__ . '/api-config.php';
        
        // Fonction pour récupérer les liens depuis l'API Node.js ou fichier JSON
        function getNavLinksFromAPI() {
          apiLog("🔗 [HEADER] getNavLinksFromAPI() - Récupération des liens de navigation");
          
          $jsonFile = __DIR__ . '/../Backend/nav-links.json';
          
          // En mode API (production), toujours utiliser l'API distante d'abord
          if (defined('API_MODE') && API_MODE === 'api') {
            apiLog("🌐 [HEADER] Mode API actif - Appel de l'API distante...");
            $links = fetchFromApi('/api/links');
            if ($links) {
              apiLog("✅ [HEADER] " . count($links) . " liens récupérés depuis l'API");
              return $links;
            }
            
            apiLog("⚠️ [HEADER] API échouée, fallback fichier local...");
            // Fallback vers fichier local
            $localLinks = readLocalJson($jsonFile);
            if ($localLinks) {
              apiLog("✅ [HEADER] " . count($localLinks) . " liens récupérés depuis fichier local");
              return $localLinks;
            }
            return [];
          }
          
          // En mode local (développement), fichier JSON d'abord
          apiLog("📁 [HEADER] Mode LOCAL - Lecture fichier JSON d'abord...");
          $links = readLocalJson($jsonFile);
          if ($links) {
            apiLog("✅ [HEADER] " . count($links) . " liens récupérés depuis fichier local");
            return $links;
          }
          
          // Fallback vers l'API
          apiLog("⚠️ [HEADER] Fichier local non trouvé, fallback API...");
          return fetchFromApi('/api/links') ?: [];
        }
        
        // Fonction pour vérifier si une page est active
        function isPageActive($link, $currentPage) {
          if (isset($link['activePages']) && is_array($link['activePages'])) {
            return in_array($currentPage, $link['activePages']);
          }
          
          // Vérifier par défaut avec l'URL
          if (isset($link['href'])) {
            $hrefPage = basename($link['href'], ".php");
            $hrefPage = str_replace('?', '', $hrefPage);
            $hrefPage = explode('&', $hrefPage)[0];
            return $hrefPage === $currentPage;
          }
          
          return false;
        }
        
        // Récupérer les liens depuis l'API
        $navLinks = getNavLinksFromAPI();
        
        // Si aucun lien n'est retourné, utiliser les liens par défaut
        if (empty($navLinks)) {
          apiLog("⚠️ [HEADER] Aucun lien récupéré, utilisation des liens par défaut !");
          // Liens par défaut en cas d'erreur de connexion à l'API
          $navLinks = [
            ['type' => 'simple', 'label' => 'Accueil', 'href' => 'index.php', 'order' => 0, 'activePages' => ['index']],
            ['type' => 'simple', 'label' => 'À propos', 'href' => 'about.php', 'order' => 1, 'activePages' => ['about']],
            ['type' => 'simple', 'label' => 'Historique', 'href' => 'histoire.php', 'order' => 2, 'activePages' => ['histoire']],
            ['type' => 'simple', 'label' => 'Communauté', 'href' => 'equipe.php', 'order' => 3, 'activePages' => ['equipe']],
            ['type' => 'dropdown', 'label' => 'Nos réalisations', 'href' => '#', 'order' => 4, 'activePages' => ['realisationsphoto', 'realisationsvideo'], 'dropdownItems' => [
              ['label' => 'Nos photos', 'href' => 'realisationsphoto.php', 'order' => 0],
              ['label' => 'Nos vidéos', 'href' => 'realisationsvideo.php', 'order' => 1]
            ]],
            ['type' => 'dropdown', 'label' => 'Membres Services', 'href' => '#', 'order' => 5, 'dropdownItems' => [
              ['label' => 'Comité Administratif', 'href' => 'membreservice.php#comite', 'order' => 0],
              ['label' => 'Service des Ressources Humaines', 'href' => 'membreservice.php#rh', 'order' => 1],
              ['label' => 'Service Promotion et Planification', 'href' => 'membreservice.php#promotion', 'order' => 2],
              ['label' => 'Service Financière & Administrative', 'href' => 'membreservice.php#financiere', 'order' => 3],
              ['label' => 'Service de Logistique', 'href' => 'membreservice.php#logistique', 'order' => 4],
              ['label' => 'Service Relations Internationales', 'href' => 'membreservice.php#international', 'order' => 5],
              ['label' => 'Service Communication Digitale', 'href' => 'membreservice.php#communication', 'order' => 6],
              ['label' => 'Service Juridique', 'href' => 'membreservice.php#juridique', 'order' => 7]
            ]],
            ['type' => 'simple', 'label' => 'Contact', 'href' => 'contact.php', 'order' => 6, 'activePages' => ['contact']],
            ['type' => 'simple', 'label' => 'Status Juridique', 'href' => 'juridique.php', 'order' => 7, 'activePages' => ['juridique']]
          ];
        }
        
        // Trier les liens par ordre
        usort($navLinks, function($a, $b) {
          return ($a['order'] ?? 0) - ($b['order'] ?? 0);
        });
        
        // Forcer le libellé "Historique" pour le lien histoire.php (priorité sur API/JSON)
        foreach ($navLinks as &$link) {
          if (isset($link['href']) && (strpos($link['href'], 'histoire.php') !== false || (isset($link['activePages']) && in_array('histoire', (array)$link['activePages'])))) {
            $link['label'] = 'Historique';
            break;
          }
        }
        unset($link);
        
        // Supprimer le sous-élément "Vidéo TMK" du menu (source API ou JSON)
        foreach ($navLinks as &$link) {
          if (isset($link['type'], $link['dropdownItems']) && $link['type'] === 'dropdown' && is_array($link['dropdownItems'])) {
            $link['dropdownItems'] = array_values(array_filter($link['dropdownItems'], function ($item) {
              return trim($item['label'] ?? '') !== 'Vidéo TMK';
            }));
          }
        }
        unset($link);
        
        // Afficher les liens
        foreach ($navLinks as $link) {
          if (!isset($link['isActive']) || $link['isActive'] === true) {
            $isActive = isPageActive($link, $currentPage);
            
            if ($link['type'] === 'dropdown' && isset($link['dropdownItems']) && !empty($link['dropdownItems'])) {
              // Vérifier si un élément du dropdown est actif
              $dropdownActive = false;
              foreach ($link['dropdownItems'] as $item) {
                if (isPageActive($item, $currentPage)) {
                  $dropdownActive = true;
                  break;
                }
              }
              ?>
              <div class="tmk-nav-item tmk-dropdown <?= $dropdownActive ? 'active' : '' ?>">
                <a href="<?= htmlspecialchars($link['href'] ?? '#') ?>" class="tmk-nav-link tmk-dropdown-toggle">
                  <?= htmlspecialchars($link['label']) ?> <i class="fas fa-caret-down"></i>
                </a>
                <div class="tmk-dropdown-menu">
                  <?php
                  // Trier les éléments du dropdown par ordre
                  $items = $link['dropdownItems'];
                  usort($items, function($a, $b) {
                    return ($a['order'] ?? 0) - ($b['order'] ?? 0);
                  });
                  
                  foreach ($items as $item) {
                    if (!isset($item['isActive']) || $item['isActive'] === true) {
                      $itemActive = isPageActive($item, $currentPage);
                      ?>
                      <a href="<?= htmlspecialchars($item['href'] ?? '#') ?>" class="tmk-dropdown-item <?= $itemActive ? 'active' : '' ?>" data-navigation="true">
                        <?= htmlspecialchars($item['label']) ?>
                      </a>
                      <?php
                    }
                  }
                  ?>
                </div>
              </div>
              <?php
            } else {
              ?>
              <div class="tmk-nav-item">
                <a href="<?= htmlspecialchars($link['href'] ?? '#') ?>" class="tmk-nav-link <?= $isActive ? 'active' : '' ?>">
                  <?= htmlspecialchars($link['label']) ?>
                </a>
              </div>
              <?php
            }
          }
        }
        ?>
      </nav>

      <!-- Bouton hamburger mobile -->
      <button class="tmk-toggle" id="tmkToggle">
        <i class="fa fa-bars"></i>
      </button>
    </div>
  </header>

  <!-- Scripts -->
  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

  <script>
  jQuery(document).ready(function($) {
    // ===== NOUVEAU SYSTEME TMK =====
    
    const $header = $('.tmk-header');
    const $toggle = $('#tmkToggle');
    const $nav = $('.tmk-nav');
    
    // Fonction pour fermer tous les dropdowns
    function closeAllDropdowns() {
      $('.tmk-dropdown-menu').removeClass('show');
      $('.tmk-dropdown').removeClass('active');
    }
    
    // Fonction pour fermer le menu mobile
    function closeMobileMenu() {
      $nav.removeClass('show');
    }
    
    // Fonction pour vérifier si on est en mode mobile
    function isMobile() {
      return $(window).width() <= 992;
    }
    
    // Header scroll effect
    $(window).on('scroll', function() {
      if ($(window).scrollTop() > 50) {
        $header.addClass('scrolled');
      } else {
        $header.removeClass('scrolled');
      }
      
      // Fermer les dropdowns au scroll
      closeAllDropdowns();
    });
    
    // Toggle menu mobile
    $toggle.on('click', function(e) {
      e.preventDefault();
      $nav.toggleClass('show');
    });
    
    // Gestion des dropdowns
    $('.tmk-dropdown').each(function() {
      const $dropdown = $(this);
      const $toggle = $dropdown.find('.tmk-dropdown-toggle');
      const $menu = $dropdown.find('.tmk-dropdown-menu');
      
      $toggle.on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const isOpen = $menu.hasClass('show');
        
        if (isMobile()) {
          // En mobile, toggle simple
          closeAllDropdowns();
          if (!isOpen) {
            $menu.addClass('show');
            $dropdown.addClass('active');
          }
        } else {
          // En desktop, fermer les autres et ouvrir celui-ci
          closeAllDropdowns();
          if (!isOpen) {
            $menu.addClass('show');
            $dropdown.addClass('active');
          }
        }
      });
      
      // Gestion des clics sur les éléments dropdown
      $menu.on('click', '.tmk-dropdown-item', function(e) {
        const $item = $(this);
        const href = $item.attr('href');
        
        // Navigation vers une page
        if ($item.attr('data-navigation') === 'true') {
          if (isMobile()) {
            closeMobileMenu();
          }
          return;
        }
        
        // Navigation vers une ancre
        if (href && href.startsWith('#')) {
          e.preventDefault();
          const $target = $(href);
          
          if ($target.length) {
            if (isMobile()) {
              closeMobileMenu();
            }
            
            setTimeout(function() {
              const headerHeight = $header.outerHeight() || 70;
              $('html, body').animate({
                scrollTop: $target.offset().top - headerHeight - 20
              }, 600);
            }, isMobile() ? 300 : 100);
          }
        }
        
        // Fermer le dropdown après clic
        setTimeout(function() {
          closeAllDropdowns();
        }, 100);
      });
    });
    
    // Fermer les dropdowns en cliquant ailleurs
    $(document).on('click', function(e) {
      if (!$(e.target).closest('.tmk-dropdown').length && !$(e.target).closest('#tmkToggle').length) {
        closeAllDropdowns();
      }
    });
    
    // Fermer le menu mobile en cliquant sur un lien normal
    $('.tmk-nav-link:not(.tmk-dropdown-toggle)').on('click', function() {
      if (isMobile()) {
        setTimeout(function() {
          closeMobileMenu();
        }, 100);
      }
    });
    
    // Gestion du redimensionnement
    let resizeTimer;
    $(window).on('resize', function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function() {
        closeAllDropdowns();
        closeMobileMenu();
      }, 250);
    });
    
    // Scroll smooth pour les ancres
    $('.tmk-nav a[href^="#"]').on('click', function(e) {
      const href = $(this).attr('href');
      
      if (!href || href === '#') {
        e.preventDefault();
        return;
      }
      
      const $target = $(href);
      if ($target.length) {
        e.preventDefault();
        
        if (isMobile()) {
          closeMobileMenu();
        }
        
        const headerHeight = $header.outerHeight() || 70;
        $('html, body').stop().animate({
          scrollTop: $target.offset().top - headerHeight - 20
        }, 600);
      }
    });
    
    // Cacher le pageloader
    $('#pageloader').fadeOut('slow');
  });
  </script>