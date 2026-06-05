-- -----------------------------------------------------
-- TMK Foundation - Base de données du site
-- -----------------------------------------------------
-- À importer dans phpMyAdmin ou via la ligne de commande :
-- 1. CREATE DATABASE tmk_foundation CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- 2. USE tmk_foundation;
-- 3. Exécuter ce script.
--
-- Identifiants admin créés :
--   Email    : admin@tmkfoundation.org
--   Mot de passe : ChangeMe123!
-- Changez ce mot de passe après la première connexion.
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS admin_users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('superadmin', 'editor') NOT NULL DEFAULT 'superadmin',
    last_login_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO admin_users (name, email, password_hash, role)
VALUES ('Super Admin', 'admin', '$2y$10$WYyLeMnboCkFm9kDizx.7OjDQ71dSBcrlDlHpt4s7x9tAm94mTula', 'superadmin')
ON DUPLICATE KEY UPDATE email = email;

CREATE TABLE IF NOT EXISTS photo_albums (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) GENERATED ALWAYS AS (REPLACE(LOWER(title), ' ', '-')) STORED,
    folder VARCHAR(255) NOT NULL,
    cover_image VARCHAR(255) DEFAULT NULL,
    year VARCHAR(10) DEFAULT NULL,
    album_type VARCHAR(120) DEFAULT NULL,
    description TEXT,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    display_order INT NOT NULL DEFAULT 0,
    created_by INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admin_users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS album_photos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    album_id INT UNSIGNED NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    caption VARCHAR(255) DEFAULT NULL,
    display_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (album_id) REFERENCES photo_albums(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS videos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    video_path VARCHAR(255) NOT NULL,
    preview_image VARCHAR(255) DEFAULT NULL,
    duration VARCHAR(20) DEFAULT NULL,
    category VARCHAR(120) DEFAULT NULL,
    tags VARCHAR(255) DEFAULT NULL,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    display_order INT NOT NULL DEFAULT 0,
    created_by INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admin_users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS site_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    admin_id INT UNSIGNED NULL,
    action VARCHAR(120) NOT NULL,
    entity VARCHAR(120) NOT NULL,
    entity_id INT UNSIGNED NULL,
    payload JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admin_users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS media (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) DEFAULT NULL,
    extension VARCHAR(20) DEFAULT NULL,
    mime_type VARCHAR(120) DEFAULT NULL,
    file_size BIGINT UNSIGNED DEFAULT 0,
    media_type ENUM('image','video','document','other') NOT NULL DEFAULT 'image',
    relative_path VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    width INT UNSIGNED DEFAULT NULL,
    height INT UNSIGNED DEFAULT NULL,
    created_by INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admin_users(id) ON DELETE SET NULL,
    UNIQUE KEY unique_media_path (relative_path)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Index pour améliorer les performances
CREATE INDEX idx_photo_albums_display ON photo_albums (is_published, display_order);
CREATE INDEX idx_album_photos_album ON album_photos (album_id, display_order);
CREATE INDEX idx_videos_display ON videos (is_published, display_order);

