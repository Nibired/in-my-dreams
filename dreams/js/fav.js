async function addFavoriteHeartListener(favoriteHeart) {
  if (favoriteHeart.hasAttribute('data-id_utilisateur_suivre') && favoriteHeart.getAttribute('data-id_utilisateur_suivre').trim() !== '') {
    const userId = parseInt(favoriteHeart.getAttribute('data-id_utilisateur_suivre'));
    if (!isNaN(userId)) {
      favoriteHeart.style.cursor = "pointer";
      favoriteHeart.addEventListener('click', async () => {
        const response = await fetch(`../dreams/controllers/userDashboardController.php?action=add-favorite&id_utilisateur_suivre=${userId}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `id_utilisateur_suivre=${userId}`
        });
        const result = await response.text();
        if (result.trim() === "Favori ajouté") {
          favoriteHeart.classList.add("heart-active");
          const favList = document.querySelector('table:nth-child(5) tbody');
          const newRow = document.createElement('tr');
          const newCell = document.createElement('td');
          newCell.textContent = favoriteHeart.closest('tr').querySelector('td:first-child').textContent;
          newRow.appendChild(newCell);
          favList.appendChild(newRow);
        } else {
          favoriteHeart.classList.remove("heart-active");
        }
      });
    } else {
      console.error("Erreur: ID utilisateur favori non récupéré");
    }
  } else {
    console.error("Erreur: ID utilisateur favori non récupéré");
  }
}

function initFavoriteHearts() {
  document.querySelectorAll(".favorite-heart").forEach((favoriteHeart) => {
    addFavoriteHeartListener(favoriteHeart);
  });
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initFavoriteHearts);
} else {
  initFavoriteHearts();
}