<?php
require './utils/header.php';
require_once './utils/api-config.php';

// Lire le contenu depuis le fichier JSON ou l'API
$jsonFile = __DIR__ . '/Backend/team-content.json';
$teamContent = getContentFromJsonOrApi($jsonFile, '/api/content/team');

// Valeurs par défaut
$sectionTitle = $teamContent['sectionTitle'] ?? 'Notre Communauté';
$members = $teamContent['members'] ?? [];

// Membres par défaut si vide
if (empty($members)) {
    $members = [
        ['name' => 'Franck Nsinga', 'photo' => 'images/6.jpeg'],
        ['name' => 'Franck Nsinga', 'photo' => 'images/1.jpeg'],
        ['name' => 'Leaticia Abibu', 'photo' => 'images/2.jpeg'],
        ['name' => 'Patrick Nsapu', 'photo' => 'images/3.jpeg'],
        ['name' => 'Nkulu Justine', 'photo' => 'images/4.jpeg'],
        ['name' => 'Nkongolo Kabeji Isabelle', 'photo' => 'images/5.jpeg'],
        ['name' => 'Nono Olivera', 'photo' => 'images/7.jpeg'],
        ['name' => 'Elie Tshilongo', 'photo' => 'images/8.jpeg'],
        ['name' => 'Nsumbu Ramath', 'photo' => 'images/9.jpeg'],
        ['name' => 'Kabeya Kayembe Manassé', 'photo' => 'images/10.jpeg'],
        ['name' => 'Ngoie Mulongo Anthony Alfred', 'photo' => 'images/11.jpeg'],
        ['name' => 'Lareine NDUME', 'photo' => 'images/12.jpeg'],
        ['name' => 'Michelange Manda', 'photo' => 'images/13.jpeg'],
        ['name' => 'Mwitubile Mwebe Paola', 'photo' => 'images/14.jpeg'],
        ['name' => 'Hodd Senguime', 'photo' => 'images/15.jpeg'],
        ['name' => 'Roy Kasanda', 'photo' => 'images/16.jpeg'],
        ['name' => 'Joel Massamba', 'photo' => 'images/17.jpeg'],
        ['name' => 'Nathan masiala', 'photo' => 'images/18.jpeg'],
        ['name' => 'Esther Ngoie', 'photo' => 'images/19.jpeg'],
        ['name' => 'Malaïka Kubua Veronica', 'photo' => 'images/20.jpeg'],
        ['name' => 'Aziza Mponga Trésor', 'photo' => 'images/21.jpeg']
    ];
}

// Toujours mettre YAMBANU NDUGBIA GLODY (images/1.jpeg) en première position dans le défilement
$firstPhoto = 'images/1.jpeg';
$firstIndex = null;
foreach ($members as $i => $m) {
    $photo = $m['photo'] ?? '';
    if ($photo === $firstPhoto) {
        $firstIndex = $i;
        break;
    }
}
if ($firstIndex !== null && $firstIndex > 0) {
    $firstMember = $members[$firstIndex];
    array_splice($members, $firstIndex, 1);
    array_unshift($members, $firstMember);
}

// Mettre Nkongolo Kabeji Isabelle (images/5.jpeg) en deuxième position
$secondPhoto = 'images/5.jpeg';
$secondIndex = null;
foreach ($members as $i => $m) {
    if (($m['photo'] ?? '') === $secondPhoto) {
        $secondIndex = $i;
        break;
    }
}
if ($secondIndex !== null && $secondIndex !== 1) {
    $secondMember = $members[$secondIndex];
    array_splice($members, $secondIndex, 1);
    array_splice($members, 1, 0, [$secondMember]);
}

// Mettre Michelange Manda (images/13.jpeg) en troisième position
$thirdPhoto = 'images/13.jpeg';
$thirdIndex = null;
foreach ($members as $i => $m) {
    if (($m['photo'] ?? '') === $thirdPhoto) {
        $thirdIndex = $i;
        break;
    }
}
if ($thirdIndex !== null && $thirdIndex !== 2) {
    $thirdMember = $members[$thirdIndex];
    array_splice($members, $thirdIndex, 1);
    array_splice($members, 2, 0, [$thirdMember]);
}

// Mettre Mwitubile Mwebe Paola (images/14.jpeg) en quatrième position
$fourthPhoto = 'images/14.jpeg';
$fourthIndex = null;
foreach ($members as $i => $m) {
    if (($m['photo'] ?? '') === $fourthPhoto) {
        $fourthIndex = $i;
        break;
    }
}
if ($fourthIndex !== null && $fourthIndex !== 3) {
    $fourthMember = $members[$fourthIndex];
    array_splice($members, $fourthIndex, 1);
    array_splice($members, 3, 0, [$fourthMember]);
}

// Mettre Franck Nsinga (images/6.jpeg) en cinquième position
$fifthPhoto = 'images/6.jpeg';
$fifthIndex = null;
foreach ($members as $i => $m) {
    if (($m['photo'] ?? '') === $fifthPhoto) {
        $fifthIndex = $i;
        break;
    }
}
if ($fifthIndex !== null && $fifthIndex !== 4) {
    $fifthMember = $members[$fifthIndex];
    array_splice($members, $fifthIndex, 1);
    array_splice($members, 4, 0, [$fifthMember]);
}

// Forcer le nom "Franck Nsinga" pour la photo images/6.jpeg (affiché peu importe la source des données)
foreach ($members as &$m) {
    $p = $m['photo'] ?? '';
    if ($p === 'images/6.jpeg') {
        $m['name'] = 'Franck Nsinga';
        break;
    }
}
unset($m);

// Forcer le nom "YAMBANU NDUGBIA GLODY" pour la photo images/1.jpeg
foreach ($members as &$m) {
    $p = $m['photo'] ?? '';
    if ($p === 'images/1.jpeg') {
        $m['name'] = 'YAMBANU NDUGBIA GLODY';
        break;
    }
}
unset($m);

// Joel Massamba : afficher la photo (costume bleu, drapeau RDC)
foreach ($members as &$m) {
    $p = $m['photo'] ?? '';
    if ($p === 'images/17.jpeg') {
        $m['photo'] = 'images/17-drc.png';
        break;
    }
}
unset($m);
?>

<section id="team" class="section" style="background-color: #ffffff; color: #1a1a1a;">
    <div class="container">
        <div class="row">
            <div class="title-box text-center">
                <h2 class="title" style="color: #1a1a1a;"><?php echo htmlspecialchars($sectionTitle); ?></h2>
            </div>
        </div>
        <!-- Team -->
        <div class="team-items team-carousel">
            <?php foreach ($members as $member): ?>
            <div class="item">
                <div class="team-item-photo">
                    <img src="<?php echo htmlspecialchars($member['photo']); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>" />
                </div>
                <h4 style="color: black; font-weight: bold; font-size: 1.25rem;"><?php echo htmlspecialchars($member['name']); ?></h4>
                <?php if (!empty($member['role'])): ?>
                <p style="color: #666; font-size: 0.9rem;"><?php echo htmlspecialchars($member['role']); ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <!-- End Team -->
    </div>
    <!-- End Content -->
</section>

<?php
require './utils/footer.php'
?>
