<?php
// Contenu administrable du pied de page (admin Node -> footer-content.json / API)
require_once __DIR__ . '/api-config.php';
$footerC = getContentFromJsonOrApi(__DIR__ . '/../Backend/footer-content.json', '/api/content/footer');
if (!is_array($footerC)) { $footerC = []; }
$fSocial  = $footerC['social'] ?? [];
$fContact = $footerC['contact'] ?? [];
$telHref = function ($num) { return 'tel:' . preg_replace('/[^0-9+]/', '', $num); };
?>
<!-- Wave divider between main content and footer -->
<div class="relative w-full -mt-1" aria-hidden="true">
    <svg class="block w-full h-16 text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"
        preserveAspectRatio="none">
        <path fill="currentColor"
            d="M0,160L80,165.3C160,171,320,181,480,176C640,171,800,149,960,149.3C1120,149,1280,171,1360,181.3L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z">
        </path>
    </svg>
</div>

<!--Start Footer-->
<style>
/* Bloc Contact : texte blanc */
.footer-contact-block,
.footer-contact-block p,
.footer-contact-block a { color: #ffffff !important; }
.footer-contact-block a:hover { color: var(--tw-ring-color, #6b8cce) !important; }

/* Footer social icons: agrandissement et couleurs de marque au survol */
.footer-social-icons .footer-social-link {
    transform: scale(1);
}
.footer-social-icons .footer-social-link:hover {
    transform: scale(1.25);
    color: #fff !important;
}
.footer-social-icons .footer-social-facebook:hover {
    background: #1877F2 !important;
    box-shadow: 0 4px 14px rgba(24, 119, 242, 0.5);
}
.footer-social-icons .footer-social-twitter:hover {
    background: #1DA1F2 !important;
    box-shadow: 0 4px 14px rgba(29, 161, 242, 0.5);
}
.footer-social-icons .footer-social-linkedin:hover {
    background: #0A66C2 !important;
    box-shadow: 0 4px 14px rgba(10, 102, 194, 0.5);
}
.footer-social-icons .footer-social-instagram:hover {
    background: linear-gradient(135deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%) !important;
    box-shadow: 0 4px 14px rgba(225, 48, 108, 0.5);
}
.footer-social-icons .footer-social-whatsapp:hover {
    background: #25D366 !important;
    box-shadow: 0 4px 14px rgba(37, 211, 102, 0.5);
}
.footer-social-icons .footer-social-youtube:hover {
    background: #FF0000 !important;
    box-shadow: 0 4px 14px rgba(255, 0, 0, 0.5);
}

/* Bloc Site web (UI/UX) dans le footer */
.footer-ui-ux-section {
    margin-bottom: 2rem;
    padding: 1.25rem 1.5rem;
    border: 2px solid rgba(255, 255, 255, 0.25);
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.06);
    display: inline-block;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}
.footer-ui-ux-section .btn-ui-ux-footer {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 50px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #fff;
    background: linear-gradient(45deg, #4a6cf7, #8fb4ff);
    box-shadow: 0 4px 15px rgba(74, 108, 247, 0.3);
    text-transform: none;
    letter-spacing: 0.3px;
}
.footer-ui-ux-section .btn-ui-ux-footer:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 108, 247, 0.4);
}
</style>
<footer
    class="relative bg-black text-gray-200 pt-12 pb-8 shadow-[0_-20px_50px_rgba(0,0,0,0.45)]">
    <!-- Thin accent line -->
    <div
        class="pointer-events-none absolute inset-x-0 top-0 h-[1px] bg-gradient-to-r from-transparent via-tmkAccent/80 to-transparent">
    </div>

    <div class="max-w-6xl px-4 mx-auto sm:px-6 lg:px-8">
        <?php
        $footerHero = isset($hero) ? $hero : [];
        $uiuxText = isset($footerHero['uiuxButtonText']) ? $footerHero['uiuxButtonText'] : 'Si vous avez besoin d\'avoir votre propre Site web cliquez sur ce bouton pour contacter le developpeur du site';
        $uiuxLink = isset($footerHero['uiuxWhatsappLink']) ? $footerHero['uiuxWhatsappLink'] : 'https://wa.me/243974555964';
        ?>
        <div class="footer-ui-ux-wrapper mb-8 flex justify-center">
            <div class="footer-ui-ux-section">
                <a href="<?= htmlspecialchars($uiuxLink) ?>" target="_blank" rel="noopener" class="btn-ui-ux-footer" id="uiuxBtnFooter">
                    <span>💻</span>
                    <?= htmlspecialchars($uiuxText) ?>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-4">
            <!-- Column 1 - About / Brand -->
            <div>
                <div class="flex items-center mb-4 space-x-3">
                    <div
                        class="flex items-center justify-center w-14 h-14 overflow-hidden bg-white/5 rounded-full ring-2 ring-tmkAccent/70 shadow-lg">
                        <img src="images/logo.png" alt="Logo TMK Foundation"
                            class="object-contain w-12 h-12 drop-shadow-md">
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold tracking-wide text-white"><?= htmlspecialchars($footerC['brandName'] ?? 'TMK Foundation') ?></h2>
                        <p class="text-xs font-semibold tracking-[0.25em] text-tmkAccent uppercase">
                            <?= htmlspecialchars($footerC['brandTagline'] ?? 'The Miracle Kingdom') ?>
                        </p>
                    </div>
                </div>
                <p class="mb-3 text-sm leading-relaxed text-gray-300">
                    <?= htmlspecialchars($footerC['about1'] ?? "TMK Foundation est une organisation à but non lucratif engagée à transformer durablement des vies par l’éducation, la solidarité sociale et le développement communautaire.") ?>
                </p>
                <p class="mb-6 text-sm leading-relaxed text-gray-400">
                    <?= htmlspecialchars($footerC['about2'] ?? "Nous œuvrons chaque jour pour bâtir des communautés plus justes, inclusives et résilientes.") ?>
                </p>

                <div class="footer-social-icons flex items-center space-x-3">
                    <a href="<?= htmlspecialchars($fSocial['facebook'] ?? 'https://www.facebook.com/tmkfoundation') ?>" target="_blank" rel="noopener"
                        aria-label="TMK Foundation sur Facebook"
                        class="footer-social-link footer-social-facebook flex items-center justify-center w-9 h-9 rounded-full bg-white/5 text-gray-200 transition-all duration-300 ease-out focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-black">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="<?= htmlspecialchars($fSocial['twitter'] ?? 'https://twitter.com/tmkfoundation') ?>" target="_blank" rel="noopener"
                        aria-label="TMK Foundation sur X (Twitter)"
                        class="footer-social-link footer-social-twitter flex items-center justify-center w-9 h-9 rounded-full bg-white/5 text-gray-200 transition-all duration-300 ease-out focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-black">
                        <i class="fab fa-twitter text-sm"></i>
                    </a>
                    <a href="<?= htmlspecialchars($fSocial['linkedin'] ?? 'https://www.linkedin.com/company/tmkfoundation') ?>" target="_blank" rel="noopener"
                        aria-label="TMK Foundation sur LinkedIn"
                        class="footer-social-link footer-social-linkedin flex items-center justify-center w-9 h-9 rounded-full bg-white/5 text-gray-200 transition-all duration-300 ease-out focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-black">
                        <i class="fab fa-linkedin-in text-sm"></i>
                    </a>
                    <a href="<?= htmlspecialchars($fSocial['instagram'] ?? 'https://www.instagram.com/tmkfoundation') ?>" target="_blank" rel="noopener"
                        aria-label="TMK Foundation sur Instagram"
                        class="footer-social-link footer-social-instagram flex items-center justify-center w-9 h-9 rounded-full bg-white/5 text-gray-200 transition-all duration-300 ease-out focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-black">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="<?= htmlspecialchars($fSocial['whatsapp'] ?? 'https://wa.me/+243978219845') ?>" target="_blank" rel="noopener"
                        aria-label="Contacter TMK Foundation sur WhatsApp"
                        class="footer-social-link footer-social-whatsapp flex items-center justify-center w-9 h-9 rounded-full bg-white/5 text-gray-200 transition-all duration-300 ease-out focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-black">
                        <i class="fab fa-whatsapp text-sm"></i>
                    </a>
                    <a href="<?= htmlspecialchars($fSocial['youtube'] ?? 'https://www.youtube.com/@tmkfoundation') ?>" target="_blank" rel="noopener"
                        aria-label="Chaîne YouTube TMK Foundation"
                        class="footer-social-link footer-social-youtube flex items-center justify-center w-9 h-9 rounded-full bg-white/5 text-gray-200 transition-all duration-300 ease-out focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-offset-black">
                        <i class="fab fa-youtube text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- Column 2 - Quick Links -->
            <div class="md:border-l md:border-white/10 md:pl-6">
                <h3 class="text-sm font-semibold tracking-wide text-white uppercase">
                    Liens rapides
                </h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li>
                        <a href="index.php"
                            class="inline-flex items-center text-gray-300 transition-colors duration-200 hover:text-tmkAccent hover:underline underline-offset-4">
                            <span class="mr-2 text-xs text-tmkAccent">●</span>
                            Accueil
                        </a>
                    </li>
                    <li>
                        <a href="about.php"
                            class="inline-flex items-center text-gray-300 transition-colors duration-200 hover:text-tmkAccent hover:underline underline-offset-4">
                            <span class="mr-2 text-xs text-tmkAccent">●</span>
                            À propos de nous
                        </a>
                    </li>
                    <li>
                        <a href="#programmes"
                            class="inline-flex items-center text-gray-300 transition-colors duration-200 hover:text-tmkAccent hover:underline underline-offset-4">
                            <span class="mr-2 text-xs text-tmkAccent">●</span>
                            Nos programmes
                        </a>
                    </li>
                    <li>
                        <a href="#projects"
                            class="inline-flex items-center text-gray-300 transition-colors duration-200 hover:text-tmkAccent hover:underline underline-offset-4">
                            <span class="mr-2 text-xs text-tmkAccent">●</span>
                            Projets
                        </a>
                    </li>
                    <li>
                        <a href="#events"
                            class="inline-flex items-center text-gray-300 transition-colors duration-200 hover:text-tmkAccent hover:underline underline-offset-4">
                            <span class="mr-2 text-xs text-tmkAccent">●</span>
                            Événements
                        </a>
                    </li>
                    <li>
                        <a href="#blog"
                            class="inline-flex items-center text-gray-300 transition-colors duration-200 hover:text-tmkAccent hover:underline underline-offset-4">
                            <span class="mr-2 text-xs text-tmkAccent">●</span>
                            Blog &amp; actualités
                        </a>
                    </li>
                    <li>
                        <a href="#careers"
                            class="inline-flex items-center text-gray-300 transition-colors duration-200 hover:text-tmkAccent hover:underline underline-offset-4">
                            <span class="mr-2 text-xs text-tmkAccent">●</span>
                            Carrières &amp; bénévolat
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 3 - Contact Information -->
            <div class="md:border-l md:border-white/10 md:pl-6 footer-contact-block">
                <h3 class="text-sm font-semibold tracking-wide text-white uppercase">
                    Contact
                </h3>
                <div class="mt-4 space-y-3 text-sm text-white">
                    <div class="flex items-start space-x-3">
                        <span class="mt-0.5 text-tmkAccent">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        <p>
                            <?= htmlspecialchars($fContact['orgName'] ?? 'TMK Foundation') ?><br>
                            <?= htmlspecialchars($fContact['address'] ?? 'Kinshasa, République Démocratique du Congo') ?>
                        </p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <span class="mt-0.5 text-tmkAccent">
                            <i class="fas fa-phone-alt"></i>
                        </span>
                        <p>
                            <?php $fp1 = $fContact['phone1'] ?? '+243 978 219 845'; $fp2 = $fContact['phone2'] ?? '+243 974 555 964'; ?>
                            <?php if (!empty($fp1)): ?>
                            <a href="<?= htmlspecialchars($telHref($fp1)) ?>"
                                class="text-white transition-colors duration-200 hover:text-tmkAccent hover:underline underline-offset-4">
                                <?= htmlspecialchars($fp1) ?>
                            </a><br>
                            <?php endif; ?>
                            <?php if (!empty($fp2)): ?>
                            <a href="<?= htmlspecialchars($telHref($fp2)) ?>"
                                class="text-white transition-colors duration-200 hover:text-tmkAccent hover:underline underline-offset-4">
                                <?= htmlspecialchars($fp2) ?>
                            </a>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <span class="mt-0.5 text-tmkAccent">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <p>
                            <?php $fEmail = $fContact['email'] ?? 'contact@tmkfoundation.org'; ?>
                            <a href="mailto:<?= htmlspecialchars($fEmail) ?>"
                                class="text-white transition-colors duration-200 hover:text-tmkAccent hover:underline underline-offset-4">
                                <?= htmlspecialchars($fEmail) ?>
                            </a>
                        </p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <span class="mt-0.5 text-tmkAccent">
                            <i class="fas fa-clock"></i>
                        </span>
                        <p>
                            <?= htmlspecialchars($fContact['hours1'] ?? 'Lundi - Vendredi : 8h00 - 17h00') ?><br>
                            <?= htmlspecialchars($fContact['hours2'] ?? 'Samedi : 9h00 - 13h00') ?>
                        </p>
                    </div>
                </div>

                <div class="mt-5">
                    <!-- Fallback si adresse introuvable : https://www.google.com/maps/search/?api=1&query=-4.3317,15.3139 -->
                    <a href="<?= htmlspecialchars($fContact['mapsUrl'] ?? 'https://www.google.com/maps/search/?api=1&query=Avenue+Dimba+boma+203+Quartier+Lumumba+Commune+Bandungwa+Kinshasa+RDC') ?>" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-wide text-[#1a1a2e] rounded-full shadow-md hover:bg-[#5a6a9e] hover:text-yellow-400 transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#6B7DB3] focus-visible:ring-offset-black"
                        style="background-color: #6B7DB3;">
                        <i class="mr-2 text-sm fas fa-location-arrow"></i>
                        Nous trouver sur Google Maps
                    </a>
                </div>
            </div>

            <!-- Column 4 - Newsletter Subscription -->
            <div class="md:border-l md:border-white/10 md:pl-6">
                <h3 class="text-sm font-semibold tracking-wide text-white uppercase">
                    <?= htmlspecialchars($footerC['newsletterTitle'] ?? 'Restez connectés') ?>
                </h3>
                <p class="mt-4 text-sm text-gray-300">
                    <?= htmlspecialchars($footerC['newsletterText'] ?? "Recevez les dernières nouvelles sur nos projets, nos événements et l’impact de vos dons.") ?>
                </p>

                <form class="mt-4 space-y-3" action="#" method="post" novalidate>
                    <label for="footer-email" class="sr-only">Adresse email</label>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-stretch">
                        <input id="footer-email" name="email" type="email" required
                            class="w-full min-w-0 sm:min-w-[280px] sm:flex-1 px-4 py-2.5 text-sm text-white placeholder-gray-400 bg-white/5 border border-white/15 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-tmkAccent focus-visible:border-tmkAccent"
                            placeholder="Entrez votre adresse email" aria-label="Adresse email">
                        <button type="submit"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold tracking-wide text-[#1a1a2e] bg-tmkAccent rounded-lg shadow-md hover:bg-tmkAccentHover transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-tmkAccent focus-visible:ring-offset-black">
                            S’abonner
                        </button>
                    </div>
                    <p class="text-xs text-gray-400">
                        En vous inscrivant, vous acceptez de recevoir des communications de TMK Foundation. Vous
                        pouvez vous désabonner à tout moment.
                    </p>
                </form>

                <div class="mt-5 space-y-2">
                    <p class="text-xs font-semibold tracking-wide text-gray-400 uppercase">
                        Certifications &amp; crédibilité
                    </p>
                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-300">
                        <div
                            class="inline-flex items-center px-2.5 py-1 rounded-full border border-white/15 bg-white/5">
                            <i class="mr-2 text-[11px] fas fa-shield-alt text-tmkAccent"></i>
                            <span>ONG reconnue localement</span>
                        </div>
                        <div
                            class="inline-flex items-center px-2.5 py-1 rounded-full border border-white/15 bg-white/5">
                            <i class="mr-2 text-[11px] fas fa-hands-helping text-tmkAccent"></i>
                            <span>Transparence &amp; impact social</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="pt-6 mt-10 border-t border-white/10">
            <div
                class="flex flex-col items-center justify-between gap-4 text-xs text-gray-400 sm:flex-row sm:text-sm">
                <p class="text-center sm:text-left">
                    <?= htmlspecialchars($footerC['copyright'] ?? '© 2025 TMK Foundation. Tous droits réservés.') ?>
                </p>

                <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4">
                    <a href="#"
                        class="text-gray-400 transition-colors duration-200 hover:text-tmkAccent hover:underline underline-offset-4">
                        Politique de confidentialité
                    </a>
                    <span class="hidden text-gray-600 sm:inline">|</span>
                    <a href="#"
                        class="text-gray-400 transition-colors duration-200 hover:text-tmkAccent hover:underline underline-offset-4">
                        Conditions d’utilisation
                    </a>
                    <span class="hidden text-gray-600 sm:inline">|</span>
                    <a href="#"
                        class="text-gray-400 transition-colors duration-200 hover:text-tmkAccent hover:underline underline-offset-4">
                        Plan du site
                    </a>
                </div>

                <button id="tmkBackToTop" type="button"
                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-wide text-[#1a1a2e] bg-tmkAccent rounded-full shadow-md hover:bg-tmkAccentHover focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-tmkAccent focus-visible:ring-offset-black transition-transform duration-200 hover:-translate-y-0.5">
                    <span>Retour en haut</span>
                    <i class="ml-2 text-xs fas fa-arrow-up"></i>
                </button>
            </div>
        </div>
    </div>
</footer>
<!--End Footer-->

<script>
    (function () {
        var backToTop = document.getElementById('tmkBackToTop');
        if (backToTop) {
            backToTop.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    })();
</script>

<!-- Floating social shortcuts (kept from previous design) -->
<a href="https://wa.me/+243978219845" class="whatsapp" target="_blank" aria-label="WhatsApp TMK Foundation">
    <i class="fab fa-whatsapp"></i>
</a>
<a href="https://www.instagram.com/the_miracle_kingdom?igsh=aDEwN3NzdzQ2N2M3" class="instagram" target="_blank"
    aria-label="Instagram TMK Foundation">
    <i class="fab fa-instagram"></i>
</a>
<a href="https://www.facebook.com/share/1BreVXkWm5" class="facebook" target="_blank"
    aria-label="Facebook TMK Foundation">
    <i class="fab fa-facebook"></i>
</a>


<!--Plugins-->
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/owl-carousel/owl.carousel.js"></script>
<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript" src="js/jquery.easypiechart.js"></script>
<script type="text/javascript" src="js/jquery.appear.js"></script>
<script type="text/javascript" src="js/jquery.parallax-1.1.3.js"></script>
<script type="text/javascript" src="js/jquery.mixitup.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>

<?php
// ═══════════════════════════════════════════════════════════════
// CHATBOT ET CHAT EN DIRECT - TMK FOUNDATION
// ═══════════════════════════════════════════════════════════════

// Charger la configuration du chat en direct (Tawk.to)
if (file_exists(__DIR__ . '/../config/chat-config.php')) {
    require_once __DIR__ . '/../config/chat-config.php';
    
    // Afficher le widget Tawk.to si activé
    if (defined('TAWK_ENABLED') && TAWK_ENABLED === true && 
        defined('TAWK_WIDGET_ID') && TAWK_WIDGET_ID !== 'VOTRE_WIDGET_ID') {
        
        $widgetId = TAWK_WIDGET_ID;
        $widgetKey = defined('TAWK_WIDGET_KEY') ? TAWK_WIDGET_KEY : 'default';
        ?>
        
        <!--Start of Tawk.to Script (Chat en Direct avec Humains)-->
        <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/<?php echo htmlspecialchars($widgetId); ?>/<?php echo htmlspecialchars($widgetKey); ?>';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
        </script>
        <!--End of Tawk.to Script-->
        
        <?php
    }
}

// Charger la configuration du chatbot IA
if (file_exists(__DIR__ . '/../config/chatbot-ia-config.php')) {
    require_once __DIR__ . '/../config/chatbot-ia-config.php';
    
    // ═══════════════════════════════════════════════════════════════
    // TIDIO - Chatbot IA avec Réponses Automatiques
    // ═══════════════════════════════════════════════════════════════
    if (defined('TIDIO_ENABLED') && TIDIO_ENABLED === true && 
        defined('TIDIO_ID') && TIDIO_ID !== 'VOTRE_TIDIO_ID') {
        
        $tidioId = TIDIO_ID;
        ?>
        
        <!--Start of Tidio Chatbot IA Script-->
        <script src="//code.tidio.co/<?php echo htmlspecialchars($tidioId); ?>.js" async></script>
        <!--End of Tidio Chatbot IA Script-->
        
        <?php
    }
    
    // ═══════════════════════════════════════════════════════════════
    // CHATBASE - Chatbot IA basé sur GPT-4
    // ═══════════════════════════════════════════════════════════════
    if (defined('CHATBASE_ENABLED') && CHATBASE_ENABLED === true && 
        defined('CHATBASE_ID') && CHATBASE_ID !== 'VOTRE_CHATBASE_ID') {
        
        $chatbaseId = CHATBASE_ID;
        $chatbaseDomain = defined('CHATBASE_DOMAIN') ? CHATBASE_DOMAIN : 'www.chatbase.co';
        ?>
        
        <!--Start of Chatbase IA Script-->
        <script>
          window.embeddedChatbotConfig = {
            chatbotId: "<?php echo htmlspecialchars($chatbaseId); ?>",
            domain: "<?php echo htmlspecialchars($chatbaseDomain); ?>"
          }
        </script>
        <script
          src="https://<?php echo htmlspecialchars($chatbaseDomain); ?>/embed.min.js"
          chatbotId="<?php echo htmlspecialchars($chatbaseId); ?>"
          domain="<?php echo htmlspecialchars($chatbaseDomain); ?>"
          defer>
        </script>
        <!--End of Chatbase IA Script-->
        
        <?php
    }
    
    // ═══════════════════════════════════════════════════════════════
    // KOMMUNICATE - Chatbot IA Gratuit Illimité
    // ═══════════════════════════════════════════════════════════════
    if (defined('KOMMUNICATE_ENABLED') && KOMMUNICATE_ENABLED === true && 
        defined('KOMMUNICATE_APP_ID') && KOMMUNICATE_APP_ID !== 'VOTRE_APP_ID') {
        
        $kommunicateAppId = KOMMUNICATE_APP_ID;
        ?>
        
        <!--Start of Kommunicate Chatbot IA Script-->
        <script type="text/javascript">
        (function(d, m){
          var kommunicateSettings = {
            "appId":"<?php echo htmlspecialchars($kommunicateAppId); ?>",
            "automaticChatOpenOnNavigation": true,
            "popupWidget": true
          };
          var s = document.createElement("script"); 
          s.type = "text/javascript"; 
          s.async = true;
          s.src = "https://widget.kommunicate.io/v2/kommunicate.app";
          var h = document.getElementsByTagName("head")[0]; 
          h.appendChild(s);
          window.kommunicate = m; 
          m._globals = kommunicateSettings;
        })(document, window.kommunicate || {});
        </script>
        <!--End of Kommunicate Chatbot IA Script-->
        
        <?php
    }
}
?>

</body>
</html>
