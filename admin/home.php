<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/partials.php';

$data = tmk_content('home', tmk_defaults('home'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!tmk_csrf_check()) {
        tmk_flash("Session expirée, réessayez.", 'error');
        header('Location: home.php');
        exit;
    }

    // ── En-tête (hero) ──
    $currentVideo = $data['hero']['videoUrl'] ?? 'images/1.mp4';
    $newVideo = tmk_handle_upload('hero_video', ['mp4', 'webm', 'ogg'], $currentVideo);
    // Si un chemin a été saisi manuellement et qu'aucun fichier n'a été uploadé
    if ($newVideo === $currentVideo && !empty(trim($_POST['hero_videoUrl'] ?? ''))) {
        $newVideo = trim($_POST['hero_videoUrl']);
    }

    $data['hero'] = [
        'videoUrl'         => $newVideo,
        'title'            => trim($_POST['hero_title'] ?? ''),
        'subtitle'         => trim($_POST['hero_subtitle'] ?? ''),
        'donateButtonText' => trim($_POST['hero_donate'] ?? ''),
        'videoButtonText'  => trim($_POST['hero_videoBtn'] ?? ''),
    ];

    // ── Mission & Vision ──
    $data['missionVision'] = [
        'sectionTitle' => trim($_POST['mv_sectionTitle'] ?? ''),
        'missionTitle' => trim($_POST['mv_missionTitle'] ?? ''),
        'missionText'  => trim($_POST['mv_missionText'] ?? ''),
        'visionTitle'  => trim($_POST['mv_visionTitle'] ?? ''),
        'visionText'   => trim($_POST['mv_visionText'] ?? ''),
    ];

    // ── Actualités ──
    $items = [];
    $titles = $_POST['news_title'] ?? [];
    foreach ($titles as $i => $t) {
        $t = trim($t);
        $text = trim($_POST['news_text'][$i] ?? '');
        if ($t === '' && $text === '') {
            continue; // ignorer les lignes vides
        }
        $items[] = [
            'meta'     => trim($_POST['news_meta'][$i] ?? ''),
            'title'    => $t,
            'text'     => $text,
            'linkText' => trim($_POST['news_linkText'][$i] ?? 'En savoir plus'),
            'link'     => trim($_POST['news_link'][$i] ?? '#') ?: '#',
        ];
    }
    $data['news'] = [
        'sectionTitle' => trim($_POST['news_sectionTitle'] ?? ''),
        'subtitle'     => trim($_POST['news_subtitle'] ?? ''),
        'items'        => $items,
    ];

    if (tmk_save_content('home', $data)) {
        tmk_flash("Page d'accueil mise à jour avec succès.");
    } else {
        tmk_flash("Erreur lors de l'enregistrement (vérifiez les permissions du dossier /content).", 'error');
    }
    header('Location: home.php');
    exit;
}

$hero = $data['hero'];
$mv = $data['missionVision'];
$news = $data['news'];

admin_header('home', "Accueil");
?>

<form method="post" enctype="multipart/form-data">
    <?= tmk_csrf_field() ?>

    <!-- EN-TÊTE -->
    <div class="card mb-4">
        <div class="card-header"><i class="fa-solid fa-heading text-primary"></i> En-tête de la page (vidéo de fond + textes)</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Vidéo de fond actuelle</label>
                    <?php $vu = $hero['videoUrl']; ?>
                    <div class="mb-2">
                        <video src="../<?= htmlspecialchars($vu) ?>" class="thumb" style="max-height:120px" muted></video>
                    </div>
                    <input type="file" name="hero_video" accept="video/mp4,video/webm" class="form-control">
                    <small class="text-muted">Laissez vide pour conserver la vidéo actuelle. Formats : mp4, webm.</small>
                    <input type="text" name="hero_videoUrl" class="form-control mt-2" value="<?= htmlspecialchars($vu) ?>" placeholder="ou chemin: images/1.mp4">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Titre principal</label>
                    <input type="text" name="hero_title" class="form-control mb-3" value="<?= htmlspecialchars($hero['title']) ?>">
                    <label class="form-label">Sous-titre</label>
                    <input type="text" name="hero_subtitle" class="form-control" value="<?= htmlspecialchars($hero['subtitle']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Texte du bouton « Faire un don »</label>
                    <input type="text" name="hero_donate" class="form-control" value="<?= htmlspecialchars($hero['donateButtonText']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Texte du bouton « Voir notre vidéo »</label>
                    <input type="text" name="hero_videoBtn" class="form-control" value="<?= htmlspecialchars($hero['videoButtonText']) ?>">
                </div>
            </div>
        </div>
    </div>

    <!-- MISSION & VISION -->
    <div class="card mb-4">
        <div class="card-header"><i class="fa-solid fa-bullseye text-primary"></i> Notre mission &amp; notre vision</div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Titre de la section</label>
                <input type="text" name="mv_sectionTitle" class="form-control" value="<?= htmlspecialchars($mv['sectionTitle']) ?>">
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Titre « Mission »</label>
                    <input type="text" name="mv_missionTitle" class="form-control mb-2" value="<?= htmlspecialchars($mv['missionTitle']) ?>">
                    <label class="form-label">Texte de la mission</label>
                    <textarea name="mv_missionText" class="form-control" rows="5"><?= htmlspecialchars($mv['missionText']) ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Titre « Vision »</label>
                    <input type="text" name="mv_visionTitle" class="form-control mb-2" value="<?= htmlspecialchars($mv['visionTitle']) ?>">
                    <label class="form-label">Texte de la vision</label>
                    <textarea name="mv_visionText" class="form-control" rows="5"><?= htmlspecialchars($mv['visionText']) ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- ACTUALITÉS -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fa-solid fa-newspaper text-primary"></i> Actualités</span>
            <button type="button" class="btn btn-sm btn-tmk" onclick="tmkAddItem('newsList','newsTpl')">
                <i class="fa-solid fa-plus"></i> Ajouter une actualité
            </button>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-3">
                <div class="col-md-5">
                    <label class="form-label">Titre de la section</label>
                    <input type="text" name="news_sectionTitle" class="form-control" value="<?= htmlspecialchars($news['sectionTitle']) ?>">
                </div>
                <div class="col-md-7">
                    <label class="form-label">Sous-titre</label>
                    <input type="text" name="news_subtitle" class="form-control" value="<?= htmlspecialchars($news['subtitle']) ?>">
                </div>
            </div>

            <div id="newsList">
                <?php foreach ($news['items'] as $n): ?>
                    <div class="repeat-item">
                        <button type="button" class="btn btn-sm btn-outline-danger position-absolute" style="top:10px;right:10px" onclick="tmkRemoveItem(this)"><i class="fa-solid fa-trash"></i></button>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label">Catégorie (étiquette)</label>
                                <input type="text" name="news_meta[]" class="form-control" value="<?= htmlspecialchars($n['meta'] ?? '') ?>">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Titre</label>
                                <input type="text" name="news_title[]" class="form-control" value="<?= htmlspecialchars($n['title'] ?? '') ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Texte</label>
                                <textarea name="news_text[]" class="form-control" rows="3"><?= htmlspecialchars($n['text'] ?? '') ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Texte du lien</label>
                                <input type="text" name="news_linkText[]" class="form-control" value="<?= htmlspecialchars($n['linkText'] ?? 'En savoir plus') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Lien (URL)</label>
                                <input type="text" name="news_link[]" class="form-control" value="<?= htmlspecialchars($n['link'] ?? '#') ?>">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-5">
        <a href="index.php" class="btn btn-light">Annuler</a>
        <button type="submit" class="btn btn-tmk px-4"><i class="fa-solid fa-floppy-disk"></i> Enregistrer</button>
    </div>
</form>

<!-- Modèle d'actualité (pour l'ajout dynamique) -->
<template id="newsTpl">
    <div class="repeat-item">
        <button type="button" class="btn btn-sm btn-outline-danger position-absolute" style="top:10px;right:10px" onclick="tmkRemoveItem(this)"><i class="fa-solid fa-trash"></i></button>
        <div class="row g-2">
            <div class="col-md-4">
                <label class="form-label">Catégorie (étiquette)</label>
                <input type="text" name="news_meta[]" class="form-control">
            </div>
            <div class="col-md-8">
                <label class="form-label">Titre</label>
                <input type="text" name="news_title[]" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Texte</label>
                <textarea name="news_text[]" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Texte du lien</label>
                <input type="text" name="news_linkText[]" class="form-control" value="En savoir plus">
            </div>
            <div class="col-md-6">
                <label class="form-label">Lien (URL)</label>
                <input type="text" name="news_link[]" class="form-control" value="#">
            </div>
        </div>
    </div>
</template>

<?php admin_footer(); ?>
