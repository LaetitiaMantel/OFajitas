document.addEventListener('DOMContentLoaded', function () {
    // Attendre que le document soit prêt
    iconUserColor();
});

async function iconUserColor() {
    console.log('connecter.js chargé');
    
    // Sélectionnez l'icône utilisateur dans le menu
    const iconUser = document.querySelector('.bi-person-circle');

    try {
        const response = await fetch(connecterUrl);

        if (response.ok) {
            const data = await response.json();

            // Mettre à jour l'interface utilisateur pour refléter les changements 
            if (data['info'] === 'false') {
                iconUser.classList.remove('h2-color');
            } else {
                iconUser.classList.add('h2-color');
            }
        } else {
            console.error("Échec de la requête :", response.statusText);
        }
    } catch (error) {
        console.error("Erreur :", error);
    }
}