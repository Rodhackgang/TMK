<?php
/**
 * Page de debug pour voir les logs API
 * Accès: http://localhost:8000/debug.php
 */

require_once './utils/api-config.php';

// Action de vidage des logs
if (isset($_GET['clear'])) {
    clearApiLogs();
    header('Location: debug.php');
    exit;
}

// Test de connexion API
$testResult = null;
if (isset($_GET['test'])) {
    $endpoint = $_GET['test'];
    apiLog("🧪 Test manuel de l'endpoint: $endpoint");
    $testResult = fetchFromApi($endpoint);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug API - TMK</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: #0d1117;
            color: #c9d1d9;
            padding: 20px;
            min-height: 100vh;
        }
        h1 {
            color: #58a6ff;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .config-box {
            background: #161b22;
            border: 1px solid #30363d;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .config-box h2 {
            color: #8b949e;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }
        .config-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #21262d;
        }
        .config-item:last-child { border-bottom: none; }
        .config-key { color: #8b949e; }
        .config-value { color: #58a6ff; font-family: monospace; }
        .config-value.success { color: #3fb950; }
        .config-value.warning { color: #d29922; }
        
        .actions {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary {
            background: #238636;
            color: white;
        }
        .btn-danger {
            background: #da3633;
            color: white;
        }
        .btn-secondary {
            background: #21262d;
            color: #c9d1d9;
            border: 1px solid #30363d;
        }
        .btn:hover { opacity: 0.9; }
        
        .test-endpoints {
            background: #161b22;
            border: 1px solid #30363d;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .test-endpoints h2 {
            color: #8b949e;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }
        .endpoint-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .endpoint-btn {
            padding: 8px 15px;
            background: #21262d;
            border: 1px solid #30363d;
            border-radius: 20px;
            color: #58a6ff;
            text-decoration: none;
            font-size: 13px;
        }
        .endpoint-btn:hover {
            background: #30363d;
        }
        
        .logs-box {
            background: #0d1117;
            border: 1px solid #30363d;
            border-radius: 8px;
            overflow: hidden;
        }
        .logs-header {
            background: #161b22;
            padding: 15px 20px;
            border-bottom: 1px solid #30363d;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logs-header h2 {
            color: #8b949e;
            font-size: 14px;
            text-transform: uppercase;
        }
        .logs-content {
            padding: 20px;
            max-height: 600px;
            overflow: auto;
            font-family: 'Fira Code', 'Consolas', monospace;
            font-size: 12px;
            line-height: 1.6;
            white-space: pre-wrap;
            word-break: break-all;
        }
        .logs-content:empty::after {
            content: "Aucun log disponible. Visitez une page du site pour générer des logs.";
            color: #8b949e;
        }
        
        .test-result {
            background: #161b22;
            border: 1px solid #30363d;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .test-result h2 {
            color: #3fb950;
            margin-bottom: 15px;
        }
        .test-result pre {
            background: #0d1117;
            padding: 15px;
            border-radius: 6px;
            overflow: auto;
            max-height: 300px;
        }
        
        .refresh-note {
            text-align: center;
            color: #8b949e;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>🔧 Debug API - TMK Foundation</h1>
    
    <!-- Configuration actuelle -->
    <div class="config-box">
        <h2>⚙️ Configuration actuelle</h2>
        <div class="config-item">
            <span class="config-key">API_BASE_URL</span>
            <span class="config-value"><?= API_BASE_URL ?></span>
        </div>
        <div class="config-item">
            <span class="config-key">API_MODE</span>
            <span class="config-value <?= API_MODE === 'api' ? 'success' : 'warning' ?>"><?= API_MODE ?></span>
        </div>
        <div class="config-item">
            <span class="config-key">API_DEBUG</span>
            <span class="config-value <?= API_DEBUG ? 'success' : '' ?>"><?= API_DEBUG ? 'Activé' : 'Désactivé' ?></span>
        </div>
        <div class="config-item">
            <span class="config-key">Fichier de log</span>
            <span class="config-value"><?= API_LOG_FILE ?></span>
        </div>
    </div>
    
    <!-- Actions -->
    <div class="actions">
        <a href="debug.php" class="btn btn-primary">🔄 Rafraîchir</a>
        <a href="debug.php?clear=1" class="btn btn-danger" onclick="return confirm('Vider tous les logs ?')">🗑️ Vider les logs</a>
        <a href="index.php" class="btn btn-secondary" target="_blank">🏠 Voir le site</a>
        <a href="<?= API_BASE_URL ?>/admin" class="btn btn-secondary" target="_blank">⚡ Admin Backend</a>
    </div>
    
    <!-- Tester les endpoints -->
    <div class="test-endpoints">
        <h2>🧪 Tester les endpoints API</h2>
        <div class="endpoint-list">
            <a href="debug.php?test=/api/links" class="endpoint-btn">/api/links</a>
            <a href="debug.php?test=/api/content/home" class="endpoint-btn">/api/content/home</a>
            <a href="debug.php?test=/api/content/about" class="endpoint-btn">/api/content/about</a>
            <a href="debug.php?test=/api/content/history" class="endpoint-btn">/api/content/history</a>
            <a href="debug.php?test=/api/content/team" class="endpoint-btn">/api/content/team</a>
            <a href="debug.php?test=/api/content/contact" class="endpoint-btn">/api/content/contact</a>
            <a href="debug.php?test=/api/content/juridical" class="endpoint-btn">/api/content/juridical</a>
        </div>
    </div>
    
    <?php if ($testResult !== null): ?>
    <!-- Résultat du test -->
    <div class="test-result">
        <h2>✅ Résultat du test: <?= htmlspecialchars($_GET['test']) ?></h2>
        <pre><?= htmlspecialchars(json_encode($testResult, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
    </div>
    <?php endif; ?>
    
    <!-- Logs -->
    <div class="logs-box">
        <div class="logs-header">
            <h2>📋 Logs API</h2>
            <span style="color: #8b949e; font-size: 12px;">
                <?php 
                if (file_exists(API_LOG_FILE)) {
                    echo 'Taille: ' . round(filesize(API_LOG_FILE) / 1024, 2) . ' KB';
                }
                ?>
            </span>
        </div>
        <div class="logs-content"><?php
            if (file_exists(API_LOG_FILE)) {
                $logs = file_get_contents(API_LOG_FILE);
                // Afficher les logs les plus récents en premier
                $logLines = array_filter(explode(str_repeat('-', 80), $logs));
                $logLines = array_reverse($logLines);
                echo htmlspecialchars(implode(str_repeat('-', 80) . "\n", $logLines));
            }
        ?></div>
    </div>
    
    <p class="refresh-note">
        💡 Les logs sont mis à jour automatiquement à chaque requête API. Rafraîchissez cette page pour voir les nouveaux logs.
    </p>
</body>
</html>
