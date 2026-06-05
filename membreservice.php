<?php
require './utils/header.php'
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
                <h2 class="title">Nos Membres</h2>
            </div>
        </div>
        <!-- Members -->                    
        <div class="members-items">
            <div class="item">
                <img src="images/member1.jpg" alt="Membre 1" />
                <h4>Membre 1</h4>
            </div>
            <div class="item">
                <img src="images/member2.jpg" alt="Membre 2" />
                <h4>Membre 2</h4>
            </div>
            <div class="item">
                <img src="images/member3.jpg" alt="Membre 3" />
                <h4>Membre 3</h4>
            </div>
            <div class="item">
                <img src="images/member4.jpg" alt="Membre 4" />
                <h4>Membre 4</h4>
            </div>
            <div class="item">
                <img src="images/member5.jpg" alt="Membre 5" />
                <h4>Membre 5</h4>
            </div>
            <div class="item">
                <img src="images/member6.jpg" alt="Membre 6" />
                <h4>Membre 6</h4>
            </div>
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