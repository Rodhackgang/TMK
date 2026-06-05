<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🧪 Test du Chat - TMK Foundation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .test-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 800px;
            width: 100%;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #d4202c;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #666;
            font-size: 1.1rem;
        }
        
        .test-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            border-left: 4px solid #d4202c;
        }
        
        .test-section h2 {
            color: #003366;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        
        .test-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        
        .status-icon {
            font-size: 2rem;
        }
        
        .test-info {
            flex: 1;
        }
        
        .test-info strong {
            display: block;
            color: #003366;
            margin-bottom: 5px;
        }
        
        .test-info span {
            color: #666;
            font-size: 0.9rem;
        }
        
        .code-block {
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 20px;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            line-height: 1.6;
            overflow-x: auto;
            margin: 15px 0;
        }
        
        .success {
            color: #28a745;
        }
        
        .error {
            color: #dc3545;
        }
        
        .warning {
            color: #ffc107;
        }
        
        .arrow {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #d4202c;
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            font-weight: bold;
            box-shadow: 0 10px 30px rgba(212, 32, 44, 0.4);
            animation: bounce 2s infinite;
            z-index: 999;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .instructions {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .instructions h3 {
            color: #1976d2;
            margin-bottom: 10px;
        }
        
        .instructions ol {
            margin-left: 20px;
            color: #0d47a1;
        }
        
        .instructions li {
            margin-bottom: 10px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <div class="header">
            <h1>🧪 Test du Chat Tawk.to</h1>
            <p>Diagnostic de l'intégration du chat</p>
        </div>
        
        <div class="test-section">
            <h2>📋 Vérification de la Configuration</h2>
            
            <?php
            // Test 1 : Fichier de configuration
            $configPath = __DIR__ . '/config/chat-config.php';
            $configExists = file_exists($configPath);
            ?>
            
            <div class="test-item">
                <div class="status-icon"><?php echo $configExists ? '✅' : '❌'; ?></div>
                <div class="test-info">
                    <strong>Fichier de configuration</strong>
                    <span><?php echo $configExists ? 'Trouvé : ' . $configPath : 'NON TROUVÉ : ' . $configPath; ?></span>
                </div>
            </div>
            
            <?php
            // Test 2 : Chargement de la configuration
            if ($configExists) {
                require_once $configPath;
                $tawkEnabled = defined('TAWK_ENABLED') && TAWK_ENABLED === true;
                $widgetIdDefined = defined('TAWK_WIDGET_ID') && TAWK_WIDGET_ID !== 'VOTRE_WIDGET_ID';
            } else {
                $tawkEnabled = false;
                $widgetIdDefined = false;
            }
            ?>
            
            <div class="test-item">
                <div class="status-icon"><?php echo $tawkEnabled ? '✅' : '❌'; ?></div>
                <div class="test-info">
                    <strong>Chat activé</strong>
                    <span><?php echo $tawkEnabled ? 'TAWK_ENABLED = true' : 'TAWK_ENABLED = false ou non défini'; ?></span>
                </div>
            </div>
            
            <div class="test-item">
                <div class="status-icon"><?php echo $widgetIdDefined ? '✅' : '❌'; ?></div>
                <div class="test-info">
                    <strong>Widget ID configuré</strong>
                    <span><?php 
                        if ($widgetIdDefined) {
                            echo 'Widget ID : ' . TAWK_WIDGET_ID;
                        } else {
                            echo 'Widget ID non configuré ou valeur par défaut';
                        }
                    ?></span>
                </div>
            </div>
            
            <?php if (defined('TAWK_WIDGET_KEY')): ?>
            <div class="test-item">
                <div class="status-icon">✅</div>
                <div class="test-info">
                    <strong>Widget Key configuré</strong>
                    <span>Widget Key : <?php echo TAWK_WIDGET_KEY; ?></span>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="test-section">
            <h2>🔧 Code généré</h2>
            
            <?php if ($tawkEnabled && $widgetIdDefined): ?>
                <p style="color: #28a745; margin-bottom: 15px;">
                    ✅ Le code suivant sera inséré sur vos pages :
                </p>
                
                <div class="code-block">
&lt;script type="text/javascript"&gt;
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/<?php echo TAWK_WIDGET_ID; ?>/<?php echo TAWK_WIDGET_KEY; ?>';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
})();
&lt;/script&gt;
                </div>
            <?php else: ?>
                <p style="color: #dc3545; margin-bottom: 15px;">
                    ❌ Le widget de chat ne sera PAS affiché car la configuration est incomplète.
                </p>
            <?php endif; ?>
        </div>
        
        <?php if ($tawkEnabled && $widgetIdDefined): ?>
        <div class="test-section">
            <h2>👀 Recherchez le Widget</h2>
            <p style="margin-bottom: 15px;">Le widget devrait apparaître <strong style="color: #d4202c;">en bas à droite</strong> de cette page dans quelques secondes.</p>
            <div class="arrow">
                👉 Regardez ici !
            </div>
        </div>
        <?php endif; ?>
        
        <div class="instructions">
            <h3>📝 Que faire si le widget ne s'affiche pas ?</h3>
            <ol>
                <li><strong>Videz le cache</strong> : Appuyez sur <code>Ctrl + F5</code> (Windows) ou <code>Cmd + Shift + R</code> (Mac)</li>
                <li><strong>Vérifiez votre connexion internet</strong> : Le widget Tawk.to nécessite une connexion</li>
                <li><strong>Ouvrez la console du navigateur</strong> : Appuyez sur <code>F12</code> et cherchez les erreurs</li>
                <li><strong>Testez dans un autre navigateur</strong> : Chrome, Firefox, Safari, etc.</li>
                <li><strong>Testez en navigation privée</strong> : Pour éliminer les problèmes de cache</li>
                <li><strong>Vérifiez que vous êtes "Online"</strong> sur le dashboard Tawk.to : <a href="https://dashboard.tawk.to/" target="_blank">dashboard.tawk.to</a></li>
            </ol>
        </div>
        
        <div style="text-align: center; margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 10px;">
            <p style="color: #666; margin-bottom: 10px;">
                📄 Pour appliquer le chat sur toutes vos pages, assurez-vous que chaque page inclut :
            </p>
            <code style="background: #e9ecef; padding: 5px 15px; border-radius: 5px; color: #d4202c;">
                &lt;?php require './utils/footer.php'; ?&gt;
            </code>
        </div>
    </div>

    <?php
    // Intégrer le widget Tawk.to sur cette page de test
    if ($tawkEnabled && $widgetIdDefined):
        $widgetId = TAWK_WIDGET_ID;
        $widgetKey = defined('TAWK_WIDGET_KEY') ? TAWK_WIDGET_KEY : 'default';
    ?>
    
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/<?php echo htmlspecialchars($widgetId); ?>/<?php echo htmlspecialchars($widgetKey); ?>';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        
        // Console log pour debug
        console.log('🔧 Tawk.to Widget Loading...');
        console.log('Widget ID:', '<?php echo $widgetId; ?>');
        console.log('Widget Key:', '<?php echo $widgetKey; ?>');
        console.log('URL:', 'https://embed.tawk.to/<?php echo $widgetId; ?>/<?php echo $widgetKey; ?>');
    })();
    
    // Vérifier si le widget se charge
    setTimeout(function() {
        if (typeof Tawk_API !== 'undefined' && Tawk_API.onLoad) {
            console.log('✅ Widget Tawk.to chargé avec succès !');
        } else {
            console.log('⚠️ Le widget Tawk.to ne semble pas chargé. Vérifiez votre connexion internet et la console pour les erreurs.');
        }
    }, 5000);
    </script>
    <!--End of Tawk.to Script-->
    
    <?php endif; ?>
</body>
</html>

