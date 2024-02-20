document.addEventListener('DOMContentLoaded', function () {
    // Attendez que le document soit prêt
    createFavoris();
});

async function createFavoris() {
    // Sélectionnez tous les boutons "Ajouter aux favoris"
    const addToFavoritesButtons = document.querySelectorAll('#btn');

    // Sélectionnez tous les boutons "supprimer un favorie"
    const removeButtons = document.querySelectorAll('#remove');

    //Sélectionnez le bouton "Supprimer tout les favoris"
    const emptyButton = document.querySelector('#empty');

    //Sélectionnez le coeur du menu 
    const heartMenu = document.querySelector('#heart-menu');

    // Récupérez les favoris depuis le stockage local
    let favoris = JSON.parse(localStorage.getItem('favoris')) || {};



    // Parcourez tous les boutons et mettez à jour leur classe en fonction des favoris
    addToFavoritesButtons.forEach(button => {
        const productId = button.getAttribute('data-product-id');
        const icon = button.querySelector('.icon');
        const isFavorited = favoris[productId];
        //localStorage.getItem('favoris', JSON.stringify(favoris));

        // Si le produit est en favori, ajoutez la classe 'icon-plus' et 'bi-heart-fill' à l'icône
        if (isFavorited) {
            icon.classList.add('icon-plus');
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill');
            heartMenu.classList.add('icon-plus');
        }
        //console.log(isFavorited);


    });


    // Ajoutez un écouteur d'événements à chaque bouton
    removeButtons.forEach(button => {
        button.addEventListener('click', function (event) {

            event.preventDefault();

            // Récupérez l'ID du produit à partir de l'attribut data-product-id
            const productId = button.getAttribute('data-product-id');

            // Récupérez les favoris depuis le stockage de session
            let favoris = JSON.parse(localStorage.getItem('favoris')) || {};

            deleteFavoris(productId);

            // Mettez à jour les favoris en session
            favoris[productId] = false;
            localStorage.setItem('favoris', JSON.stringify(favoris));



        });
    });

    if (emptyButton) {

        emptyButton.addEventListener('click', function () {

            localStorage.removeItem('favoris');

        });
    }

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
                heartMenu.classList.add('icon-plus');
            }


            // Modifiez la classe de l'icône spécifique associée à ce bouton
            icon.classList.toggle('bi-heart-fill');
            icon.classList.toggle('bi-heart');
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
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ productId: productId }),

            });

            if (response.ok) {
                const favoris = await response.json();

                console.log("Favoris supprimé avec succès :", favoris);

                if (window.location.pathname === '/Apo/projet-o-fajitas/public/favoris/') {

                    // Mettez à jour l'interface utilisateur pour refléter les changements de la page favoris
                    const favorisElement = document.querySelector('#favori-' + productId);
                    favorisElement.parentNode.removeChild(favorisElement);

                    // Afficher un message de confirmation
                    const element = document.querySelector('#notification');
                    const notificationElement = document.createElement('p');
                    notificationElement.classList.add('notification');
                    notificationElement.textContent = "Le favori a été supprimé avec succès.";
                    element.appendChild(notificationElement);

                    // Supprimer la notification après quelques secondes
                    setTimeout(() => {
                        notificationElement.parentNode.removeChild(notificationElement);
                    }, 3000);

                }

            } else {
                console.error("Échec de la suppression du favoris :", response.statusText);
            }
        } catch (error) {
            console.error("Erreur lors de la suppression du favoris :", error);
        }

    }

}


