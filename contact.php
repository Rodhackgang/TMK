<?php
require './utils/header.php';
require_once './utils/api-config.php';

// Lire le contenu depuis le fichier JSON ou l'API
$jsonFile = __DIR__ . '/Backend/contact-content.json';
$contactContent = getContentFromJsonOrApi($jsonFile, '/api/content/contact');

// Valeurs par défaut
$pageTitle = $contactContent['pageTitle'] ?? 'Contactez-nous';
$sectionTitle = $contactContent['sectionTitle'] ?? 'Contactez TMK';

// Contact Info
$contactInfo = $contactContent['contactInfo'] ?? [];
$infoTitle = $contactInfo['title'] ?? 'Informations de Contact';
$phoneLabel = $contactInfo['phone']['label'] ?? 'Téléphone';
$phoneNumber = $contactInfo['phone']['number'] ?? '+243 900 000 000';
$emailLabel = $contactInfo['email']['label'] ?? 'Email';
$emailAddress = $contactInfo['email']['address'] ?? 'contact@tmkfoundation.org';
$addressLabel = $contactInfo['address']['label'] ?? 'Adresse';
$addressLine1 = $contactInfo['address']['line1'] ?? 'A108 Rue Adam';
$addressLine2 = $contactInfo['address']['line2'] ?? 'Kinshasa, RDC';

// Social
$socialTitle = $contactContent['socialTitle'] ?? 'Suivez-nous';
$socialLinks = $contactContent['socialLinks'] ?? [
    ['platform' => 'Facebook', 'icon' => 'fab fa-facebook-f', 'url' => '#'],
    ['platform' => 'Twitter', 'icon' => 'fab fa-twitter', 'url' => '#'],
    ['platform' => 'Instagram', 'icon' => 'fab fa-instagram', 'url' => '#'],
    ['platform' => 'LinkedIn', 'icon' => 'fab fa-linkedin-in', 'url' => '#']
];

// Form
$formSection = $contactContent['formSection'] ?? [];
$formTitle = $formSection['title'] ?? 'Envoyez-nous un Message';
$formDescription = $formSection['description'] ?? 'Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais.';
$submitButtonText = $formSection['submitButtonText'] ?? 'Envoyer le Message';
?>

<!-- Page Header : bannière TMK -->
<section id="page-header" class="parallax page-header--logo">
  <div class="page-header-logo">
    <img src="images/tmk-header.png" alt="TMK - The Miracle Kingdom" class="tmk-logo-img">
  </div>
  <div class="overlay"></div>
</section>

<!--Start Contact Section-->
<section id="contact-content" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title-box text-center">
                    <h2 class="title"><?php echo htmlspecialchars($sectionTitle); ?></h2>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Informations de Contact -->
            <div class="col-md-4">
                <div class="contact-info-box">
                    <h3><strong><?php echo htmlspecialchars($infoTitle); ?></strong></h3>
                    
                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="contact-info-details">
                            <h4><?php echo htmlspecialchars($phoneLabel); ?></h4>
                            <p><a href="tel:<?php echo preg_replace('/\s+/', '', $phoneNumber); ?>"><?php echo htmlspecialchars($phoneNumber); ?></a></p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="contact-info-details">
                            <h4><?php echo htmlspecialchars($emailLabel); ?></h4>
                            <p><a href="mailto:<?php echo htmlspecialchars($emailAddress); ?>"><?php echo htmlspecialchars($emailAddress); ?></a></p>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon">
                            <i class="fa fa-map-marker"></i>
                        </div>
                        <div class="contact-info-details">
                            <h4><?php echo htmlspecialchars($addressLabel); ?></h4>
                            <p><?php echo htmlspecialchars($addressLine1); ?><br><?php echo htmlspecialchars($addressLine2); ?></p>
                        </div>
                    </div>

                    <div class="contact-social">
                        <h4><?php echo htmlspecialchars($socialTitle); ?></h4>
                        <div class="social-links">
                            <?php 
                            foreach ($socialLinks as $social): 
                                $iconClass = $social['icon'];
                                // Fix the FA class for brands if it is coming from the API as "fa fa-..."
                                $iconClass = str_replace('fa fa-', 'fab fa-', $iconClass);
                                // If it doesn't have fab or fa-brands, and starts with fa-, prepend fab
                                if (strpos($iconClass, 'fab ') === false && strpos($iconClass, 'fa-') === 0) {
                                    $iconClass = 'fab ' . $iconClass;
                                }
                            ?>
                            <a href="<?php echo htmlspecialchars($social['url']); ?>" class="social-link" target="_blank">
                                <i class="<?php echo htmlspecialchars($iconClass); ?>"></i>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire de Contact -->
            <div class="col-md-8">
                <div class="contact-form-box">
                    <h3><?php echo htmlspecialchars($formTitle); ?></h3>
                    <p class="form-description"><?php echo htmlspecialchars($formDescription); ?></p>
                    
                    <form method="post" action="sendcontact.php" class="contact-form-modern">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nom Complet *</label>
                                    <input class="form-control" id="name" name="name" placeholder="Votre nom complet" type="text" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input class="form-control" id="email" name="email" placeholder="votre.email@exemple.com" type="email" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="subject">Objet *</label>
                                    <input class="form-control" id="subject" name="subject" placeholder="Objet de votre message" type="text" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="message">Message *</label>
                                    <textarea class="form-control" id="message" name="message" rows="7" placeholder="Écrivez votre message ici..." required></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-contact-submit">
                                    <i class="fa fa-paper-plane"></i> <?php echo htmlspecialchars($submitButtonText); ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Contact Section-->

<?php
require './utils/footer.php'
?>
