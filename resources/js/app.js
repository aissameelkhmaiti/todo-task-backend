import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY, // ou process.env.MIX_PUSHER_APP_KEY
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true,
    authEndpoint: '/broadcasting/auth', // pour les chaînes privées
    auth: {
        headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`, // selon ton stockage JWT
        },
    },
});

// Exemple d’écoute sur la chaîne privée
window.Echo.private(`tasks.${userId}`)
    .listen('TaskCreated', (e) => {
        console.log('Nouvelle tâche créée:', e);
        alert(`Nouvelle tâche: ${e.title}`);
    });
