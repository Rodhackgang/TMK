<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/partials.php';

$data = tmk_content('contact', tmk_defaults('contact'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!tmk_csrf_check()) {
        tmk_flash("Session expirée, réessayez.", 'error');
        header('Location: contact.php');
        exit;
    }

    $data['sectionTitle']  = trim($_POST['sectionTitle'] ?? '');
    $data['infoTitle']     = trim($_POST['infoTitle'] ?? '');
    $data['phoneLabel']    = trim($_POST['phoneLabel'] ?? 'Téléphone');
    $data['phoneNumber']   = trim($_POST['phoneNumber'] ?? '');
    $data['emailLabel']    = trim($_POST['emailLabel'] ?? 'Email');
    $data['emailAddress']  = trim($_POST['emailAddress'] ?? '');
    $data['addressLabel']  = trim($_POST['addressLabel'] ?? 'Adresse');
    $data['addressLine1']  = trim($_POST['addressLine1'] ?? '');
    $data['addressLine2']  = trim($_POST['addressLine2'] ?? '');
    $data['socialTitle']   = trim($_POST['socialTitle'] ?? 'Suivez-nous');

    $social = [];
    $platforms = $_POST['soc_platform'] ?? [];
    foreach ($platforms as $i => $p) {
        $p = trim($p);
        $icon = trim($_POST['soc_icon'][$i] ?? '');
        $url = trim($_POST['soc_url'][$i] ?? '');
        if ($p === '' && $url === '') {
            continue;
        }
        $social[] = ['platform' => $p, 'icon' => $icon ?: 'fab fa-link', 'url' => $url ?: '#'];
    }
    $data['socialLinks'] = $social;

    $data['formTitle']        = trim($_POST['formTitle'] ?? '');
    $data['formDescription']  = trim($_POST['formDescription'] ?? '');
    $data['submitButtonText'] = trim($_POST['submitButtonText'] ?? 'Envoyer le Message');

    if (tmk_save_content('contact', $data)) {
        tmk_flash("Page Contact mise à jour avec succès.");
    } else {
        tmk_flash("Erreur lors de l'enregistrement.", 'error');
    }
    header('Location: contact.php');
    exit;
}

admin_header('contact', "Contact");

function social_row($s)
{
    ob_start();
    ?>
    <div class="repeat-item">
        <button type="button" class="btn btn-sm btn-outline-danger position-absolute" style="top:10px;right:10px" onclick="tmkRemoveItem(this)"><i class="fa-solid fa-trash"></i></button>
        <div class="row g-2">
            <div class="col-md-3"><label class="form-label">Plateforme</label><input type="text" name="soc_platform[]" class="form-control" value="<?= htmlspecialchars($s['platform'] ?? '') ?>"></div>
            <div class="col-md-4"><label class="form-label">Icône (Font Awesome)</label><input type="text" name="soc_icon[]" class="form-control" value="<?= htmlspecialchars($s['icon'] ?? 'fab fa-facebook-f') ?>"></div>
            <div class="col-md-5"><label class="form-label">Lien (URL)</label><input type="text" name="soc_url[]" class="form-control" value="<?= htmlspecialchars($s['url'] ?? '#') ?>"></div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>
<form method="post">
    <?= tmk_csrf_field() ?>

    <div class="card mb-4">
        <div class="card-header"><i class="fa-solid fa-address-card text-primary"></i> Informations de contact</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><label class="form-label">Titre de la section</label><input type="text" name="sectionTitle" class="form-control" value="<?= htmlspecialchars($data['sectionTitle']) ?>"></div>
            <div class="col-md-6"><label class="form-label">Titre du bloc infos</label><input type="text" name="infoTitle" class="form-control" value="<?= htmlspecialchars($data['infoTitle']) ?>"></div>

            <div class="col-md-4"><label class="form-label">Libellé téléphone</label><input type="text" name="phoneLabel" class="form-control" value="<?= htmlspecialchars($data['phoneLabel']) ?>"></div>
            <div class="col-md-8"><label class="form-label">Numéro de téléphone</label><input type="text" name="phoneNumber" class="form-control" value="<?= htmlspecialchars($data['phoneNumber']) ?>"></div>

            <div class="col-md-4"><label class="form-label">Libellé email</label><input type="text" name="emailLabel" class="form-control" value="<?= htmlspecialchars($data['emailLabel']) ?>"></div>
            <div class="col-md-8"><label class="form-label">Adresse email</label><input type="text" name="emailAddress" class="form-control" value="<?= htmlspecialchars($data['emailAddress']) ?>"></div>

            <div class="col-md-4"><label class="form-label">Libellé adresse</label><input type="text" name="addressLabel" class="form-control" value="<?= htmlspecialchars($data['addressLabel']) ?>"></div>
            <div class="col-md-4"><label class="form-label">Adresse (ligne 1)</label><input type="text" name="addressLine1" class="form-control" value="<?= htmlspecialchars($data['addressLine1']) ?>"></div>
            <div class="col-md-4"><label class="form-label">Adresse (ligne 2)</label><input type="text" name="addressLine2" class="form-control" value="<?= htmlspecialchars($data['addressLine2']) ?>"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fa-solid fa-share-nodes text-primary"></i> Réseaux sociaux</span>
            <button type="button" class="btn btn-sm btn-tmk" onclick="tmkAddItem('socList','socTpl')"><i class="fa-solid fa-plus"></i> Ajouter</button>
        </div>
        <div class="card-body">
            <div class="mb-3"><label class="form-label">Titre « Suivez-nous »</label><input type="text" name="socialTitle" class="form-control" value="<?= htmlspecialchars($data['socialTitle']) ?>"></div>
            <div id="socList">
                <?php foreach ($data['socialLinks'] as $s) {
                    echo social_row($s);
                } ?>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="fa-solid fa-paper-plane text-primary"></i> Formulaire de message</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><label class="form-label">Titre du formulaire</label><input type="text" name="formTitle" class="form-control" value="<?= htmlspecialchars($data['formTitle']) ?>"></div>
            <div class="col-md-6"><label class="form-label">Texte du bouton d'envoi</label><input type="text" name="submitButtonText" class="form-control" value="<?= htmlspecialchars($data['submitButtonText']) ?>"></div>
            <div class="col-12"><label class="form-label">Description sous le titre</label><textarea name="formDescription" class="form-control" rows="2"><?= htmlspecialchars($data['formDescription']) ?></textarea></div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-5">
        <a href="index.php" class="btn btn-light">Annuler</a>
        <button type="submit" class="btn btn-tmk px-4"><i class="fa-solid fa-floppy-disk"></i> Enregistrer</button>
    </div>
</form>

<template id="socTpl"><?= social_row([]) ?></template>

<?php admin_footer(); ?>
