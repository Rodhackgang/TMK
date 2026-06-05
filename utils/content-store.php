<?php
/**
 * ════════════════════════════════════════════════════════════════
 *  TMK - Magasin de contenu local (administrable)
 * ════════════════════════════════════════════════════════════════
 *  Ce fichier permet de lire / écrire le contenu éditable du site
 *  dans des fichiers JSON locaux (dossier /content).
 *
 *  Le panneau d'administration (/admin) écrit dans ces fichiers,
 *  et les pages publiques les lisent grâce à tmk_content().
 *
 *  Aucune base de données ni API distante n'est requise : tout
 *  fonctionne en local (XAMPP / WAMP / hébergement PHP simple).
 * ════════════════════════════════════════════════════════════════
 */

if (!defined('TMK_CONTENT_DIR')) {
    define('TMK_CONTENT_DIR', __DIR__ . '/../content');
}
if (!defined('TMK_UPLOAD_DIR')) {
    define('TMK_UPLOAD_DIR', __DIR__ . '/../uploads');
}

/**
 * Lit un fichier de contenu JSON et le fusionne avec des valeurs par défaut.
 *
 * @param string $name      Nom logique du contenu (ex: 'home', 'footer')
 * @param array  $defaults  Valeurs par défaut (utilisées si le fichier n'existe pas)
 * @return array
 */
function tmk_content($name, $defaults = [])
{
    $file = TMK_CONTENT_DIR . '/' . basename($name) . '.json';
    if (is_file($file)) {
        $raw = @file_get_contents($file);
        $data = json_decode($raw, true);
        if (is_array($data)) {
            // Complète les clés manquantes de premier niveau par les défauts
            foreach ($defaults as $k => $v) {
                if (!array_key_exists($k, $data)) {
                    $data[$k] = $v;
                }
            }
            return $data;
        }
    }
    return $defaults;
}

/**
 * Enregistre un contenu dans son fichier JSON.
 *
 * @return bool
 */
function tmk_save_content($name, $data)
{
    if (!is_dir(TMK_CONTENT_DIR)) {
        @mkdir(TMK_CONTENT_DIR, 0775, true);
    }
    $file = TMK_CONTENT_DIR . '/' . basename($name) . '.json';
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }
    return @file_put_contents($file, $json, LOCK_EX) !== false;
}

/**
 * Gère l'upload d'un fichier (image ou vidéo) vers /uploads.
 * Retourne le chemin relatif (ex: "uploads/xxx.jpg") ou la valeur
 * courante $current si aucun fichier n'a été envoyé.
 *
 * @param string $fileKey  Clé du champ <input type="file" name="...">
 * @param array  $allowed  Extensions autorisées
 * @param string $current  Chemin existant à conserver si pas de nouvel upload
 * @return string
 */
function tmk_handle_upload($fileKey, $allowed, $current = '')
{
    if (empty($_FILES[$fileKey]) || !isset($_FILES[$fileKey]['error'])) {
        return $current;
    }
    $f = $_FILES[$fileKey];
    if ($f['error'] === UPLOAD_ERR_NO_FILE) {
        return $current;
    }
    if ($f['error'] !== UPLOAD_ERR_OK) {
        return $current;
    }
    $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed, true)) {
        return $current;
    }
    if (!is_dir(TMK_UPLOAD_DIR)) {
        @mkdir(TMK_UPLOAD_DIR, 0775, true);
    }
    $base = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($f['name'], PATHINFO_FILENAME));
    if ($base === '') {
        $base = 'file';
    }
    $name = $base . '_' . substr(md5(uniqid('', true)), 0, 8) . '.' . $ext;
    $dest = TMK_UPLOAD_DIR . '/' . $name;
    if (move_uploaded_file($f['tmp_name'], $dest)) {
        return 'uploads/' . $name;
    }
    return $current;
}

/**
 * Variante de tmk_handle_upload pour un champ fichier multiple (name="x[]").
 * Gère le fichier à l'index $index du tableau $_FILES[$fileKey].
 *
 * @return string  Chemin relatif du fichier, ou $current si pas de nouvel upload.
 */
function tmk_handle_upload_indexed($fileKey, $index, $allowed, $current = '')
{
    if (empty($_FILES[$fileKey]) || !isset($_FILES[$fileKey]['error'][$index])) {
        return $current;
    }
    $error = $_FILES[$fileKey]['error'][$index];
    if ($error === UPLOAD_ERR_NO_FILE || $error !== UPLOAD_ERR_OK) {
        return $current;
    }
    $name = $_FILES[$fileKey]['name'][$index];
    $tmp = $_FILES[$fileKey]['tmp_name'][$index];
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed, true)) {
        return $current;
    }
    if (!is_dir(TMK_UPLOAD_DIR)) {
        @mkdir(TMK_UPLOAD_DIR, 0775, true);
    }
    $base = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($name, PATHINFO_FILENAME));
    if ($base === '') {
        $base = 'file';
    }
    $newName = $base . '_' . substr(md5(uniqid('', true)), 0, 8) . '.' . $ext;
    $dest = TMK_UPLOAD_DIR . '/' . $newName;
    if (move_uploaded_file($tmp, $dest)) {
        return 'uploads/' . $newName;
    }
    return $current;
}

/**
 * Valeurs par défaut de chaque section. Ce sont les contenus
 * actuellement affichés sur le site : ils servent à initialiser
 * l'administration et de secours si un fichier JSON est absent.
 */
function tmk_defaults($name)
{
    $defaults = [

        // ───────────────────────── ACCUEIL ─────────────────────────
        'home' => [
            'hero' => [
                'videoUrl' => 'images/1.mp4',
                'title' => 'Un avenir meilleur pour tous',
                'subtitle' => 'Agissons ensemble pour un changement durable',
                'donateButtonText' => 'Faire un don',
                'videoButtonText' => 'Voir notre vidéo',
            ],
            'missionVision' => [
                'sectionTitle' => 'Notre mission & notre vision',
                'missionTitle' => 'Notre mission',
                'missionText' => "La mission de la fondation THE MIRACLE KINGDOM est de mettre en œuvre des actions d’intérêt général visant à soutenir les personnes démunies et vulnérables, et à aider les populations à devenir actrices de leur propre développement, grâce à des interventions adaptées, structurées et à fort impact social.",
                'visionTitle' => 'Notre vision',
                'visionText' => "Par sa vision, The Miracle Kingdom œuvre à la construction de sociétés plus justes, solidaires et résilientes, où chacun, en particulier les plus défavorisés, peut accéder à des conditions de vie dignes et à de réelles opportunités d’avenir.",
            ],
            'news' => [
                'sectionTitle' => 'Actualités',
                'subtitle' => "Découvrez les dernières actions et événements de la fondation THE MIRACLE KINGDOM sur le terrain.",
                'items' => [
                    [
                        'meta' => 'Dernière action',
                        'title' => 'Distribution de kits alimentaires aux familles vulnérables',
                        'text' => "La fondation a organisé une campagne de solidarité pour soutenir les ménages les plus touchés par l’insécurité alimentaire, en partenariat avec des acteurs locaux engagés.",
                        'linkText' => 'En savoir plus',
                        'link' => '#',
                    ],
                    [
                        'meta' => 'Éducation',
                        'title' => 'Lancement d’un programme de soutien scolaire pour les enfants défavorisés',
                        'text' => "Des séances d’appui scolaire et d’accompagnement psychologique ont été mises en place afin d’offrir aux enfants un cadre propice à la réussite et à l’épanouissement.",
                        'linkText' => 'Découvrir le programme',
                        'link' => '#',
                    ],
                    [
                        'meta' => 'Santé & bien-être',
                        'title' => 'Campagne de sensibilisation et de prévention en milieu rural',
                        'text' => "Des activités de prévention et de sensibilisation ont été menées pour promouvoir la santé, l’hygiène et le bien-être des communautés les plus isolées.",
                        'linkText' => 'Voir les résultats',
                        'link' => '#',
                    ],
                ],
            ],
        ],

        // ───────────────────────── PIED DE PAGE ─────────────────────────
        'footer' => [
            'brandName' => 'TMK Foundation',
            'brandTagline' => 'The Miracle Kingdom',
            'about1' => "TMK Foundation est une organisation à but non lucratif engagée à transformer durablement des vies par l’éducation, la solidarité sociale et le développement communautaire.",
            'about2' => "Nous œuvrons chaque jour pour bâtir des communautés plus justes, inclusives et résilientes.",
            'social' => [
                'facebook' => 'https://www.facebook.com/tmkfoundation',
                'twitter' => 'https://twitter.com/tmkfoundation',
                'linkedin' => 'https://www.linkedin.com/company/tmkfoundation',
                'instagram' => 'https://www.instagram.com/tmkfoundation',
                'whatsapp' => 'https://wa.me/+243978219845',
                'youtube' => 'https://www.youtube.com/@tmkfoundation',
            ],
            'contact' => [
                'orgName' => 'TMK Foundation',
                'address' => 'Kinshasa, République Démocratique du Congo',
                'phone1' => '+243 978 219 845',
                'phone2' => '+243 974 555 964',
                'email' => 'contact@tmkfoundation.org',
                'hours1' => 'Lundi - Vendredi : 8h00 - 17h00',
                'hours2' => 'Samedi : 9h00 - 13h00',
                'mapsUrl' => 'https://www.google.com/maps/search/?api=1&query=Avenue+Dimba+boma+203+Quartier+Lumumba+Commune+Bandungwa+Kinshasa+RDC',
            ],
            'newsletterTitle' => 'Restez connectés',
            'newsletterText' => "Recevez les dernières nouvelles sur nos projets, nos événements et l’impact de vos dons.",
            'copyright' => '© 2025 TMK Foundation. Tous droits réservés.',
        ],

        // ───────────────────────── À PROPOS ─────────────────────────
        'about' => [
            'sectionTitle' => "Nos Domaines d'Intervention",
            'sectionDescription' => "The Miracle Kingdom Foundation s'engage dans six domaines clés pour transformer les communautés et créer un impact durable.",
            'services' => [
                [
                    'icon' => 'fa fa-heart',
                    'iconClass' => 'humanitarian',
                    'title' => 'Aide humanitaire',
                    'description' => "Actions humanitaires menées au cœur des zones vulnérables pour répondre aux besoins alimentaires urgents des populations les plus démunis.",
                    'buttonText' => 'LIRE',
                    'buttonLink' => 'aide-humanitaire.php',
                ],
                [
                    'icon' => 'fa fa-graduation-cap',
                    'iconClass' => 'education',
                    'title' => 'Éducation pour tous',
                    'description' => "Programmes éducatifs innovantes pour les enfants et jeunes des communautés défavorisées, avec un focus sur l'alphabétisation.",
                    'buttonText' => 'LIRE',
                    'buttonLink' => 'education.php',
                ],
                [
                    'icon' => 'fa fa-stethoscope',
                    'iconClass' => 'health',
                    'title' => 'Services de Santé',
                    'description' => "Accès aux soins primaires et campagnes de prévention dans les zones reculées pour améliorer la santé communautaire.",
                    'buttonText' => 'LIRE',
                    'buttonLink' => 'sante.php',
                ],
                [
                    'icon' => 'fa fa-users',
                    'iconClass' => 'marginalized',
                    'title' => 'Projets humanitaires',
                    'description' => "Soutien spécialisé pour les réfugiés, déplacés internes et autres groupes vulnérables avec programmes de réinsertion.",
                    'buttonText' => 'LIRE',
                    'buttonLink' => 'projets-humanitaires.php',
                ],
            ],
        ],

        // ───────────────────────── PHOTOS (albums) ─────────────────────────
        'photos' => [
            'albums' => [
                [
                    'title' => 'Aide humanitaire',
                    'description' => "Actions humanitaires menées au cœur des zones vulnérables pour répondre aux besoins alimentaires urgents des populations les plus démunis.",
                    'main_image' => 'images/orphelinat_coc_2021/img-0.png',
                    'album_type' => 'Social',
                    'year' => '2021',
                    'photos_count' => 5,
                    'link' => 'aide-humanitaire.php',
                ],
                [
                    'title' => 'Éducation pour tous',
                    'description' => "Programmes éducatifs innovantes pour les enfants et jeunes des communautés défavorisées, avec un focus sur l'alphabétisation.",
                    'main_image' => 'images/complexe_scolaire_elohim_2024/1.jpg',
                    'album_type' => 'Éducation',
                    'year' => '2024',
                    'photos_count' => 4,
                    'link' => 'education.php',
                ],
                [
                    'title' => 'Services de Santé',
                    'description' => "Accès aux soins primaires et campagnes de prévention dans les zones reculées pour améliorer la santé communautaire.",
                    'main_image' => 'images/hopital_mabanga_yolo_2023/1.jpg',
                    'album_type' => 'Santé',
                    'year' => '2023',
                    'photos_count' => 4,
                    'link' => 'sante.php',
                ],
                [
                    'title' => 'Projets humanitaires',
                    'description' => "Soutien spécialisé pour les réfugiés, déplacés internes et autres groupes vulnérables avec programmes de réinsertion.",
                    'main_image' => 'images/orphelinat_marie_2024/1.jpg',
                    'album_type' => 'Humanitaire',
                    'year' => '2024',
                    'photos_count' => 4,
                    'link' => 'projets-humanitaires.php',
                ],
                [
                    'title' => 'Camp Militaire Lieutenant KOKOLO',
                    'description' => "Descente au Camp Militaire Lieutenant KOKOLO pour soutenir les veuves de militaires avec des dons de vivres et autres nécessités.",
                    'main_image' => 'images/aide-marginalises/groupe-soutenons-les-veuves.png',
                    'album_type' => 'Humanitaire',
                    'year' => '2025',
                    'photos_count' => 8,
                    'link' => 'projets-humanitaires.php',
                ],
            ],
        ],

        // ───────────────────────── VIDÉOS ─────────────────────────
        'videos' => [
            'videos' => [
                [
                    'video_path' => 'Teaser TMK.mp4',
                    'preview_image' => '',
                    'title' => 'Teaser TMK',
                    'description' => 'Découvrez le teaser TMK.',
                    'category' => 'Vidéo',
                ],
                [
                    'video_path' => 'Teaser The Miracle Kingdom.mp4',
                    'preview_image' => '',
                    'title' => 'Teaser The Miracle Kingdom',
                    'description' => 'Découvrez le teaser de The Miracle Kingdom.',
                    'category' => 'Vidéo',
                ],
                [
                    'video_path' => '1.mp4',
                    'preview_image' => '',
                    'title' => 'Réalisation Vidéo 1',
                    'description' => 'Découvrez cette réalisation vidéo',
                    'category' => 'Vidéo',
                ],
                [
                    'video_path' => '2.mp4',
                    'preview_image' => '',
                    'title' => 'Réalisation Vidéo 2',
                    'description' => 'Découvrez cette réalisation vidéo',
                    'category' => 'Vidéo',
                ],
            ],
        ],

        // ───────────────────────── MEMBRES ─────────────────────────
        'members' => [
            'sectionTitle' => 'Nos Membres',
            'members' => [
                ['name' => 'Membre 1', 'poste' => '', 'image' => 'images/member1.jpg'],
                ['name' => 'Membre 2', 'poste' => '', 'image' => 'images/member2.jpg'],
                ['name' => 'Membre 3', 'poste' => '', 'image' => 'images/member3.jpg'],
                ['name' => 'Membre 4', 'poste' => '', 'image' => 'images/member4.jpg'],
                ['name' => 'Membre 5', 'poste' => '', 'image' => 'images/member5.jpg'],
                ['name' => 'Membre 6', 'poste' => '', 'image' => 'images/member6.jpg'],
            ],
        ],

        // ───────────────────────── CONTACT ─────────────────────────
        'contact' => [
            'sectionTitle' => 'Contactez TMK',
            'infoTitle' => 'Informations de Contact',
            'phoneLabel' => 'Téléphone',
            'phoneNumber' => '+243 900 000 000',
            'emailLabel' => 'Email',
            'emailAddress' => 'contact@tmkfoundation.org',
            'addressLabel' => 'Adresse',
            'addressLine1' => 'A108 Rue Adam',
            'addressLine2' => 'Kinshasa, RDC',
            'socialTitle' => 'Suivez-nous',
            'socialLinks' => [
                ['platform' => 'Facebook', 'icon' => 'fab fa-facebook-f', 'url' => '#'],
                ['platform' => 'Twitter', 'icon' => 'fab fa-twitter', 'url' => '#'],
                ['platform' => 'Instagram', 'icon' => 'fab fa-instagram', 'url' => '#'],
                ['platform' => 'LinkedIn', 'icon' => 'fab fa-linkedin-in', 'url' => '#'],
            ],
            'formTitle' => 'Envoyez-nous un Message',
            'formDescription' => 'Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais.',
            'submitButtonText' => 'Envoyer le Message',
        ],

        // ───────────────────────── STATUT JURIDIQUE ─────────────────────────
        'juridique' => [
            'mainTitle' => "Le Statut Juridique de l'Entreprise",
            'introduction' => "Les documents concernent l'<strong>Association Sans But Lucratif (ASBL)</strong> dénommée <strong>\"THE MIRACLE KINGDOM\" (TMK)</strong> située à Kinshasa, République Démocratique du Congo. Ils retracent le processus d'obtention de la personnalité juridique et de l'autorisation d'opérer de l'association.",
            'listTitle' => 'Points clés des documents :',
            'items' => [
                ['icon' => 'fa-file-text', 'title' => 'Acte Notarié', 'description' => "Un acte notarié a été établi par le Ministère de la Justice et Garde des Sceaux, certifiant la présentation des statuts de l'association \"THE MIRACLE KINGDOM\"."],
                ['icon' => 'fa-book', 'title' => 'Statuts et Règlement Intérieur', 'description' => "Les statuts et le règlement intérieur de l'ASBL \"THE MIRACLE KINGDOM\" ont été rédigés en janvier 2023."],
                ['icon' => 'fa-envelope', 'title' => 'Accusé de Réception', 'description' => "Le Ministère de la Justice a accusé réception de la demande de personnalité juridique de l'association, et a fourni des instructions pour la constitution du dossier."],
                ['icon' => 'fa-check-circle', 'title' => 'Arrêté Ministériel et Notification', 'description' => "Le Ministère des Affaires Sociales, Actions Humanitaires et Solidarité Nationale a accordé un avis favorable à l'ASBL \"THE MIRACLE KINGDOM\", l'autorisant à exercer ses activités sur toute l'étendue de la République Démocratique du Congo."],
            ],
            'summary' => "En résumé, les documents montrent les démarches administratives et légales entreprises par l'ASBL \"THE MIRACLE KINGDOM\" pour être reconnue et autorisée à opérer en République Démocratique du Congo.",
        ],
    ];

    return $defaults[$name] ?? [];
}
