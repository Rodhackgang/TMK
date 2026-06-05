# 💬 Guide d'Intégration du Chat en Direct

## 🎯 Système de Chat Intégré

Votre site web est maintenant configuré pour utiliser **Tawk.to**, un système de chat en direct gratuit et professionnel.

---

## 📋 Instructions d'Installation

### Étape 1 : Créer un compte Tawk.to (GRATUIT)

1. Allez sur [https://www.tawk.to](https://www.tawk.to)
2. Cliquez sur **"Sign Up Free"**
3. Remplissez le formulaire :
   - Nom
   - Email
   - Mot de passe
4. Vérifiez votre email et activez votre compte

### Étape 2 : Créer votre Widget de Chat

1. Connectez-vous à votre dashboard Tawk.to
2. Allez dans **Administration** > **Channels** > **Chat Widget**
3. Configurez votre widget :
   - **Nom du widget** : TMK Foundation Chat
   - **Couleur** : #d4202c (rouge TMK)
   - **Position** : Coin inférieur droit
   - **Message d'accueil** : "Bonjour ! Comment pouvons-nous vous aider ?"

### Étape 3 : Récupérer le Code d'Intégration

1. Dans le dashboard, allez à **Administration** > **Property Settings**
2. Cliquez sur **"Direct Chat Link"** ou **"Widget Code"**
3. Vous verrez un code comme celui-ci :

```javascript
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/XXXXXXXXXXXXXX/1YYYYYYYYYY';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
```

4. **Copiez** les deux IDs :
   - **WIDGET_ID** : `XXXXXXXXXXXXXX` (après `/tawk.to/`)
   - **WIDGET_KEY** : `1YYYYYYYYYY` (après le Widget ID)

### Étape 4 : Configurer sur Votre Site

1. Ouvrez le fichier : **`config/chat-config.php`**
2. Remplacez les valeurs :

```php
define('TAWK_ENABLED', true); // Activer le chat
define('TAWK_WIDGET_ID', 'XXXXXXXXXXXXXX'); // Votre Widget ID
define('TAWK_WIDGET_KEY', '1YYYYYYYYYY'); // Votre Widget Key
```

3. Sauvegardez le fichier
4. **C'est tout !** Le chat apparaîtra automatiquement sur toutes les pages

---

## ✅ Fonctionnalités Gratuites de Tawk.to

✓ **Chat en direct illimité**
✓ **Agents illimités**
✓ **Historique des conversations**
✓ **Applications mobiles** (iOS & Android)
✓ **Notifications en temps réel**
✓ **Déclencheurs automatiques**
✓ **Messages pré-enregistrés**
✓ **Statistiques et rapports**
✓ **Support multilingue**
✓ **Personnalisation complète**

---

## 🎨 Personnalisation du Widget

### Changer la Couleur

1. Dashboard Tawk.to > **Administration** > **Chat Widget**
2. Cliquez sur **"Customize"**
3. Changez la couleur principale en **#d4202c** (rouge TMK)
4. Cliquez sur **"Save Changes"**

### Personnaliser le Message d'Accueil

1. Allez dans **Shortcuts** > **Welcome Message**
2. Créez un message personnalisé :

```
👋 Bienvenue chez TMK Foundation !

Nous sommes là pour vous aider. Comment pouvons-nous vous assister aujourd'hui ?

📞 Besoin d'aide urgente ? Contactez-nous directement !
```

### Définir les Heures d'Ouverture

1. Allez dans **Administration** > **Chat Widget** > **Working Hours**
2. Définissez vos horaires de disponibilité
3. Configurez un message automatique pour les heures de fermeture

---

## 🔧 Configuration Avancée

### Ajouter des Agents

1. **Administration** > **Agents**
2. Cliquez sur **"Add Agent"**
3. Entrez l'email de votre agent
4. Définissez son rôle (Admin, Agent)

### Créer des Déclencheurs

1. **Administration** > **Triggers**
2. Créez un déclencheur, exemple :
   - **Si** : Visiteur sur la page pendant 30 secondes
   - **Alors** : Afficher le message "Besoin d'aide ?"

### Intégrer avec WhatsApp

1. **Administration** > **Channels** > **WhatsApp**
2. Connectez votre numéro WhatsApp Business
3. Les conversations seront synchronisées

---

## 📱 Applications Mobiles

Gérez vos conversations depuis votre téléphone :

- **iOS** : [Télécharger sur l'App Store](https://apps.apple.com/app/tawk-to/id654558931)
- **Android** : [Télécharger sur Google Play](https://play.google.com/store/apps/details?id=com.tawk.android)

---

## 🆘 Alternatives Gratuites

Si Tawk.to ne convient pas, voici d'autres options :

### 1. **Tidio** 
- Site : [https://www.tidio.com](https://www.tidio.com)
- Plan gratuit : 100 conversations/mois
- Avantages : Design moderne, chatbots simples

### 2. **Crisp**
- Site : [https://crisp.chat](https://crisp.chat)
- Plan gratuit : 2 agents
- Avantages : Interface élégante, co-browsing

### 3. **Facebook Messenger**
- Site : [https://developers.facebook.com/docs/messenger-platform/](https://developers.facebook.com/docs/messenger-platform/)
- Complètement gratuit
- Avantages : Connexion directe avec votre page Facebook

### 4. **Chatwoot** (Open Source)
- Site : [https://www.chatwoot.com](https://www.chatwoot.com)
- Auto-hébergé et gratuit
- Avantages : Contrôle total, personnalisation illimitée

---

## 🛠️ Dépannage

### Le chat ne s'affiche pas ?

1. Vérifiez que `TAWK_ENABLED` est `true` dans `config/chat-config.php`
2. Vérifiez que le `TAWK_WIDGET_ID` est correct
3. Videz le cache de votre navigateur (Ctrl + F5)
4. Vérifiez la console du navigateur (F12) pour les erreurs

### Le chat s'affiche mais ne fonctionne pas ?

1. Vérifiez que vous êtes connecté au dashboard Tawk.to
2. Vérifiez votre statut (doit être "Online" / "En ligne")
3. Testez depuis un autre navigateur ou en mode navigation privée

### Désactiver temporairement le chat

Éditez `config/chat-config.php` :
```php
define('TAWK_ENABLED', false); // Désactiver le chat
```

---

## 📊 Statistiques et Rapports

1. Dashboard > **Reports**
2. Visualisez :
   - Nombre de conversations
   - Temps de réponse moyen
   - Satisfaction client
   - Visiteurs en temps réel

---

## 💡 Conseils d'Utilisation

1. **Répondez rapidement** : Les visiteurs attendent une réponse rapide
2. **Utilisez des messages pré-enregistrés** : Pour les questions fréquentes
3. **Soyez disponible** : Définissez des horaires clairs
4. **Suivez vos statistiques** : Améliorez continuellement votre service
5. **Formez votre équipe** : Assurez-vous que tous les agents sont bien formés

---

## 📞 Support

- **Documentation Tawk.to** : [https://help.tawk.to](https://help.tawk.to)
- **Email Support** : support@tawk.to
- **Chat Support** : Disponible dans le dashboard

---

## ✨ Installation Terminée !

Une fois configuré, le widget de chat apparaîtra en bas à droite de toutes les pages de votre site web. Vos visiteurs pourront vous contacter instantanément !

**Bonne chance avec votre nouveau système de chat ! 🎉**

