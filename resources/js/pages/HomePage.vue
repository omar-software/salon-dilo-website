<template>
    <!-- Öffentliche Webseite -->
    <div class="wrapper">
        <!-- Header-Bereich mit Hintergrundbild -->
        <header class="header" :style="{ backgroundImage: `url(${headerImage})` }">
            <div class="hero-overlay">
                <!-- Header bleibt leer, damit nur das Logo-Bild angezeigt wird -->
            </div>
        </header>

        <!-- Hauptnavigation -->
        <nav class="navbar" aria-label="Hauptnavigation">
            <ul>
                <li><a href="#services">Dienstleistungen</a></li>
                <li><a href="#about">Über uns</a></li>
                <li><a href="#gallery">Galerie</a></li>
                <li><a href="#contact">Kontakt</a></li>
            </ul>
        </nav>

        <!-- Hauptinhalt -->
        <main class="homepage">
            <section class="welcome">
                <h2>Willkommen bei Salon Dilo</h2>
                <p>
                    Wir bieten Ihnen ein unvergessliches Rasur- und Pflegeerlebnis
                    in einer komfortablen und modernen Atmosphäre.
                </p>
            </section>

            <section id="services" class="services">
                <h2>Unsere Dienstleistungen</h2>
                <ul>
                    <li>Moderne Haarschnitte</li>
                    <li>Styling nach Wunsch</li>
                    <li>Pflege für Haut und Bart</li>
                    <li>Produkte für Haar- und Hautpflege</li>
                </ul>
            </section>

            <section id="about" class="about">
                <h2>Über uns</h2>
                <p>
                    Salon Dilo ist ein moderner Friseursalon, der hochwertige
                    Dienstleistungen für Haar- und Hautpflege anbietet.
                    Unser spezialisiertes Team sorgt dafür, dass jeder Besuch
                    zu einem angenehmen und professionellen Erlebnis wird.
                </p>
            </section>

            <section id="gallery" class="gallery">
                <h2>Galerie</h2>
                <p>Schauen Sie sich einige unserer Arbeiten an:</p>

                <div class="gallery-images">
                    <img
                        v-for="image in galleryImages"
                        :key="image.id"
                        :src="'/images/' + image.image_name"
                        :alt="image.alt_text || 'Galerie-Bild von Salon Dilo'"
>
                </div>
            </section>

            <section id="contact" class="contact">
                <h2>Kontakt</h2>
                <p>Für Reservierungen oder Anfragen kontaktieren Sie uns bitte über:</p>

                <ul>
                    <li>Telefon: <a href="tel:+4951120300647">051120300647</a></li>
                    <li>E-Mail: <a href="mailto:info@salondilo.com">info@salondilo.com</a></li>
                    <li>Adresse: Alfred-Bentz-Straße 1, 30966 Hemmingen</li>
                </ul>

                <div class="social-media">
                    <a
                        href="https://www.instagram.com/salon.dilo/"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="Instagram von Salon Dilo"
                    >
                        <img :src="instagramLogo" alt="Instagram" class="social-logo">
                    </a>

                    <a
                        href="https://wa.me/4951120300647"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="WhatsApp von Salon Dilo"
                    >
                        <img :src="whatsappLogo" alt="WhatsApp" class="social-logo">
                    </a>
                </div>
            </section>
        </main>

        <footer>
            <p>Copyright &copy; 2026 Salon Dilo. All rights reserved.</p>
        </footer>
    </div>
</template>

<script>
// Vue-Seite für die öffentliche Webseite
export default {
    name: 'HomePage',

    data() {
        return {
            // Standardbild, falls die API nicht erreichbar ist
            headerImage: '/images/header.img.png',

            // Bilder aus dem public/images Ordner
                
            instagramLogo: '/images/instagram-logo.png',
            whatsappLogo: '/images/whatsapp-logo.png',

            // Bilder der Galerie aus der Datenbank
            galleryImages: [],
        };
    },

    mounted() {
        // Einstellungen vom Laravel-Backend laden
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

            // Galerie-Bilder vom Laravel-Backend laden
            fetch('/api/gallery')
                .then((response) => response.json())
                .then((data) => {
                    this.galleryImages = data;
                })
                .catch((error) => {
                    console.error('Fehler beim Laden der Galerie:', error);
                });
    },
};
</script>