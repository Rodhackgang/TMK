<?php
require './utils/header.php';
require_once './utils/api-config.php';

// Lire le contenu : toujours privilégier le fichier JSON local (même dossier que ce script)
$jsonFile = __DIR__ . DIRECTORY_SEPARATOR . 'Backend' . DIRECTORY_SEPARATOR . 'history-content.json';
$historyContent = [];
if (file_exists($jsonFile)) {
    $raw = @file_get_contents($jsonFile);
    if ($raw !== false) {
        $decoded = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && isset($decoded['sections'])) {
            $historyContent = $decoded;
        }
    }
}
if (empty($historyContent['sections'])) {
    $historyContent = getContentFromJsonOrApi($jsonFile, '/api/content/history');
}

// Valeurs par défaut
$pageTitle = $historyContent['pageTitle'] ?? 'Histoire de TMK Foundation';
$logoUrl = $historyContent['logoUrl'] ?? '../images/logo.png';
$mainTitle = $historyContent['mainTitle'] ?? 'The Miracle Kingdom';
$sections = $historyContent['sections'] ?? [];

// Fonction pour afficher une section
function renderSection($section) {
    $type = $section['type'] ?? '';
    $content = $section['content'] ?? '';
    $centered = $section['centered'] ?? false;
    
    switch($type) {
        case 'heading':
            $level = $section['level'] ?? 2;
            $cls = 'histoire-heading histoire-h' . (int)$level;
            echo "<h{$level} class=\"{$cls}\">" . htmlspecialchars($content) . "</h{$level}>";
            break;
            
        case 'paragraph':
            echo '<p class="histoire-para">' . htmlspecialchars($content) . '</p>';
            break;
            
        case 'list':
            $items = $section['items'] ?? [];
            echo '<ul class="histoire-list">';
            foreach ($items as $item) {
                echo '<li>' . htmlspecialchars($item) . '</li>';
            }
            echo '</ul>';
            break;
            
        case 'image':
            echo '<div class="histoire-img-wrap' . ($centered ? ' histoire-img-center' : '') . '">';
            echo '<img src="' . htmlspecialchars($content) . '" alt="" class="histoire-img">';
            echo '</div>';
            break;
            
        case 'images':
            $images = $section['images'] ?? [];
            echo '<div class="histoire-imgs-wrap' . ($centered ? ' histoire-img-center' : '') . '">';
            foreach ($images as $img) {
                echo '<img src="' . htmlspecialchars($img) . '" alt="" class="histoire-img">';
            }
            echo '</div>';
            break;
    }
}
?>


<!-- Page Header : logo TMK (comme À propos) -->
<section id="page-header" class="parallax page-header--logo">
  <div class="page-header-logo">
    <img src="images/tmk-header.png" alt="TMK - The Miracle Kingdom" class="tmk-logo-img">
  </div>
  <div class="overlay"></div>
</section>

<!-- Contenu Histoire -->
<section id="history" class="section">
  <div class="container">
    <div class="title-box text-center title-box--about">
      <h2 class="title"><?php echo htmlspecialchars($pageTitle); ?></h2>
    </div>

    <div id="histoires" class="histoire-content">
            <h2 class="histoire-main-title"><?php echo htmlspecialchars($mainTitle); ?></h2>
            
            <?php
            if (!empty($sections)) {
                foreach ($sections as $section) {
                    renderSection($section);
                }
            }
 ?>

        </div>
</section>

<style>
/* ===== Page Histoire – Mise en forme ===== */
#history.section {
    background: linear-gradient(180deg, #fafbfc 0%, #f0f4f8 100%);
    padding: 3rem 0 4rem;
}
#history .container {
    max-width: 820px;
}
#history .title-box .title {
    font-family: 'Raleway', sans-serif;
    font-weight: 700;
    color: #2c3e50;
    letter-spacing: 0.02em;
    margin-bottom: 2rem;
}

/* Bloc principal du récit */
#histoires.histoire-content {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    padding: 2.5rem 2.5rem 3rem;
    border: 1px solid rgba(52, 152, 219, 0.2);
}

/* Titre principal (The Miracle Kingdom) */
#histoires .histoire-main-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 2rem;
    font-weight: 600;
    color: #1a2a3a;
    text-align: center;
    margin: 0 0 2.5rem;
    padding-bottom: 1.25rem;
    border-bottom: 3px solid #3498db;
    letter-spacing: 0.03em;
    text-transform: none;
}

/* Titres de sections */
#histoires .histoire-heading {
    font-family: 'Raleway', sans-serif;
    font-weight: 700;
    color: #2c3e50;
    margin-top: 2.25rem;
    margin-bottom: 1rem;
    line-height: 1.35;
    text-transform: none;
    letter-spacing: 0.02em;
}
#histoires .histoire-h3 {
    font-size: 1.35rem;
    padding-left: 1rem;
    border-left: 4px solid #3498db;
}
#histoires .histoire-h4 {
    font-size: 1.15rem;
    color: #34495e;
    padding-left: 0.75rem;
    border-left: 3px solid rgba(52, 152, 219, 0.6);
}

/* Paragraphes */
#histoires .histoire-para {
    font-size: 1rem;
    line-height: 1.75;
    color: #4a5568;
    margin-bottom: 1.25rem;
    max-width: 100%;
}

/* Listes à puces */
#histoires .histoire-list {
    list-style: none;
    padding-left: 0;
    margin: 1rem 0 1.5rem;
}
#histoires .histoire-list li {
    position: relative;
    padding-left: 1.75rem;
    margin-bottom: 0.65rem;
    font-size: 1rem;
    line-height: 1.6;
    color: #4a5568;
}
#histoires .histoire-list li::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0.5rem;
    width: 8px;
    height: 8px;
    background: #3498db;
    border-radius: 50%;
}
#histoires .histoire-list li:last-child {
    margin-bottom: 0;
}

/* Images */
#histoires .histoire-img-wrap,
#histoires .histoire-imgs-wrap {
    margin: 1.75rem 0;
}
#histoires .histoire-img-center {
    text-align: center;
}
#histoires .histoire-img {
    max-width: 100%;
    width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.06);
}
#histoires .histoire-img-center .histoire-img {
    max-width: 520px;
    margin: 0 auto;
    display: block;
}
#histoires .histoire-imgs-wrap .histoire-img {
    width: auto;
    max-width: 400px;
    margin: 0.5rem;
    display: inline-block;
    vertical-align: top;
}

@media (max-width: 768px) {
    #histoires.histoire-content {
        padding: 1.5rem 1.25rem 2rem;
    }
    #histoires .histoire-main-title {
        font-size: 1.5rem;
    }
    #histoires .histoire-h3 {
        font-size: 1.2rem;
    }
}
</style>

<?php
require './utils/footer.php'
?>
