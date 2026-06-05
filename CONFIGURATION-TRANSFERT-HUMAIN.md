# 🤖➡️👤 Configuration Transfert vers Humain - Tidio

## 🎯 Objectif

Configurer le chatbot IA pour qu'il transfère automatiquement vers un humain quand :
- Le visiteur demande explicitement à parler à une personne
- Le bot ne peut pas répondre à une question
- Le visiteur veut faire un don ou devenir bénévole

---

## ⚙️ Configuration dans Tidio

### 1. **Accéder au Dashboard Tidio**
```
1. Connectez-vous sur https://www.tidio.com/panel/
2. Allez dans votre chatbot
3. Cliquez sur "Settings" ou "Paramètres"
```

### 2. **Configurer les Mots-Clés de Transfert**

#### **Déclencheurs pour Transfert Humain :**
```
Mots-clés à ajouter :
- "parler à quelqu'un"
- "parler à une personne"
- "parler à un humain"
- "agent humain"
- "représentant"
- "responsable"
- "équipe"
- "contact direct"
- "pas de robot"
- "vraie personne"
```

#### **Réponse de Transfert :**
```
"Bien sûr ! Je vais vous mettre en contact avec un membre de notre équipe TMK Foundation.

📞 Contact direct :
• WhatsApp : +243 978 219 845
• Email : contact@tmkfoundation.org

Un membre de notre équipe vous répondra dans les plus brefs délais !

En attendant, vous pouvez aussi consulter notre page 'Réalisations' pour voir nos actions."

[Le bot peut aussi ouvrir automatiquement le chat avec un humain si configuré]
```

---

## 🔧 Configuration Avancée

### **Option 1 : Transfert Automatique (Recommandé)**

#### **Dans Tidio Dashboard :**
```
1. Chatbots > Votre bot > Settings
2. Allez dans "Live Chat Integration"
3. Activez "Transfer to human agent"
4. Configurez les conditions :

CONDITIONS DE TRANSFERT :
☐ Visiteur dit "parler à quelqu'un"
☐ Visiteur dit "agent humain"
☐ Visiteur dit "contact direct"
☐ Bot ne trouve pas de réponse appropriée
☐ Visiteur mentionne "don" ou "bénévolat"
```

#### **Message de Transfert :**
```
"Je vous transfère vers un membre de notre équipe TMK Foundation qui pourra mieux vous aider ! 

En attendant, voici nos coordonnées directes :
📱 WhatsApp : +243 978 219 845
📧 Email : contact@tmkfoundation.org

Un membre de l'équipe vous répondra dans quelques minutes !"
```

### **Option 2 : Redirection Intelligente**

#### **Questions qui déclenchent le transfert :**
```
Q: "Je veux faire un don important"
R: "Parfait ! Pour les dons importants, je vous mets en contact avec notre responsable financier. 
    📞 WhatsApp : +243 978 219 845
    📧 Email : dons@tmkfoundation.org
    Il vous donnera toutes les informations nécessaires !"

Q: "Je veux devenir bénévole"
R: "Excellente initiative ! Notre responsable bénévoles vous contactera.
    📞 WhatsApp : +243 978 219 845
    📧 Email : benevoles@tmkfoundation.org
    Il vous expliquera les opportunités disponibles !"

Q: "J'ai une question complexe"
R: "Je comprends ! Pour les questions complexes, un membre de notre équipe vous aidera mieux.
    📞 WhatsApp : +243 978 219 845
    📧 Email : contact@tmkfoundation.org"
```

---

## 📱 Configuration WhatsApp Direct

### **Intégration WhatsApp dans les Réponses :**

#### **Réponse Standard :**
```
"Pour parler directement à notre équipe :

📱 WhatsApp : +243 978 219 845
📧 Email : contact@tmkfoundation.org

Nous sommes disponibles :
• Lundi-Vendredi : 8h-17h
• Samedi : 9h-13h

Un membre de l'équipe vous répondra rapidement !"
```

#### **Réponse avec Lien WhatsApp :**
```
"Cliquez ici pour nous contacter directement sur WhatsApp :
https://wa.me/243978219845

Ou envoyez un email à : contact@tmkfoundation.org

Notre équipe vous répondra dans les plus brefs délais !"
```

---

## 🎨 Configuration des Scénarios

### **Scénario 1 : Demande Générale**
```
Déclencheur : "parler à quelqu'un", "agent", "humain"
Réponse : "Je vous mets en contact avec notre équipe ! 
          📞 WhatsApp : +243 978 219 845"
```

### **Scénario 2 : Question Spécifique**
```
Déclencheur : "don", "bénévolat", "partenariat"
Réponse : "Pour cette demande, notre responsable vous contactera directement.
          📞 WhatsApp : +243 978 219 845"
```

### **Scénario 3 : Urgence**
```
Déclencheur : "urgent", "immédiat", "rapide"
Réponse : "Pour une demande urgente, contactez-nous immédiatement :
          📞 WhatsApp : +243 978 219 845 (réponse rapide)
          📧 Email : contact@tmkfoundation.org"
```

---

## 🔄 Configuration du Workflow

### **Étape 1 : Détection**
```
Le bot détecte les mots-clés de transfert
```

### **Étape 2 : Réponse Automatique**
```
Le bot explique qu'il transfère vers un humain
```

### **Étape 3 : Fourniture des Coordonnées**
```
Le bot donne les coordonnées de contact direct
```

### **Étape 4 : Suivi (Optionnel)**
```
Le bot peut demander si le visiteur a d'autres questions
```

---

## 📊 Exemples de Conversations

### **Conversation Type 1 :**
```
Visiteur : "Je veux parler à quelqu'un de votre équipe"
Bot : "Bien sûr ! Je vous mets en contact avec un membre de notre équipe TMK Foundation.
      📞 WhatsApp : +243 978 219 845
      📧 Email : contact@tmkfoundation.org
      Un membre de l'équipe vous répondra rapidement !"
```

### **Conversation Type 2 :**
```
Visiteur : "Comment puis-je faire un don important ?"
Bot : "Pour les dons importants, notre responsable financier vous contactera directement.
      📞 WhatsApp : +243 978 219 845
      📧 Email : dons@tmkfoundation.org
      Il vous donnera toutes les informations nécessaires !"
```

### **Conversation Type 3 :**
```
Visiteur : "Je ne comprends pas votre réponse"
Bot : "Je comprends ! Un membre de notre équipe vous aidera mieux.
      📞 WhatsApp : +243 978 219 845
      📧 Email : contact@tmkfoundation.org
      Notre équipe vous répondra dans les plus brefs délais !"
```

---

## ⚙️ Configuration Technique dans Tidio

### **1. Accéder aux Paramètres**
```
Dashboard Tidio > Chatbots > Votre bot > Settings
```

### **2. Configurer les Triggers**
```
Triggers > Add Trigger
Name : "Transfer to Human"
Keywords : parler à quelqu'un, agent, humain, contact direct
Response : [Message de transfert]
```

### **3. Configurer l'Escalation**
```
Settings > Escalation Rules
Condition : Contains keywords "parler à quelqu'un"
Action : Show contact information + Open live chat
```

### **4. Configurer les Horaires**
```
Settings > Operating Hours
Monday-Friday : 8:00-17:00
Saturday : 9:00-13:00
Sunday : Closed

Message hors horaires :
"Notre équipe n'est pas disponible actuellement.
📞 WhatsApp : +243 978 219 845 (réponse rapide)
📧 Email : contact@tmkfoundation.org"
```

---

## 📱 Configuration Mobile

### **Notifications Push**
```
1. Dashboard > Settings > Notifications
2. Activez les notifications pour :
   - Nouvelles conversations
   - Demandes de transfert
   - Messages urgents
```

### **Application Mobile**
```
Téléchargez l'app Tidio pour :
- Recevoir les notifications
- Répondre aux transferts
- Gérer les conversations
```

---

## 🎯 Avantages de cette Configuration

### **Pour les Visiteurs :**
✅ Réponse immédiate du bot IA
✅ Transfert facile vers un humain
✅ Coordonnées directes fournies
✅ Pas d'attente frustrante

### **Pour TMK Foundation :**
✅ Bot gère les questions simples
✅ Équipe se concentre sur les demandes importantes
✅ Pas de perte de visiteurs
✅ Efficacité maximale

---

## 📋 Checklist de Configuration

```
☐ Mots-clés de transfert configurés
☐ Messages de transfert personnalisés
☐ Coordonnées WhatsApp/Email ajoutées
☐ Horaires de disponibilité définis
☐ Notifications activées
☐ Application mobile installée
☐ Test des transferts effectué
☐ Équipe formée aux transferts
```

---

## 🧪 Test de la Configuration

### **Test 1 : Demande de Transfert**
```
Tapez : "Je veux parler à quelqu'un"
Vérifiez : Le bot donne les coordonnées
```

### **Test 2 : Question Complexe**
```
Tapez : "Comment faire un don de 1000$ ?"
Vérifiez : Le bot transfère vers un humain
```

### **Test 3 : Hors Horaires**
```
Testez en dehors des heures d'ouverture
Vérifiez : Message approprié affiché
```

---

## 💡 Conseils d'Optimisation

### **1. Mots-Clés Variés**
```
Ajoutez plusieurs variantes :
- "parler à quelqu'un"
- "agent humain"
- "représentant"
- "contact direct"
- "vraie personne"
```

### **2. Réponses Personnalisées**
```
Adaptez selon le contexte :
- Don → Responsable financier
- Bénévolat → Responsable bénévoles
- Général → Équipe générale
```

### **3. Suivi des Transferts**
```
Dashboard > Reports
Analysez :
- Nombre de transferts
- Raisons des transferts
- Taux de conversion
```

---

## 🎉 Résultat Final

Avec cette configuration :

**Le bot IA répond automatiquement aux questions simples** 🤖
**ET transfère intelligemment vers un humain quand nécessaire** 👤

**Meilleur des deux mondes !** ✨

---

**Votre chatbot est maintenant intelligent ET humain ! 🚀**
