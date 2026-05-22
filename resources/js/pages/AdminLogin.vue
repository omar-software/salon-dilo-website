<template>
    <!-- Admin-Login-Seite -->
    <div class="admin-page">
        <section class="admin">
            <h1>Admin Login</h1>

            <!-- Login-Formular -->
            <form @submit.prevent="loginAdmin">
                <!-- E-Mail-Adresse für den Admin-Login -->
                <input
                    type="email"
                    v-model="adminEmail"
                    placeholder="E-Mail eingeben"
                    class="login-input"
                    required
                >

                <!-- Passwort für den Admin-Login -->
                <input
                    type="password"
                    v-model="adminPassword"
                    placeholder="Passwort eingeben"
                    class="login-input"
                    required
                >

                <button type="submit">Einloggen</button>
            </form>

            <!-- Meldung bei Fehler oder Erfolg -->
            <p v-if="loginMessage" class="admin-message">{{ loginMessage }}</p>

            <a href="/" class="back-link">Zurück zur Webseite</a>
        </section>
    </div>
</template>

<script>
// Vue-Seite für den Admin-Login
export default {
    name: 'AdminLogin',

    data() {
        return {
            // Login-Daten für den Admin
            adminEmail: '',
            adminPassword: '',
            loginMessage: '',
        };
    },

    methods: {
        // Admin-Login an Laravel senden
        loginAdmin() {
            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content');

            fetch('/admin-login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    email: this.adminEmail,
                    password: this.adminPassword,
                }),
            })
                .then(async (response) => {
                    const data = await response.json();

                    if (!response.ok) {
                        this.loginMessage = data.message;
                        return;
                    }

                    this.loginMessage = data.message;
                    window.location.href = '/admin';
                })
                .catch((error) => {
                    console.error('Fehler beim Login:', error);
                    this.loginMessage = 'Fehler beim Login.';
                });
        },
    },
};
</script>