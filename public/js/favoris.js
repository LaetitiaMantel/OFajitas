document.addEventListener('DOMContentLoaded', function () {
    // Attendez que le document soit prêt
    createFavoris();
});

async function createFavoris() {
    // Sélectionnez tous les boutons "Ajouter aux favoris"
    const addToFavoritesButtons = document.querySelectorAll('#btn');

    // Récupérez les favoris depuis le stockage local
    const favoris = JSON.parse(localStorage.getItem('favoris')) || {};

    // Parcourez tous les boutons et mettez à jour leur classe en fonction des favoris
    addToFavoritesButtons.forEach(button => {
        const productId = button.getAttribute('data-product-id');
        const icon = button.querySelector('.icon');
        const isFavorited = favoris[productId];

        // Si le produit est en favori, ajoutez la classe 'icon-plus' à l'icône
        if (isFavorited) {
            icon.classList.add('icon-plus');
        }
    });

    // Ajoutez un écouteur d'événements à chaque bouton
    addToFavoritesButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            // Empêchez le comportement par défaut du navigateur (rechargement de la page)
            event.preventDefault();

            // Récupérez l'ID du produit à partir de l'attribut data-product-id
            const productId = button.getAttribute('data-product-id');

            // Récupérez l'icône spécifique associée à ce bouton
            const icon = button.querySelector('.icon');

            // Vérifiez si le produit est déjà en favori ou non
            const isFavorited = icon.classList.contains('icon-plus');

            // Appelez la fonction addFavoris ou deleteFavoris en fonction de l'état actuel du produit
            if (isFavorited) {
                deleteFavoris(productId);
                // Mettez à jour le stockage local pour refléter les changements
                favoris[productId] = false;
                localStorage.setItem('favoris', JSON.stringify(favoris));
            } else {
                addFavoris(productId);
                // Mettez à jour le stockage local pour refléter les changements
                favoris[productId] = true;
                localStorage.setItem('favoris', JSON.stringify(favoris));
            }

            // Modifiez la classe de l'icône spécifique associée à ce bouton
            icon.classList.toggle('icon-plus');
        });
    });
        async function addFavoris(productId) {
        try {
            const response = await fetch(addToFavoriteUrl.replace(1, productId), {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ productId: productId }),
            });

            if (response.ok) {
                const favoris = await response.json();
                console.log("Favoris ajouté avec succès :", favoris);
                // Vous pouvez mettre à jour l'interface utilisateur pour refléter les changements, si nécessaire
            } else {
                console.error("Échec de l'ajout du favoris :", response.statusText);
            }
        } catch (error) {
            console.error("Erreur lors de l'ajout du favoris :", error);
        }
    }

    async function deleteFavoris(productId) {
        try {
            const response = await fetch(deleteFavoriteUrl.replace(1, productId), {
                method: "DELETE",
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ productId: productId }),
            });

            if (response.ok) {
                const favoris = await response.json();
                console.log("Favoris supprimé avec succès :", favoris);
                // Mettez à jour l'interface utilisateur pour refléter les changements, si nécessaire
            } else {
                console.error("Échec de la suppression du favoris :", response.statusText);
            }
        } catch (error) {
            console.error("Erreur lors de la suppression du favoris :", error);
        }
    }
}


