<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/partials.php';

$data = tmk_content('photos', tmk_defaults('photos'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!tmk_csrf_check()) {
        tmk_flash("Session expirée, réessayez.", 'error');
        header('Location: photos.php');
        exit;
    }

    $albums = [];
    $titles = $_POST['alb_title'] ?? [];
    $imgExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    foreach ($titles as $i => $t) {
        $t = trim($t);
        if ($t === '') {
            continue;
        }
        $current = trim($_POST['alb_current_image'][$i] ?? '');
        $image = tmk_handle_upload_indexed('alb_image', $i, $imgExt, $current);
        $albums[] = [
            'title'        => $t,
            'description'  => trim($_POST['alb_description'][$i] ?? ''),
            'main_image'   => $image,
            'album_type'   => trim($_POST['alb_type'][$i] ?? ''),
            'year'         => trim($_POST['alb_year'][$i] ?? ''),
            'photos_count' => (int) ($_POST['alb_count'][$i] ?? 0),
            'link'         => trim($_POST['alb_link'][$i] ?? '#') ?: '#',
        ];
    }
    $data['albums'] = $albums;

    if (tmk_save_content('photos', $data)) {
        tmk_flash("Albums photos mis à jour avec succès.");
    } else {
        tmk_flash("Erreur lors de l'enregistrement.", 'error');
    }
    header('Location: photos.php');
    exit;
}

admin_header('photos', "Photos / Albums");

function album_card($a)
{
    $img = $a['main_image'] ?? '';
    ob_start();
    ?>
    <div class="repeat-item">
        <button type="button" class="btn btn-sm btn-outline-danger position-absolute" style="top:10px;right:10px" onclick="tmkRemoveItem(this)"><i class="fa-solid fa-trash"></i></button>
        <div class="row g-2">
            <div class="col-md-3 text-center">
                <label class="form-label d-block">Image de couverture</label>
                <?php if ($img): ?>
                    <img src="../<?= htmlspecialchars($img) ?>" class="thumb mb-2" onerror="this.style.display='none'">
                <?php endif; ?>
                <input type="hidden" name="alb_current_image[]" value="<?= htmlspecialchars($img) ?>">
                <input type="file" name="alb_image[]" accept="image/*" class="form-control form-control-sm">
            </div>
            <div class="col-md-9">
                <div class="row g-2">
                    <div class="col-md-8">
                        <label class="form-label">Titre</label>
                        <input type="text" name="alb_title[]" class="form-control" value="<?= htmlspecialchars($a['title'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Catégorie</label>
                        <input type="text" name="alb_type[]" class="form-control" value="<?= htmlspecialchars($a['album_type'] ?? '') ?>" placeholder="Social, Santé...">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="alb_description[]" class="form-control" rows="2"><?= htmlspecialchars($a['description'] ?? '') ?></textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Année</label>
                        <input type="text" name="alb_year[]" class="form-control" value="<?= htmlspecialchars($a['year'] ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nb. photos</label>
                        <input type="number" name="alb_count[]" class="form-control" value="<?= (int) ($a['photos_count'] ?? 0) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lien (page de l'album)</label>
                        <input type="text" name="alb_link[]" class="form-control" value="<?= htmlspecialchars($a['link'] ?? '#') ?>">
                    </div>
                </div>
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
            <span><i class="fa-solid fa-images text-primary"></i> Albums photos (page « Nos réalisations » → Photos)</span>
            <button type="button" class="btn btn-sm btn-tmk" onclick="tmkAddItem('albList','albTpl')"><i class="fa-solid fa-plus"></i> Ajouter un album</button>
        </div>
        <div class="card-body">
            <div id="albList">
                <?php foreach ($data['albums'] as $a) {
                    echo album_card($a);
                } ?>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-5">
        <a href="index.php" class="btn btn-light">Annuler</a>
        <button type="submit" class="btn btn-tmk px-4"><i class="fa-solid fa-floppy-disk"></i> Enregistrer</button>
    </div>
</form>

<template id="albTpl"><?= album_card([]) ?></template>

<?php admin_footer(); ?>
