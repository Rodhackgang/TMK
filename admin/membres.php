<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/partials.php';

$data = tmk_content('members', tmk_defaults('members'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!tmk_csrf_check()) {
        tmk_flash("Session expirée, réessayez.", 'error');
        header('Location: membres.php');
        exit;
    }

    $data['sectionTitle'] = trim($_POST['sectionTitle'] ?? 'Nos Membres');

    $members = [];
    $names = $_POST['mem_name'] ?? [];
    foreach ($names as $i => $n) {
        $n = trim($n);
        $poste = trim($_POST['mem_poste'][$i] ?? '');
        if ($n === '' && $poste === '') {
            continue;
        }
        $current = trim($_POST['mem_current_image'][$i] ?? '');
        $image = tmk_handle_upload_indexed('mem_image', $i, ['jpg', 'jpeg', 'png', 'gif', 'webp'], $current);
        $members[] = [
            'name'  => $n,
            'poste' => $poste,
            'image' => $image ?: 'images/member1.jpg',
        ];
    }
    $data['members'] = $members;

    if (tmk_save_content('members', $data)) {
        tmk_flash("Membres mis à jour avec succès.");
    } else {
        tmk_flash("Erreur lors de l'enregistrement.", 'error');
    }
    header('Location: membres.php');
    exit;
}

admin_header('membres', "Membres");

function member_card($m)
{
    $img = $m['image'] ?? '';
    ob_start();
    ?>
    <div class="repeat-item">
        <button type="button" class="btn btn-sm btn-outline-danger position-absolute" style="top:10px;right:10px" onclick="tmkRemoveItem(this)"><i class="fa-solid fa-trash"></i></button>
        <div class="row g-2 align-items-center">
            <div class="col-md-3 text-center">
                <label class="form-label d-block">Photo (visage)</label>
                <?php if ($img): ?>
                    <img src="../<?= htmlspecialchars($img) ?>" class="thumb mb-2" style="width:80px;height:80px;object-fit:cover;border-radius:50%" onerror="this.style.display='none'">
                <?php endif; ?>
                <input type="hidden" name="mem_current_image[]" value="<?= htmlspecialchars($img) ?>">
                <input type="file" name="mem_image[]" accept="image/*" class="form-control form-control-sm">
            </div>
            <div class="col-md-9">
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Nom</label>
                        <input type="text" name="mem_name[]" class="form-control" value="<?= htmlspecialchars($m['name'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Poste / Fonction</label>
                        <input type="text" name="mem_poste[]" class="form-control" value="<?= htmlspecialchars($m['poste'] ?? '') ?>" placeholder="Ex: Président, Secrétaire...">
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
        <div class="card-header"><i class="fa-solid fa-heading text-primary"></i> Titre de la section</div>
        <div class="card-body">
            <input type="text" name="sectionTitle" class="form-control" value="<?= htmlspecialchars($data['sectionTitle']) ?>">
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fa-solid fa-users text-primary"></i> Membres (page « Membres Services »)</span>
            <button type="button" class="btn btn-sm btn-tmk" onclick="tmkAddItem('memList','memTpl')"><i class="fa-solid fa-plus"></i> Ajouter un membre</button>
        </div>
        <div class="card-body">
            <div id="memList">
                <?php foreach ($data['members'] as $m) {
                    echo member_card($m);
                } ?>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-5">
        <a href="index.php" class="btn btn-light">Annuler</a>
        <button type="submit" class="btn btn-tmk px-4"><i class="fa-solid fa-floppy-disk"></i> Enregistrer</button>
    </div>
</form>

<template id="memTpl"><?= member_card([]) ?></template>

<?php admin_footer(); ?>
