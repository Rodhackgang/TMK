<?php
/**
 * Configuration de l'API Backend
 * URL du backend déployé
 */

// URL de l'API Backend (production)
if (!defined('API_BASE_URL')) {
    define('API_BASE_URL', 'http://pgock44oggg0gg4k44ww8ogc.185.185.80.119.sslip.io');
}

// Mode de fonctionnement : 'api' (toujours utiliser l'API) ou 'local' (fichiers JSON locaux d'abord)
// En production avec backend distant, utiliser 'api'
if (!defined('API_MODE')) {
    define('API_MODE', 'api');
}

// Activer les logs (true pour debug, false en production)
if (!defined('API_DEBUG')) {
    define('API_DEBUG', false);
}

// Fichier de log
define('API_LOG_FILE', __DIR__ . '/../logs/api-debug.log');

/**
 * Fonction de logging
 */
function apiLog($message, $data = null) {
    if (!API_DEBUG) return;
    
    // Créer le dossier logs s'il n'existe pas (silencieux : pas de warning si interdit en écriture)
    $logDir = dirname(API_LOG_FILE);
    if (!is_dir($logDir)) {
        if (!@mkdir($logDir, 0755, true) && !is_dir($logDir)) {
            return; // dossier de logs non créable (ex: système de fichiers en lecture seule) -> on abandonne
        }
    }

    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message";
    
    if ($data !== null) {
        if (is_array($data) || is_object($data)) {
            $logMessage .= " | Data: " . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            $logMessage .= " | $data";
        }
    }
    
    $logMessage .= "\n" . str_repeat('-', 80) . "\n";

    @file_put_contents(API_LOG_FILE, $logMessage, FILE_APPEND | LOCK_EX);
}

/**
 * Fonction helper pour construire les URLs de l'API
 */
function api_url($endpoint) {
    return API_BASE_URL . $endpoint;
}

/**
 * Fonction pour récupérer le contenu depuis l'API ou un fichier JSON local
 * @param string $jsonFile - Chemin vers le fichier JSON local (fallback)
 * @param string $apiEndpoint - Endpoint de l'API (ex: '/api/content/home')
 * @return array - Contenu décodé ou tableau vide
 */
function getContentFromJsonOrApi($jsonFile, $apiEndpoint) {
    apiLog("📥 getContentFromJsonOrApi appelée", [
        'endpoint' => $apiEndpoint,
        'jsonFile' => $jsonFile,
        'mode' => API_MODE
    ]);
    
    // En mode API, toujours utiliser l'API distante d'abord
    if (API_MODE === 'api') {
        apiLog("🌐 Mode API: Tentative de récupération depuis l'API distante...");
        $data = fetchFromApi($apiEndpoint);
        
        if ($data) {
            apiLog("✅ Données récupérées depuis l'API avec succès", [
                'endpoint' => $apiEndpoint,
                'dataKeys' => is_array($data) ? array_keys($data) : 'non-array'
            ]);
            return $data;
        }
        
        apiLog("⚠️ API échouée, fallback vers fichier local...");
        $localData = readLocalJson($jsonFile);
        
        if ($localData) {
            apiLog("✅ Données récupérées depuis fichier local");
        } else {
            apiLog("❌ Aucune donnée trouvée (ni API, ni fichier local)");
        }
        
        return $localData ?: [];
    }
    
    // En mode local, utiliser le fichier JSON d'abord (pour développement)
    apiLog("📁 Mode LOCAL: Tentative de lecture du fichier JSON local...");
    $data = readLocalJson($jsonFile);
    
    if ($data) {
        apiLog("✅ Données récupérées depuis fichier local");
        return $data;
    }
    
    apiLog("⚠️ Fichier local non trouvé, fallback vers l'API...");
    return fetchFromApi($apiEndpoint) ?: [];
}

/**
 * Récupérer les données depuis l'API distante
 * Utilise cURL si disponible, sinon file_get_contents()
 */
function fetchFromApi($apiEndpoint) {
    $apiUrl = API_BASE_URL . $apiEndpoint;
    apiLog("🔗 Appel API: $apiUrl");
    
    $startTime = microtime(true);
    
    // Méthode 1: Utiliser cURL si disponible
    if (function_exists('curl_init')) {
        apiLog("📡 Utilisation de cURL...");
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json'
        ]);
        
        $response = @curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        $errno = curl_errno($ch);
        curl_close($ch);
        
        $duration = round((microtime(true) - $startTime) * 1000, 2);
        
        apiLog("📊 Réponse cURL", [
            'url' => $apiUrl,
            'httpCode' => $httpCode,
            'duration' => $duration . 'ms',
            'responseLength' => strlen($response) . ' bytes',
            'error' => $error ?: 'aucune'
        ]);
        
        if ($httpCode === 200 && $response) {
            return parseJsonResponse($response, $apiUrl);
        }
        
        if ($error) {
            apiLog("❌ Erreur cURL: $error (code: $errno)");
        }
        
        return null;
    }
    
    // Méthode 2: Utiliser file_get_contents() comme alternative
    apiLog("📡 cURL non disponible, utilisation de file_get_contents()...");
    
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "Accept: application/json\r\nContent-Type: application/json\r\n",
            'timeout' => 10,
            'ignore_errors' => true
        ]
    ]);
    
    $response = @file_get_contents($apiUrl, false, $context);
    $duration = round((microtime(true) - $startTime) * 1000, 2);
    
    // Récupérer le code HTTP depuis les headers de réponse
    $httpCode = 0;
    if (isset($http_response_header) && is_array($http_response_header)) {
        foreach ($http_response_header as $header) {
            if (preg_match('/HTTP\/\d+\.\d+\s+(\d+)/', $header, $matches)) {
                $httpCode = (int)$matches[1];
                break;
            }
        }
    }
    
    apiLog("📊 Réponse file_get_contents", [
        'url' => $apiUrl,
        'httpCode' => $httpCode,
        'duration' => $duration . 'ms',
        'responseLength' => $response ? strlen($response) . ' bytes' : '0 bytes',
        'success' => $response !== false ? 'oui' : 'non'
    ]);
    
    if ($response !== false && ($httpCode === 200 || $httpCode === 0)) {
        return parseJsonResponse($response, $apiUrl);
    }
    
    apiLog("❌ Échec de la requête HTTP (code: $httpCode)");
    return null;
}

/**
 * Parser la réponse JSON
 */
function parseJsonResponse($response, $apiUrl) {
    $data = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        apiLog("❌ Erreur JSON decode: " . json_last_error_msg());
        apiLog("📄 Réponse brute (100 premiers chars): " . substr($response, 0, 100));
        return null;
    }
    
    if ($data) {
        apiLog("✅ API réussie - Données parsées correctement", [
            'dataType' => gettype($data),
            'isArray' => is_array($data) ? 'oui' : 'non',
            'count' => is_array($data) ? count($data) : 'N/A'
        ]);
        return $data;
    }
    
    return null;
}

/**
 * Lire un fichier JSON local
 */
function readLocalJson($jsonFile) {
    apiLog("📁 Tentative lecture fichier: $jsonFile");
    
    if (!file_exists($jsonFile)) {
        apiLog("❌ Fichier non trouvé: $jsonFile");
        return null;
    }
    
    $content = @file_get_contents($jsonFile);
    
    if (!$content) {
        apiLog("❌ Impossible de lire le fichier: $jsonFile");
        return null;
    }
    
    $data = json_decode($content, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        apiLog("❌ Erreur JSON dans fichier: " . json_last_error_msg());
        return null;
    }
    
    apiLog("✅ Fichier lu avec succès", [
        'file' => basename($jsonFile),
        'size' => strlen($content) . ' bytes'
    ]);
    
    return $data;
}

/**
 * Afficher les logs dans la page (pour debug rapide)
 */
function showApiLogs() {
    if (!API_DEBUG || !file_exists(API_LOG_FILE)) {
        echo "<p>Aucun log disponible</p>";
        return;
    }
    
    $logs = file_get_contents(API_LOG_FILE);
    echo "<pre style='background:#1e1e1e;color:#0f0;padding:20px;font-size:12px;max-height:500px;overflow:auto;'>";
    echo htmlspecialchars($logs);
    echo "</pre>";
}

/**
 * Vider les logs
 */
function clearApiLogs() {
    if (file_exists(API_LOG_FILE)) {
        file_put_contents(API_LOG_FILE, '');
        apiLog("🗑️ Logs vidés");
    }
}

// Log au chargement de la config
apiLog("🚀 API Config chargée", [
    'API_BASE_URL' => API_BASE_URL,
    'API_MODE' => API_MODE,
    'API_DEBUG' => API_DEBUG ? 'activé' : 'désactivé'
]);
