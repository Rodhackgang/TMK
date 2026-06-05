<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/partials.php';

$data = tmk_content('juridique', tmk_defaults('juridique'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!tmk_csrf_check()) {
        tmk_flash("Session expirée, réessayez.", 'error');
        header('Location: juridique.php');
        exit;
    }

    $data['mainTitle']    = trim($_POST['mainTitle'] ?? '');
    $data['introduction'] = trim($_POST['introduction'] ?? '');
    $data['listTitle']    = trim($_POST['listTitle'] ?? '');
    $data['summary']      = trim($_POST['summary'] ?? '');

    $items = [];
    $titles = $_POST['doc_title'] ?? [];
    foreach ($titles as $i => $t) {
        $t = trim($t);
        if ($t === '') {
            continue;
        }
        $items[] = [
            'icon'        => trim($_POST['doc_icon'][$i] ?? 'fa-file-text') ?: 'fa-file-text',
            'title'       => $t,
            'description' => trim($_POST['doc_description'][$i] ?? ''),
        ];
    }
    $data['items'] = $items;

    if (tmk_save_content('juridique', $data)) {
        tmk_flash("Page Statut juridique mise à jour avec succès.");
    } else {
        tmk_flash("Erreur lors de l'enregistrement.", 'error');
    }
    header('Location: juridique.php');
    exit;
}

admin_header('juridique', "Statut juridique");

function doc_row($d)
{
    ob_start();
    ?>
    <div class="repeat-item">
        <button type="button" class="btn btn-sm btn-outline-danger position-absolute" style="top:10px;right:10px" onclick="tmkRemoveItem(this)"><i class="fa-solid fa-trash"></i></button>
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label">Icône</label>
                <input type="text" name="doc_icon[]" class="form-control" value="<?= htmlspecialchars($d['icon'] ?? 'fa-file-text') ?>" placeholder="fa-file-text">
            </div>
            <div class="col-md-9">
                <label class="form-label">Titre du document</label>
                <input type="text" name="doc_title[]" class="form-control" value="<?= htmlspecialchars($d['title'] ?? '') ?>">
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="doc_description[]" class="form-control" rows="2"><?= htmlspecialchars($d['description'] ?? '') ?></textarea>
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
        <div class="card-header"><i class="fa-solid fa-scale-balanced text-primary"></i> Textes de la page</div>
        <div class="card-body row g-3">
            <div class="col-12"><label class="form-label">Titre principal</label><input type="text" name="mainTitle" class="form-control" value="<?= htmlspecialchars($data['mainTitle']) ?>"></div>
            <div class="col-12"><label class="form-label">Introduction (le HTML &lt;strong&gt; est autorisé)</label><textarea name="introduction" class="form-control" rows="3"><?= htmlspecialchars($data['introduction']) ?></textarea></div>
            <div class="col-12"><label class="form-label">Titre de la liste</label><input type="text" name="listTitle" class="form-control" value="<?= htmlspecialchars($data['listTitle']) ?>"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fa-solid fa-folder-open text-primary"></i> Documents</span>
            <button type="button" class="btn btn-sm btn-tmk" onclick="tmkAddItem('docList','docTpl')"><i class="fa-solid fa-plus"></i> Ajouter un document</button>
        </div>
        <div class="card-body">
            <div id="docList">
                <?php foreach ($data['items'] as $d) {
                    echo doc_row($d);
                } ?>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="fa-solid fa-circle-info text-primary"></i> Résumé</div>
        <div class="card-body">
            <textarea name="summary" class="form-control" rows="3"><?= htmlspecialchars($data['summary']) ?></textarea>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-5">
        <a href="index.php" class="btn btn-light">Annuler</a>
        <button type="submit" class="btn btn-tmk px-4"><i class="fa-solid fa-floppy-disk"></i> Enregistrer</button>
    </div>
</form>

<template id="docTpl"><?= doc_row([]) ?></template>

<?php admin_footer(); ?>
