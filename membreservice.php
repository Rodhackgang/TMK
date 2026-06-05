<?php
require './utils/header.php';
require_once './utils/content-store.php';

// Membres administrables (/content/members.json)
$membersContent = tmk_content('members', tmk_defaults('members'));
$membersList = $membersContent['members'] ?? [];
$membersTitle = $membersContent['sectionTitle'] ?? 'Nos Membres';
?>

<!-- Page Header : logo TMK (The Miracle Kingdom) – image en fond plein écran -->
<section id="page-header" class="parallax page-header--logo">
  <div class="page-header-logo">
    <img src="images/tmk-header.png" alt="TMK - Membres Services" class="tmk-logo-img">
  </div>
  <div class="overlay"></div>
</section>

<section id="members" class="members" style="background-color: #f4f4f4; color: black; padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="title-box text-center">
                <h2 class="title"><?= htmlspecialchars($membersTitle) ?></h2>
            </div>
        </div>
        <!-- Members -->
        <div class="members-items">
            <?php foreach ($membersList as $m): ?>
            <div class="item">
                <img src="<?= htmlspecialchars($m['image'] ?? 'images/member1.jpg') ?>" alt="<?= htmlspecialchars($m['name'] ?? 'Membre') ?>" />
                <h4><?= htmlspecialchars($m['name'] ?? '') ?></h4>
                <?php if (!empty($m['poste'])): ?>
                <p class="member-poste"><?= htmlspecialchars($m['poste']) ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div> <!-- /.container-->
</section>
<style>
container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}
.members-items {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
.members-items .item {
    margin: 15px;
    text-align: center;
}
.members-items .item img {
    width: 150px;
    height: 150px;                 
    border-radius: 50%;
}
.members-items .item h4 {
    margin-top: 10px;
    font-size: 18px;
    color: #333;
    margin-bottom: 2px;
}
.members-items .item .member-poste {
    margin: 0;
    font-size: 14px;
    color: #5B8FD9;
    font-weight: 600;
}
.members-items .item img {
    object-fit: cover;
}
.members-items .item:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease;        
}
.members-items .item img:hover {
    filter: brightness(0.8);
    transition: filter 0.3s ease;
}
.members-items .item h4:hover {
    color: #007bff;
    transition: color 0.3s ease;
}   
</style>
<?php
require './utils/footer.php'
?>