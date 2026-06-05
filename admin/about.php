<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/partials.php';

$data = tmk_content('about', tmk_defaults('about'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!tmk_csrf_check()) {
        tmk_flash("Session expirée, réessayez.", 'error');
        header('Location: about.php');
        exit;
    }

    $data['sectionTitle']       = trim($_POST['sectionTitle'] ?? '');
    $data['sectionDescription'] = trim($_POST['sectionDescription'] ?? '');

    $services = [];
    $titles = $_POST['svc_title'] ?? [];
    foreach ($titles as $i => $t) {
        $t = trim($t);
        if ($t === '') {
            continue;
        }
        $services[] = [
            'icon'        => trim($_POST['svc_icon'][$i] ?? 'fa fa-heart') ?: 'fa fa-heart',
            'iconClass'   => trim($_POST['svc_iconClass'][$i] ?? 'humanitarian') ?: 'humanitarian',
            'title'       => $t,
            'description' => trim($_POST['svc_description'][$i] ?? ''),
            'buttonText'  => trim($_POST['svc_buttonText'][$i] ?? 'LIRE'),
            'buttonLink'  => trim($_POST['svc_buttonLink'][$i] ?? '#') ?: '#',
        ];
    }
    $data['services'] = $services;

    if (tmk_save_content('about', $data)) {
        tmk_flash("Page À propos mise à jour avec succès.");
    } else {
        tmk_flash("Erreur lors de l'enregistrement.", 'error');
    }
    header('Location: about.php');
    exit;
}

admin_header('about', "Domaines d'intervention");

function svc_card($s)
{
    ob_start();
    ?>
    <div class="repeat-item">
        <button type="button" class="btn btn-sm btn-outline-danger position-absolute" style="top:10px;right:10px" onclick="tmkRemoveItem(this)"><i class="fa-solid fa-trash"></i></button>
        <div class="row g-2">
            <div class="col-md-8">
                <label class="form-label">Titre</label>
                <input type="text" name="svc_title[]" class="form-control" value="<?= htmlspecialchars($s['title'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Icône (Font Awesome)</label>
                <input type="text" name="svc_icon[]" class="form-control" value="<?= htmlspecialchars($s['icon'] ?? 'fa fa-heart') ?>" placeholder="fa fa-heart">
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="svc_description[]" class="form-control" rows="2"><?= htmlspecialchars($s['description'] ?? '') ?></textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label">Classe couleur</label>
                <select name="svc_iconClass[]" class="form-select">
                    <?php
                    $opts = ['humanitarian' => 'Rouge', 'education' => 'Bleu', 'health' => 'Vert', 'marginalized' => 'Violet'];
                    $cur = $s['iconClass'] ?? 'humanitarian';
                    foreach ($opts as $val => $lbl) {
                        echo '<option value="' . $val . '"' . ($cur === $val ? ' selected' : '') . '>' . $lbl . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Texte du bouton</label>
                <input type="text" name="svc_buttonText[]" class="form-control" value="<?= htmlspecialchars($s['buttonText'] ?? 'LIRE') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Lien du bouton</label>
                <input type="text" name="svc_buttonLink[]" class="form-control" value="<?= htmlspecialchars($s['buttonLink'] ?? '#') ?>">
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>
<form method="post">
    <?= tmk_csrf_field() ?>

    <div class="card mb-4">
        <div class="card-header"><i class="fa-solid fa-heading text-primary"></i> Titre de la section</div>
        <div class="card-body row g-3">
            <div class="col-12">
                <label class="form-label">Titre</label>
                <input type="text" name="sectionTitle" class="form-control" value="<?= htmlspecialchars($data['sectionTitle']) ?>">
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="sectionDescription" class="form-control" rows="2"><?= htmlspecialchars($data['sectionDescription']) ?></textarea>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fa-solid fa-grip text-primary"></i> Cartes des domaines</span>
            <button type="button" class="btn btn-sm btn-tmk" onclick="tmkAddItem('svcList','svcTpl')"><i class="fa-solid fa-plus"></i> Ajouter une carte</button>
        </div>
        <div class="card-body">
            <div id="svcList">
                <?php foreach ($data['services'] as $s) {
                    echo svc_card($s);
                } ?>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-5">
        <a href="index.php" class="btn btn-light">Annuler</a>
        <button type="submit" class="btn btn-tmk px-4"><i class="fa-solid fa-floppy-disk"></i> Enregistrer</button>
    </div>
</form>

<template id="svcTpl"><?= svc_card([]) ?></template>

<?php admin_footer(); ?>
