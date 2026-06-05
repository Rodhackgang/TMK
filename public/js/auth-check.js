/**
 * Module de vérification d'authentification et de permissions
 * À inclure dans toutes les pages admin
 */

// Mapping des pages vers les permissions requises
const PAGE_PERMISSIONS = {
  '/admin': 'canManageNavigation',
  '/admin/content': 'canManageHomePage',
  '/admin/about': 'canManageAboutPage',
  '/admin/history': 'canManageHistoryPage',
  '/admin/team': 'canManageTeamPage',
  '/admin/contact': 'canManageContactPage',
  '/admin/juridical': 'canManageJuridicalPage',
  '/admin/users': 'canManageUsers'
};

// Obtenir le token d'authentification
function getAuthToken() {
  return localStorage.getItem('authToken');
}

// Obtenir l'utilisateur actuel
function getCurrentUser() {
  const userStr = localStorage.getItem('user');
  return userStr ? JSON.parse(userStr) : null;
}

// Vérifier si l'utilisateur a une permission
function hasPermission(permission) {
  const user = getCurrentUser();
  if (!user) return false;
  
  // Les admins ont toutes les permissions
  if (user.role === 'admin') return true;
  
  // Vérifier la permission spécifique
  return user.permissions && user.permissions[permission] === true;
}

// Vérifier l'accès à la page actuelle
function checkPageAccess() {
  const currentPath = window.location.pathname;
  const requiredPermission = PAGE_PERMISSIONS[currentPath];
  
  if (requiredPermission && !hasPermission(requiredPermission)) {
    return false;
  }
  
  return true;
}

// Appel API avec authentification
async function authFetch(url, options = {}) {
  const token = getAuthToken();
  
  if (!token) {
    window.location.href = '/admin/login';
    return null;
  }
  
  const defaultHeaders = {
    'Content-Type': 'application/json',
    'Authorization': `Bearer ${token}`
  };
  
  const response = await fetch(url, {
    ...options,
    headers: {
      ...defaultHeaders,
      ...options.headers
    }
  });
  
  if (response.status === 401) {
    localStorage.removeItem('authToken');
    localStorage.removeItem('user');
    window.location.href = '/admin/login';
    return null;
  }
  
  return response;
}

// Déconnexion
async function logout() {
  try {
    await authFetch('/api/auth/logout', { method: 'POST' });
  } catch (error) {
    console.error('Logout error:', error);
  }
  localStorage.removeItem('authToken');
  localStorage.removeItem('user');
  window.location.href = '/admin/login';
}

// Vérifier l'authentification au chargement de la page
async function checkAuth() {
  const token = getAuthToken();
  
  if (!token) {
    window.location.href = '/admin/login';
    return false;
  }
  
  try {
    const response = await fetch('/api/auth/me', {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
    
    if (!response.ok) {
      localStorage.removeItem('authToken');
      localStorage.removeItem('user');
      window.location.href = '/admin/login';
      return false;
    }
    
    const data = await response.json();
    localStorage.setItem('user', JSON.stringify(data.user));
    
    // Vérifier l'accès à la page
    if (!checkPageAccess()) {
      showAccessDenied();
      return false;
    }
    
    return data.user;
    
  } catch (error) {
    console.error('Auth check error:', error);
    localStorage.removeItem('authToken');
    localStorage.removeItem('user');
    window.location.href = '/admin/login';
    return false;
  }
}

// Afficher le message d'accès refusé
function showAccessDenied() {
  document.body.innerHTML = `
    <div style="
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: #0a0a0f;
      color: #fff;
      font-family: 'Inter', -apple-system, sans-serif;
      text-align: center;
      padding: 2rem;
    ">
      <i class="fas fa-lock" style="font-size: 4rem; color: #ef4444; margin-bottom: 1.5rem;"></i>
      <h1 style="font-size: 2rem; margin-bottom: 1rem;">Accès Refusé</h1>
      <p style="color: #8b8b9e; margin-bottom: 2rem; max-width: 400px;">
        Vous n'avez pas la permission d'accéder à cette page. 
        Contactez un administrateur si vous pensez qu'il s'agit d'une erreur.
      </p>
      <div style="display: flex; gap: 1rem;">
        <a href="/admin" style="
          padding: 0.75rem 1.5rem;
          background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
          color: white;
          text-decoration: none;
          border-radius: 10px;
          font-weight: 500;
        ">Retour au Dashboard</a>
        <button onclick="logout()" style="
          padding: 0.75rem 1.5rem;
          background: rgba(239, 68, 68, 0.1);
          color: #ef4444;
          border: 1px solid rgba(239, 68, 68, 0.3);
          border-radius: 10px;
          cursor: pointer;
          font-weight: 500;
        ">Se déconnecter</button>
      </div>
    </div>
  `;
}

// Mettre à jour l'interface utilisateur avec les infos de l'utilisateur
function updateUserUI(user) {
  const userNameEl = document.getElementById('currentUserName');
  const userRoleEl = document.getElementById('currentUserRole');
  const userAvatarEl = document.getElementById('currentUserAvatar');
  
  if (userNameEl) userNameEl.textContent = user.name;
  if (userRoleEl) userRoleEl.textContent = user.role === 'admin' ? 'Administrateur' : 'Gestionnaire';
  if (userAvatarEl) userAvatarEl.textContent = user.name.charAt(0).toUpperCase();
  
  // Masquer le lien utilisateurs si pas admin
  if (user.role !== 'admin') {
    const usersLink = document.querySelector('a[href="/admin/users"]');
    if (usersLink) usersLink.style.display = 'none';
  }
  
  // Masquer les liens vers les pages sans permission
  Object.entries(PAGE_PERMISSIONS).forEach(([path, permission]) => {
    if (!hasPermission(permission)) {
      const link = document.querySelector(`a[href="${path}"]`);
      if (link && path !== '/admin/users') {
        link.style.opacity = '0.5';
        link.style.pointerEvents = 'none';
        link.title = 'Vous n\'avez pas accès à cette page';
      }
    }
  });
}

// Export global
window.AuthCheck = {
  getAuthToken,
  getCurrentUser,
  hasPermission,
  checkPageAccess,
  authFetch,
  logout,
  checkAuth,
  updateUserUI
};
