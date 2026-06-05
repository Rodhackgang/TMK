<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/partials.php';

$data = tmk_content('videos', tmk_defaults('videos'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!tmk_csrf_check()) {
        tmk_flash("Session expirée, réessayez.", 'error');
        header('Location: videos.php');
        exit;
    }

    $videos = [];
    $titles = $_POST['vid_title'] ?? [];
    foreach ($titles as $i => $t) {
        $t = trim($t);
        if ($t === '') {
            continue;
        }
        // Fichier vidéo : upload prioritaire, sinon chemin existant / saisi
        $currentPath = trim($_POST['vid_current_path'][$i] ?? '');
        $path = tmk_handle_upload_indexed('vid_file', $i, ['mp4', 'webm', 'ogg', 'mov'], $currentPath);
        if ($path === $currentPath && !empty(trim($_POST['vid_path'][$i] ?? ''))) {
            $path = trim($_POST['vid_path'][$i]);
        }
        // Image d'aperçu (facultatif)
        $currentPrev = trim($_POST['vid_current_preview'][$i] ?? '');
        $preview = tmk_handle_upload_indexed('vid_preview', $i, ['jpg', 'jpeg', 'png', 'gif', 'webp'], $currentPrev);

        $videos[] = [
            'video_path'    => $path,
            'preview_image' => $preview,
            'title'         => $t,
            'description'   => trim($_POST['vid_description'][$i] ?? ''),
            'category'      => trim($_POST['vid_category'][$i] ?? 'Vidéo') ?: 'Vidéo',
        ];
    }
    $data['videos'] = $videos;

    if (tmk_save_content('videos', $data)) {
        tmk_flash("Vidéos mises à jour avec succès.");
    } else {
        tmk_flash("Erreur lors de l'enregistrement.", 'error');
    }
    header('Location: videos.php');
    exit;
}

admin_header('videos', "Vidéos");

function video_card($v)
{
    $path = $v['video_path'] ?? '';
    $prev = $v['preview_image'] ?? '';
    ob_start();
    ?>
    <div class="repeat-item">
        <button type="button" class="btn btn-sm btn-outline-danger position-absolute" style="top:10px;right:10px" onclick="tmkRemoveItem(this)"><i class="fa-solid fa-trash"></i></button>
        <div class="row g-2">
            <div class="col-md-8">
                <label class="form-label">Titre</label>
                <input type="text" name="vid_title[]" class="form-control" value="<?= htmlspecialchars($v['title'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Catégorie</label>
                <input type="text" name="vid_category[]" class="form-control" value="<?= htmlspecialchars($v['category'] ?? 'Vidéo') ?>">
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="vid_description[]" class="form-control" rows="2"><?= htmlspecialchars($v['description'] ?? '') ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Fichier vidéo</label>
                <?php if ($path): ?><div class="small text-muted mb-1"><i class="fa-solid fa-film"></i> <?= htmlspecialchars($path) ?></div><?php endif; ?>
                <input type="hidden" name="vid_current_path[]" value="<?= htmlspecialchars($path) ?>">
                <input type="file" name="vid_file[]" accept="video/mp4,video/webm" class="form-control form-control-sm">
                <input type="text" name="vid_path[]" class="form-control form-control-sm mt-1" value="<?= htmlspecialchars($path) ?>" placeholder="ou chemin: 1.mp4">
            </div>
            <div class="col-md-6">
                <label class="form-label">Image d'aperçu (facultatif)</label>
                <?php if ($prev): ?><img src="../<?= htmlspecialchars($prev) ?>" class="thumb mb-1 d-block" style="max-height:60px" onerror="this.style.display='none'"><?php endif; ?>
                <input type="hidden" name="vid_current_preview[]" value="<?= htmlspecialchars($prev) ?>">
                <input type="file" name="vid_preview[]" accept="image/*" class="form-control form-control-sm">
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>
<form method="post" enctype="multipart/form-data">
    <?= tmk_csrf_field() ?>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fa-solid fa-video text-primary"></i> Vidéos (page « Nos réalisations » → Vidéos)</span>
            <button type="button" class="btn btn-sm btn-tmk" onclick="tmkAddItem('vidList','vidTpl')"><i class="fa-solid fa-plus"></i> Ajouter une vidéo</button>
        </div>
        <div class="card-body">
            <div id="vidList">
                <?php foreach ($data['videos'] as $v) {
                    echo video_card($v);
                } ?>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-5">
        <a href="index.php" class="btn btn-light">Annuler</a>
        <button type="submit" class="btn btn-tmk px-4"><i class="fa-solid fa-floppy-disk"></i> Enregistrer</button>
    </div>
</form>

<template id="vidTpl"><?= video_card([]) ?></template>

<?php admin_footer(); ?>
