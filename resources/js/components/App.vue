<template>
    <!-- Öffentliche Webseite -->
    <HomePage v-if="currentPage !== '/admin' && currentPage !== '/admin-login'" />

    <!-- Admin-Login-Seite -->
    <AdminLogin v-if="currentPage === '/admin-login'" />

    <!-- Admin-Seite -->
    <AdminPage v-if="currentPage === '/admin'" />
</template>

<script>
import HomePage from '../pages/HomePage.vue';
import AdminLogin from '../pages/AdminLogin.vue';
import AdminPage from '../pages/AdminPage.vue';

// Hauptkomponente entscheidet, welche Seite angezeigt wird
export default {
    name: 'App',

    components: {
        HomePage,
        AdminLogin,
        AdminPage,
    },

    data() {
        return {
            // Aktuelle Seite anhand der URL erkennen
            currentPage: window.location.pathname,
        };
    },
};
</script>