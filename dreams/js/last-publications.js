document.addEventListener('DOMContentLoaded', function() {
    // Vérif si on est sur la page d'accueil
    if (document.querySelector('body main .last-publications')) {
      const dreamsElement = document.getElementById('dreams');
      const nightmaresElement = document.getElementById('nightmares');
  
      if (dreamsElement) {
        dreamsElement.addEventListener('click', function() {
          fadeOutEffect(document.body);
          setTimeout(() => {
            fetchLastPubli(1); // 1 pour les rêves
          }, 500);
        });
      } else {
        console.error("L'élément 'dreams' n'a pas été trouvé dans le DOM.");
      }
  
      if (nightmaresElement) {
        nightmaresElement.addEventListener('click', function() {
          fadeOutEffect(document.body);
          setTimeout(() => {
            fetchLastPubli(2); // 2 pour les cauchemars
          }, 500);
        });
      } else {
        console.error("L'élément 'nightmares' n'a pas été trouvé dans le DOM.");
      }
    }
  });
  
  function fetchLastPubli(id_famille_reve) {
    window.location.href = `last_publi.phtml?id_famille_reve=${id_famille_reve}`;
}
  
  function fadeOutEffect(element) {
    let opacity = 1;
    const timer = setInterval(function() {
      if (opacity <= 0.1) {
        clearInterval(timer);
        element.style.display = 'none';
      }
      element.style.opacity = opacity;
      element.style.filter = 'alpha(opacity=' + opacity * 100 + ')';
      opacity -= opacity * 0.1;
    }, 50);
  }