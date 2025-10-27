(function() {
  'use strict';

  // Elementos del DOM
  const lampara = document.querySelector('.lampara');
  const html = document.documentElement;

  // Nombre de la clave en localStorage
  const THEME_KEY = 'user-theme-preference';

  // Obtener la URL base del proyecto
  const BASE_URL = window.location.origin + window.location.pathname.split('/').slice(0, -1).join('/');
  
  // Crear objetos de audio para los sonidos
  const soundOn = new Audio(BASE_URL + '/sounds/lamp_on.mp3');
  const soundOff = new Audio(BASE_URL + '/sounds/lamp_off.mp3');

  /**
   * Obtiene el tema actual desde localStorage o usa 'light' por defecto
   */
  function getStoredTheme() {
    return localStorage.getItem(THEME_KEY) || 'light';
  }

  /**
   * Guarda el tema en localStorage
   */
  function setStoredTheme(theme) {
    localStorage.setItem(THEME_KEY, theme);
  }

  /**
   * Aplica el tema al documento
   */
  function applyTheme(theme) {
    html.setAttribute('data-theme', theme);
    updateFavicon(theme);
  }

  /**
   * Actualiza el favicon según el tema
   */
  function updateFavicon(theme) {
    // Buscar el link del favicon existente o crear uno nuevo
    let favicon = document.querySelector("link[rel*='icon']");
    
    if (!favicon) {
      favicon = document.createElement('link');
      favicon.rel = 'icon';
      favicon.type = 'image/png';
      document.head.appendChild(favicon);
    }
    
    // Cambiar el favicon según el tema
    if (theme === 'dark') {
      favicon.href = BASE_URL + '/img/logo_b.png';
    } else {
      favicon.href = BASE_URL + '/img/logo_SSombra.png';
    }
  }

  /**
   * Reproduce el sonido correspondiente al cambio de tema
   */
  function playSound(theme) {
    try {
      if (theme === 'dark') {
        // Cambió a tema oscuro (lámpara se enciende)
        soundOn.currentTime = 0;
        soundOn.play();
      } else {
        // Cambió a tema claro (lámpara se apaga)
        soundOff.currentTime = 0;
        soundOff.play();
      }
    } catch (error) {
      console.warn('No se pudo reproducir el sonido:', error);
    }
  }

  /**
   * Alterna entre tema claro y oscuro
   */
  function toggleTheme() {
    const currentTheme = html.getAttribute('data-theme') || 'light';
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    
    applyTheme(newTheme);
    setStoredTheme(newTheme);
    playSound(newTheme);
    
    console.log(`Tema cambiado a: ${newTheme}`);
  }

  /**
   * Inicializa el theme switcher
   */
  function init() {
    // Cargar tema guardado al inicio
    const storedTheme = getStoredTheme();
    applyTheme(storedTheme);

    // Hacer la lámpara clickeable
    if (lampara) {
      lampara.style.cursor = 'pointer';
      lampara.title = 'Cambiar tema';
      
      // Agregar evento de click
      lampara.addEventListener('click', toggleTheme);
      
      console.log('Theme Switcher inicializado con tema:', storedTheme);
    } else {
      console.warn('No se encontró el elemento .lampara para cambiar el tema');
    }
  }

  // Inicializar cuando el DOM esté listo
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
