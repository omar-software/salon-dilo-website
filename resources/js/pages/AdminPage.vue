<template>
    <!-- Admin-Seite -->
    <div class="admin-page">
        <section class="admin">
            <h1>Admin</h1>
            <h2>Header-Bild ändern</h2>

            <!-- Logout-Button für den Admin -->
            <button type="button" class="logout-button" @click="logoutAdmin">
                Ausloggen
            </button>

            <!-- Vorschau des aktuellen Header-Bildes -->
            <div class="current-header-preview">
                <p>Aktuelles Header-Bild:</p>
                <img :src="headerImage" alt="Aktuelles Header-Bild">
            </div>

            <!-- Formular zum Hochladen eines neuen Header-Bildes -->
            <form @submit.prevent="uploadHeaderImage">
                <label class="file-label">
                    Bild auswählen
                    <input type="file" accept="image/*" @change="handleHeaderImageChange">
                </label>

                <p v-if="selectedHeaderImage">
                    Ausgewählte Datei: {{ selectedHeaderImage.name }}
                </p>

                <button type="submit">Header-Bild speichern</button>
            </form>

            <p v-if="adminMessage" class="admin-message">{{ adminMessage }}</p>

            <!-- Admin-Bereich für Galerie-Bilder -->
<div class="gallery-admin">
    <h2>Galerie verwalten</h2>

    <!-- Formular zum Hochladen eines neuen Galerie-Bildes -->
    <form @submit.prevent="uploadGalleryImage">
        <label class="file-label">
            Galerie-Bild auswählen
            <input type="file" accept="image/*" @change="handleGalleryImageChange">
        </label>

        <p v-if="selectedGalleryImage">
            Ausgewählte Datei: {{ selectedGalleryImage.name }}
        </p>

        <input
            type="text"
            v-model="galleryAltText"
            placeholder="Alternativtext eingeben"
            class="login-input"
        >

        <button type="submit">Galerie-Bild hinzufügen</button>
    </form>

    <p v-if="galleryMessage" class="admin-message">{{ galleryMessage }}</p>

            <!-- Aktuelle Galerie-Bilder -->
            <div class="admin-gallery-list">
                <div
                    v-for="image in galleryImages"
                    :key="image.id"
                    class="admin-gallery-item"
                >
                    <img
                        :src="'/images/' + image.image_name"
                        :alt="image.alt_text || 'Galerie-Bild von Salon Dilo'"
                    >

                    <p>{{ image.alt_text }}</p>

                    <button type="button" @click="deleteGalleryImage(image.id)">
                        Löschen
                    </button>
                </div>
            </div>
        </div>

            <a href="/" class="back-link">Zurück zur Webseite</a>
        </section>
    </div>
</template>

<script>
// Vue-Seite für den Admin-Bereich
export default {
    name: 'AdminPage',

    data() {
        return {
            // Standardbild, falls die API nicht erreichbar ist
            headerImage: '/images/header.img.png',

            // Ausgewählte Datei für den Upload
            selectedHeaderImage: null,

            // Meldung für Erfolg oder Fehler
            adminMessage: '',

            // Galerie-Daten für den Admin-Bereich
            galleryImages: [],
            selectedGalleryImage: null,
            galleryAltText: '',
            galleryMessage: '',
        };
    },

    mounted() {
        // Aktuelle Einstellungen vom Laravel-Backend laden
        fetch('/api/settings')
            .then((response) => response.json())
            .then((data) => {
                // Header-Bild aus der Datenbank setzen
                if (data.header_image) {
                    this.headerImage = '/images/' + data.header_image;
                }
            })
            .catch((error) => {
                // Fehler in der Browser-Konsole anzeigen
                console.error('Fehler beim Laden der Einstellungen:', error);
            });

            // Galerie-Bilder laden
            this.loadGalleryImages();
    },

    methods: {
        // Ausgewählte Datei im Vue-State speichern
        handleHeaderImageChange(event) {
            this.selectedHeaderImage = event.target.files[0];
        },

        // Neues Header-Bild an Laravel senden
        uploadHeaderImage() {
            if (!this.selectedHeaderImage) {
                this.adminMessage = 'Bitte zuerst ein Bild auswählen.';
                return;
            }

            const formData = new FormData();
            formData.append('header_image', this.selectedHeaderImage);

            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content');

            fetch('/api/header-image', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    this.adminMessage = data.message;
                    this.headerImage = '/images/' + data.header_image;
                })
                .catch((error) => {
                    console.error('Fehler beim Hochladen:', error);
                    this.adminMessage = 'Fehler beim Hochladen des Bildes.';
                });
                
        },

        // Galerie-Bilder vom Laravel-Backend laden
loadGalleryImages() {
    fetch('/api/gallery')
        .then((response) => response.json())
        .then((data) => {
            this.galleryImages = data;
        })
        .catch((error) => {
            console.error('Fehler beim Laden der Galerie:', error);
        });
},

// Ausgewählte Galerie-Datei im Vue-State speichern
handleGalleryImageChange(event) {
    this.selectedGalleryImage = event.target.files[0];
},

// Neues Galerie-Bild hochladen
uploadGalleryImage() {
    if (!this.selectedGalleryImage) {
        this.galleryMessage = 'Bitte zuerst ein Galerie-Bild auswählen.';
        return;
    }

    const formData = new FormData();
    formData.append('gallery_image', this.selectedGalleryImage);
    formData.append('alt_text', this.galleryAltText);

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content');

    fetch('/api/gallery', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            this.galleryMessage = data.message;
            this.selectedGalleryImage = null;
            this.galleryAltText = '';
            this.loadGalleryImages();
        })
        .catch((error) => {
            console.error('Fehler beim Hochladen des Galerie-Bildes:', error);
            this.galleryMessage = 'Fehler beim Hochladen des Galerie-Bildes.';
        });
},

            // Galerie-Bild löschen
            deleteGalleryImage(id) {
                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content');

                fetch('/api/gallery/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        this.galleryMessage = data.message;
                        this.loadGalleryImages();
                    })
                    .catch((error) => {
                        console.error('Fehler beim Löschen des Galerie-Bildes:', error);
                        this.galleryMessage = 'Fehler beim Löschen des Galerie-Bildes.';
                    });
            },

        // Admin-Logout an Laravel senden
        logoutAdmin() {
            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content');

            fetch('/admin-logout', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            })
                .then(() => {
                    window.location.href = '/admin-login';
                })
                .catch((error) => {
                    console.error('Fehler beim Logout:', error);
                });
        },
    },
};
</script>