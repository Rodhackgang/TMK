<?php
/**
 * Mise en page commune de l'administration (en-tête + barre latérale + pied).
 */
require_once __DIR__ . '/config.php';

/** Liste des entrées du menu latéral : clé => [libellé, icône] */
function tmk_admin_menu()
{
    return [
        'index'     => ['Tableau de bord', 'fa-gauge-high'],
        'home'      => ['Accueil (en-tête, mission, actualités)', 'fa-house'],
        'about'     => ["Domaines d'intervention", 'fa-grip'],
        'photos'    => ['Photos / Albums', 'fa-images'],
        'videos'    => ['Vidéos', 'fa-video'],
        'membres'   => ['Membres', 'fa-users'],
        'contact'   => ['Contact', 'fa-address-book'],
        'juridique' => ['Statut juridique', 'fa-scale-balanced'],
        'footer'    => ['Pied de page', 'fa-shoe-prints'],
    ];
}

function admin_header($active = 'index', $pageTitle = 'Administration')
{
    $flash = tmk_get_flash();
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle) ?> · TMK Admin</title>
    <link href="assets/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/fa/css/all.min.css">
    <link rel="icon" href="../images/logo.png">
    <style>
        :root { --tmk: #5B8FD9; --tmk-dark: #0f2747; }
        body { background:#eef2f7; font-family: 'Segoe UI', system-ui, sans-serif; }
        .tmk-sidebar {
            position: fixed; top:0; left:0; bottom:0; width:270px;
            background: linear-gradient(180deg, #0f2747, #14375f); color:#dbe6f5;
            display:flex; flex-direction:column; z-index:1040;
            box-shadow: 2px 0 12px rgba(0,0,0,.15);
        }
        .tmk-sidebar .brand { padding:20px; display:flex; align-items:center; gap:12px; border-bottom:1px solid rgba(255,255,255,.08); }
        .tmk-sidebar .brand img { width:42px; height:42px; object-fit:contain; background:#fff; border-radius:8px; padding:4px; }
        .tmk-sidebar .brand b { font-size:17px; color:#fff; }
        .tmk-sidebar .brand span { font-size:11px; letter-spacing:2px; color:var(--tmk); text-transform:uppercase; }
        .tmk-nav { padding:12px; overflow-y:auto; flex:1; }
        .tmk-nav a {
            display:flex; align-items:center; gap:12px; color:#cdd9ec; text-decoration:none;
            padding:11px 14px; border-radius:9px; font-size:14px; margin-bottom:4px; transition:.15s;
        }
        .tmk-nav a i { width:20px; text-align:center; color:var(--tmk); }
        .tmk-nav a:hover { background:rgba(255,255,255,.07); color:#fff; }
        .tmk-nav a.active { background:var(--tmk); color:#fff; font-weight:600; }
        .tmk-nav a.active i { color:#fff; }
        .tmk-sidebar .foot { padding:14px; border-top:1px solid rgba(255,255,255,.08); }
        .tmk-main { margin-left:270px; padding:26px 32px 60px; }
        .tmk-topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px; }
        .tmk-topbar h1 { font-size:22px; font-weight:700; color:#13294a; margin:0; }
        .card { border:none; border-radius:14px; box-shadow:0 4px 18px rgba(20,40,80,.06); }
        .card-header { background:#fff; border-bottom:1px solid #eef1f6; font-weight:600; color:#13294a; border-radius:14px 14px 0 0 !important; }
        .btn-tmk { background:var(--tmk); border-color:var(--tmk); color:#fff; }
        .btn-tmk:hover { background:#4a7bc7; border-color:#4a7bc7; color:#fff; }
        .form-label { font-weight:600; font-size:13px; color:#42526b; }
        .repeat-item { border:1px solid #e6ebf2; border-radius:12px; padding:18px; margin-bottom:16px; background:#fbfcfe; position:relative; }
        .repeat-item .badge-num { position:absolute; top:-10px; left:14px; }
        .thumb { max-height:90px; border-radius:8px; border:1px solid #e0e6ef; background:#fff; }
        @media (max-width: 860px){
            .tmk-sidebar { transform:translateX(-100%); transition:.25s; }
            .tmk-sidebar.show { transform:translateX(0); }
            .tmk-main { margin-left:0; padding:18px; }
            .tmk-burger { display:inline-flex !important; }
        }
        .tmk-burger { display:none; }
    </style>
</head>
<body>
    <aside class="tmk-sidebar" id="tmkSidebar">
        <div class="brand">
            <img src="../images/logo.png" alt="TMK">
            <div>
                <b>TMK Admin</b><br>
                <span>The Miracle Kingdom</span>
            </div>
        </div>
        <nav class="tmk-nav">
            <?php foreach (tmk_admin_menu() as $key => $item): ?>
                <a href="<?= $key ?>.php" class="<?= $active === $key ? 'active' : '' ?>">
                    <i class="fa-solid <?= $item[1] ?>"></i> <?= htmlspecialchars($item[0]) ?>
                </a>
            <?php endforeach; ?>
        </nav>
        <div class="foot">
            <a href="../index.php" target="_blank" class="btn btn-sm btn-outline-light w-100 mb-2">
                <i class="fa-solid fa-up-right-from-square"></i> Voir le site
            </a>
            <a href="logout.php" class="btn btn-sm btn-outline-warning w-100">
                <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
            </a>
        </div>
    </aside>

    <main class="tmk-main">
        <div class="tmk-topbar">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-light tmk-burger" onclick="document.getElementById('tmkSidebar').classList.toggle('show')">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1><?= htmlspecialchars($pageTitle) ?></h1>
            </div>
        </div>

        <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-<?= $flash['type'] === 'success' ? 'circle-check' : 'triangle-exclamation' ?>"></i>
                <?= htmlspecialchars($flash['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    <?php
}

function admin_footer()
{
    ?>
    </main>
    <script src="assets/bootstrap.bundle.min.js"></script>
    <script>
        // Ajout dynamique d'éléments répétables (actualités, membres, documents...)
        function tmkAddItem(containerId, templateId) {
            var tpl = document.getElementById(templateId);
            var container = document.getElementById(containerId);
            var html = tpl.innerHTML.replace(/__INDEX__/g, Date.now().toString().slice(-6) + Math.floor(Math.random()*100));
            var div = document.createElement('div');
            div.innerHTML = html;
            container.appendChild(div.firstElementChild);
        }
        function tmkRemoveItem(btn) {
            if (confirm('Supprimer cet élément ?')) {
                btn.closest('.repeat-item').remove();
            }
        }
    </script>
</body>
</html>
    <?php
}
