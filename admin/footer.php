<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/partials.php';

$data = tmk_content('footer', tmk_defaults('footer'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!tmk_csrf_check()) {
        tmk_flash("Session expirée, réessayez.", 'error');
        header('Location: footer.php');
        exit;
    }

    $data['brandName']    = trim($_POST['brandName'] ?? '');
    $data['brandTagline'] = trim($_POST['brandTagline'] ?? '');
    $data['about1']       = trim($_POST['about1'] ?? '');
    $data['about2']       = trim($_POST['about2'] ?? '');

    $data['social'] = [
        'facebook'  => trim($_POST['s_facebook'] ?? ''),
        'twitter'   => trim($_POST['s_twitter'] ?? ''),
        'linkedin'  => trim($_POST['s_linkedin'] ?? ''),
        'instagram' => trim($_POST['s_instagram'] ?? ''),
        'whatsapp'  => trim($_POST['s_whatsapp'] ?? ''),
        'youtube'   => trim($_POST['s_youtube'] ?? ''),
    ];

    $data['contact'] = [
        'orgName' => trim($_POST['c_orgName'] ?? ''),
        'address' => trim($_POST['c_address'] ?? ''),
        'phone1'  => trim($_POST['c_phone1'] ?? ''),
        'phone2'  => trim($_POST['c_phone2'] ?? ''),
        'email'   => trim($_POST['c_email'] ?? ''),
        'hours1'  => trim($_POST['c_hours1'] ?? ''),
        'hours2'  => trim($_POST['c_hours2'] ?? ''),
        'mapsUrl' => trim($_POST['c_mapsUrl'] ?? ''),
    ];

    $data['newsletterTitle'] = trim($_POST['newsletterTitle'] ?? '');
    $data['newsletterText']  = trim($_POST['newsletterText'] ?? '');
    $data['copyright']       = trim($_POST['copyright'] ?? '');

    if (tmk_save_content('footer', $data)) {
        tmk_flash("Pied de page mis à jour avec succès.");
    } else {
        tmk_flash("Erreur lors de l'enregistrement.", 'error');
    }
    header('Location: footer.php');
    exit;
}

$s = $data['social'];
$c = $data['contact'];

admin_header('footer', "Pied de page");
?>
<form method="post">
    <?= tmk_csrf_field() ?>

    <div class="card mb-4">
        <div class="card-header"><i class="fa-solid fa-building text-primary"></i> Présentation</div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Nom de la marque</label>
                <input type="text" name="brandName" class="form-control" value="<?= htmlspecialchars($data['brandName']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Slogan (sous le nom)</label>
                <input type="text" name="brandTagline" class="form-control" value="<?= htmlspecialchars($data['brandTagline']) ?>">
            </div>
            <div class="col-12">
                <label class="form-label">Texte de présentation (paragraphe 1)</label>
                <textarea name="about1" class="form-control" rows="2"><?= htmlspecialchars($data['about1']) ?></textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Texte de présentation (paragraphe 2)</label>
                <textarea name="about2" class="form-control" rows="2"><?= htmlspecialchars($data['about2']) ?></textarea>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="fa-solid fa-share-nodes text-primary"></i> Réseaux sociaux (liens)</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><label class="form-label"><i class="fab fa-facebook"></i> Facebook</label><input type="text" name="s_facebook" class="form-control" value="<?= htmlspecialchars($s['facebook'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label"><i class="fab fa-twitter"></i> Twitter / X</label><input type="text" name="s_twitter" class="form-control" value="<?= htmlspecialchars($s['twitter'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label"><i class="fab fa-linkedin"></i> LinkedIn</label><input type="text" name="s_linkedin" class="form-control" value="<?= htmlspecialchars($s['linkedin'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label"><i class="fab fa-instagram"></i> Instagram</label><input type="text" name="s_instagram" class="form-control" value="<?= htmlspecialchars($s['instagram'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label"><i class="fab fa-whatsapp"></i> WhatsApp</label><input type="text" name="s_whatsapp" class="form-control" value="<?= htmlspecialchars($s['whatsapp'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label"><i class="fab fa-youtube"></i> YouTube</label><input type="text" name="s_youtube" class="form-control" value="<?= htmlspecialchars($s['youtube'] ?? '') ?>"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="fa-solid fa-address-card text-primary"></i> Coordonnées</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><label class="form-label">Nom de l'organisation</label><input type="text" name="c_orgName" class="form-control" value="<?= htmlspecialchars($c['orgName'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Adresse</label><input type="text" name="c_address" class="form-control" value="<?= htmlspecialchars($c['address'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Téléphone 1</label><input type="text" name="c_phone1" class="form-control" value="<?= htmlspecialchars($c['phone1'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Téléphone 2</label><input type="text" name="c_phone2" class="form-control" value="<?= htmlspecialchars($c['phone2'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Email</label><input type="text" name="c_email" class="form-control" value="<?= htmlspecialchars($c['email'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Lien Google Maps</label><input type="text" name="c_mapsUrl" class="form-control" value="<?= htmlspecialchars($c['mapsUrl'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Horaires (ligne 1)</label><input type="text" name="c_hours1" class="form-control" value="<?= htmlspecialchars($c['hours1'] ?? '') ?>"></div>
            <div class="col-md-6"><label class="form-label">Horaires (ligne 2)</label><input type="text" name="c_hours2" class="form-control" value="<?= htmlspecialchars($c['hours2'] ?? '') ?>"></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="fa-solid fa-envelope-open-text text-primary"></i> Newsletter &amp; bas de page</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><label class="form-label">Titre newsletter</label><input type="text" name="newsletterTitle" class="form-control" value="<?= htmlspecialchars($data['newsletterTitle']) ?>"></div>
            <div class="col-md-6"><label class="form-label">Texte newsletter</label><input type="text" name="newsletterText" class="form-control" value="<?= htmlspecialchars($data['newsletterText']) ?>"></div>
            <div class="col-12"><label class="form-label">Texte de copyright</label><input type="text" name="copyright" class="form-control" value="<?= htmlspecialchars($data['copyright']) ?>"></div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-5">
        <a href="index.php" class="btn btn-light">Annuler</a>
        <button type="submit" class="btn btn-tmk px-4"><i class="fa-solid fa-floppy-disk"></i> Enregistrer</button>
    </div>
</form>
<?php admin_footer(); ?>
