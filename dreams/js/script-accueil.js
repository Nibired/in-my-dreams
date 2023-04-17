/*Slider presentation accueil*/ 

const slides = document.querySelectorAll('.accueil-presentation-slide');

for (const slide of slides) {
  slide.addEventListener('click', () => {
    clearActiveClasses();
    slide.classList.add('accueil-presentation-active');
    console.log('hello');
  });
}

function clearActiveClasses() {
  slides.forEach((slide) => {
    slide.classList.remove('accueil-presentation-active');
  });
}






/* Slider derniers membres inscrits */


document.addEventListener("DOMContentLoaded", function() {
  // setTimeout pour retarder l'initialisation du slider
  setTimeout(function() {
    const containerLastMembers = document.querySelector('.container-last-members');
    const cardSliderMembers = document.querySelector('.card-slider-members');
    const previousButton = document.querySelector('#previous');
    const nextButton = document.querySelector('#next');
    const scrollStep = 270; // valeur pour ajuster la distance de défilement
    let currentIndex = 0;

    function scrollTo(direction) {
      if (direction === 'right') {
        currentIndex += 1;
      } else if (direction === 'left') {
        currentIndex -= 1;
      }

      if (currentIndex < 0) {
        currentIndex = 0;
      }

      const cardsDisplayed = 4; // le nombre de cartes affichées à la fois
      const maxIndex = Math.floor((cardSliderMembers.childElementCount - cardsDisplayed) / cardsDisplayed);
      if (currentIndex > maxIndex) {
        currentIndex = maxIndex;
      }

      cardSliderMembers.style.transform = `translateX(-${currentIndex * scrollStep}px)`;
    }

    previousButton.addEventListener('click', function() {
      scrollTo('left');
    });

    nextButton.addEventListener('click', function() {
      scrollTo('right');
    });
  }, 1000); // 1s
});






/****************Temoignages***************/

document.addEventListener("DOMContentLoaded", function () {
  const temoignageForm = document.getElementById("temoignage-form");
  const temoignagesList = document.getElementById("temoignages-list");

  function addTemoignageToList(temoignageData) {
    const temoignageItem = document.createElement('div');
    temoignageItem.classList.add('temoignage');

    temoignageItem.innerHTML = `
      <img src="dreams/img/circuitLove.jpg" alt="Témoignage">
      <div class="temoignage-text">
      <h3>${temoignageData.pseudo || 'Anonyme'}</h3>
        <p>${temoignageData.libelle_temoignage}</p>
        <small>${temoignageData.date_temoignage}</small>
      </div>
    `;

    temoignagesList.prepend(temoignageItem);
  }

  temoignageForm.addEventListener("submit", function (event) {
    event.preventDefault();
  
    const formData = new FormData(temoignageForm);
  
    fetch('http://localhost/inmydreams/dreams/controllers/temoignageController.php', {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Erreur réseau');
      }
      return response.json();
    })
    .then(data => {
      console.log('Réponse en JSON:', data);
      if (data.success) {
        // Ajoute le nouveau témoignage à la liste
        addTemoignageToList(data.temoignageData);
      } else {
        console.error('Erreur côté serveur:', data.error);
      }
    })
    .catch(error => {
      console.error('Erreur réseau:', error);
    });
  });
});




function addTemoignageToList(temoignageData) {
  const temoignageItem = document.createElement('div');
  temoignageItem.classList.add('temoignage');

  temoignageItem.innerHTML = `
    <img src="dreams/img/circuitLove.jpg" alt="Témoignage">
    <div class="temoignage-text">
      <h3>${temoignageData.pseudo}</h3>
      <p>${temoignageData.libelle_temoignage}</p>
      <small>${temoignageData.date_temoignage}</small>
    </div>
  `;

  temoignagesList.prepend(temoignageItem);
}


/*********fleche remonter fil page***********/

const backToTopButton = document.getElementById("back-to-top");

window.addEventListener("scroll", () => {
  if (window.pageYOffset > 100) {
    backToTopButton.style.display = "block";
  } else {
    backToTopButton.style.display = "none";
  }
});

backToTopButton.addEventListener("click", () => {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
});