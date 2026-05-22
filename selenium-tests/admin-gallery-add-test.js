const { Builder, By, until } = require('selenium-webdriver');
const path = require('path');

// Test für das Hinzufügen eines Galerie-Bildes im Admin-Bereich
async function adminGalleryAddTest() {
    // Chrome-Browser starten
    const driver = await new Builder().forBrowser('chrome').build();

    try {
        // Pfad zu einem vorhandenen Testbild
        const imagePath = path.resolve(__dirname, '../public/images/image1.jpg.png');

        // Admin-Login-Seite öffnen
        await driver.get('http://127.0.0.1:8000/admin-login');

        // E-Mail-Feld ausfüllen
        const emailInput = await driver.wait(
            until.elementLocated(By.css('input[type="email"]')),
            10000
        );
        await emailInput.sendKeys('admin@salondilo.com');

        // Passwort-Feld ausfüllen
        const passwordInput = await driver.findElement(By.css('input[type="password"]'));
        await passwordInput.sendKeys('123456');

        // Login-Button klicken
        const loginButton = await driver.findElement(By.css('button[type="submit"]'));
        await loginButton.click();

        // Warten, bis die Admin-Seite geladen ist
        await driver.wait(until.urlContains('/admin'), 10000);

        // Warten, bis der Galerie-Bereich sichtbar ist
        await driver.wait(
            until.elementLocated(By.xpath("//*[contains(text(), 'Galerie verwalten')]")),
            10000
        );

        // Galerie-Datei-Input direkt im Galerie-Bereich finden
        const galleryFileInput = await driver.wait(
            until.elementLocated(By.css('.gallery-admin input[type="file"]')),
            10000
        );

        // Verstecktes Datei-Input sichtbar machen, damit Selenium es verwenden kann
        await driver.executeScript(
            "arguments[0].style.display = 'block'; arguments[0].style.visibility = 'visible';",
            galleryFileInput
        );

        // Testbild auswählen
        await galleryFileInput.sendKeys(imagePath);

        // Alternativtext eingeben
        const altInput = await driver.findElement(By.css('.gallery-admin input[type="text"]'));
        await altInput.clear();
        await altInput.sendKeys('Selenium Test Galerie Bild');

        // Button zum Hinzufügen klicken
        const addButton = await driver.findElement(
            By.xpath("//button[contains(text(), 'Galerie-Bild hinzufügen')]")
        );
        await addButton.click();

        // Warten, bis Erfolgsmeldung erscheint
        await driver.wait(
            until.elementLocated(By.xpath("//*[contains(text(), 'Galerie-Bild wurde erfolgreich hinzugefügt')]")),
            10000
        );

        // Prüfen, ob das neue Bild in der Liste erscheint
       // Warten, bis das neue Galerie-Bild in der Liste erscheint
        await driver.wait(async () => {
            const bodyText = await driver.findElement(By.css('body')).getText();
            return bodyText.includes('Selenium Test Galerie Bild');
        }, 10000);

        console.log('Admin gallery add test passed');
    } catch (error) {
        console.error('Admin gallery add test failed');
        console.error(error);
    } finally {
        // Browser schließen
        await driver.quit();
    }
}

// Test starten
adminGalleryAddTest();