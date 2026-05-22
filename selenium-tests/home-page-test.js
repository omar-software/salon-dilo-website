const { Builder, By, until } = require('selenium-webdriver');

// Test für die öffentliche Startseite
async function homePageTest() {
    // Chrome-Browser starten
    const driver = await new Builder().forBrowser('chrome').build();

    try {
        // Startseite öffnen
        await driver.get('http://127.0.0.1:8000');

        // Warten, bis der Willkommen-Bereich geladen ist
        await driver.wait(
            until.elementLocated(By.xpath("//h2[contains(text(), 'Willkommen bei Salon Dilo')]")),
            10000
        );

        // Gesamten Seitentext lesen
        const bodyText = await driver.findElement(By.css('body')).getText();

        // Prüfen, ob wichtige Inhalte sichtbar sind
        if (!bodyText.includes('Willkommen bei Salon Dilo')) {
            throw new Error('Willkommen-Bereich wurde nicht gefunden');
        }

        if (!bodyText.includes('Unsere Dienstleistungen')) {
            throw new Error('Dienstleistungen-Bereich wurde nicht gefunden');
        }

        if (!bodyText.includes('Galerie')) {
            throw new Error('Galerie-Bereich wurde nicht gefunden');
        }

        if (!bodyText.includes('Kontakt')) {
            throw new Error('Kontakt-Bereich wurde nicht gefunden');
        }

        // Prüfen, ob mindestens ein Galerie-Bild vorhanden ist
        const galleryImages = await driver.findElements(By.css('.gallery-images img'));

        if (galleryImages.length < 1) {
            throw new Error('Keine Galerie-Bilder gefunden');
        }

        console.log('Home page test passed');
    } catch (error) {
        console.error('Home page test failed');
        console.error(error);
    } finally {
        // Browser schließen
        await driver.quit();
    }
}

// Test starten
homePageTest();