/******************Note categ reves***************************/


let id_utilisateur;

function insererNote(id_utilisateur, id_reve, note) {
  const formData = new FormData();
  formData.append('action', 'insererNote');
  formData.append('note', note);
  formData.append('id_utilisateur', id_utilisateur);
  formData.append('id_reve', id_reve);

  fetch('./dreams/controllers/categController.php?action=insererNote', {
    method: 'POST',
    body: formData
  }).then(response => {
    if (response.ok) {
      console.log('note:', note, 'id_utilisateur:', id_utilisateur, 'id_reve:', id_reve);
      console.log('Note insérée avec succès !');
    } else {
      console.error('Erreur lors de l\'insertion de la note.');
    }
  }).catch(error => {
    console.error('Erreur lors de l\'insertion de la note :', error);
  });
}

fetch('./dreams/controllers/categController.php?action=getIdUtilisateur')
  .then(response => response.json())
  .then(data => {
    if (data.error) {
      console.error('Erreur lors de la récupération de l\'ID utilisateur:', data.error);
      return;
    }

    id_utilisateur = parseInt(data['id_utilisateur']);
    
    const ratings = document.querySelectorAll('.rating');

    ratings.forEach(rating => {
      const stars = rating.querySelectorAll('.star');
      let currentRating = 0;
  
      stars.forEach(star => {
        star.addEventListener('click', () => {
          const clickedRating = parseInt(star.getAttribute('data-value'));
  
          for (let i = 0; i < stars.length; i++) {
            if (i < clickedRating) {
              stars[i].classList.add('selected');
            } else {
              stars[i].classList.remove('selected');
            }
          }
  
          if (currentRating !== clickedRating) {
            currentRating = clickedRating;
            const id_reve = parseInt(rating.dataset.id);
            const note = currentRating;
  
            insererNote(id_utilisateur, id_reve, note);
          }
        });
      });
    });


  })
  .catch(error => {
    console.error('Erreur lors de la récupération de l\'ID utilisateur :', error);
  });