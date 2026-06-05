<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/partials.php';

$cards = [
    'home'      => ['Accueil', "En-tête (vidéo + textes), mission & vision, actualités", 'fa-house', '#5B8FD9'],
    'about'     => ["Domaines d'intervention", "Titres et cartes de la page À propos", 'fa-grip', '#27ae60'],
    'photos'    => ['Photos / Albums', "Ajouter ou supprimer des albums photos", 'fa-images', '#e67e22'],
    'videos'    => ['Vidéos', "Ajouter ou supprimer des vidéos", 'fa-video', '#9b59b6'],
    'membres'   => ['Membres', "Visage et poste de chaque membre", 'fa-users', '#16a085'],
    'contact'   => ['Contact', "Adresse, téléphone, email, réseaux", 'fa-address-book', '#2980b9'],
    'juridique' => ['Statut juridique', "Documents et textes légaux", 'fa-scale-balanced', '#c0392b'],
    'footer'    => ['Pied de page', "Coordonnées, liens et textes du bas de page", 'fa-shoe-prints', '#34495e'],
];

admin_header('index', 'Tableau de bord');
?>

<div class="alert alert-light border d-flex align-items-center gap-3">
    <i class="fa-solid fa-circle-info fs-4 text-primary"></i>
    <div>
        Bienvenue <strong><?= htmlspecialchars($_SESSION['tmk_admin']) ?></strong>.
        Choisissez une section à modifier. Chaque changement est appliqué immédiatement sur le site public.
    </div>
</div>

<div class="row g-4">
    <?php foreach ($cards as $key => $c): ?>
        <div class="col-md-6 col-xl-4">
            <a href="<?= $key ?>.php" class="text-decoration-none">
                <div class="card h-100 p-3">
                    <div class="d-flex align-items-start gap-3">
                        <div style="width:54px;height:54px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:<?= $c[3] ?>22;color:<?= $c[3] ?>;">
                            <i class="fa-solid <?= $c[2] ?> fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 text-dark fw-bold"><?= htmlspecialchars($c[0]) ?></h5>
                            <p class="mb-0 text-muted small"><?= htmlspecialchars($c[1]) ?></p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<?php admin_footer(); ?>
