const { Builder, By, until } = require('selenium-webdriver');

// Test für das Löschen eines Galerie-Bildes im Admin-Bereich
async function adminGalleryDeleteTest() {
    // Chrome-Browser starten
    const driver = await new Builder().forBrowser('chrome').build();

    try {
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

        // Warten, bis Admin-Seite geladen ist
        await driver.wait(until.urlContains('/admin'), 10000);

        // Warten, bis Galerie-Bereich sichtbar ist
        await driver.wait(
            until.elementLocated(By.xpath("//*[contains(text(), 'Galerie verwalten')]")),
            10000
        );

        // Prüfen, ob das Selenium-Testbild vorhanden ist
        const bodyTextBefore = await driver.findElement(By.css('body')).getText();

        if (!bodyTextBefore.includes('Selenium Test Galerie Bild')) {
            throw new Error('Kein Selenium-Testbild zum Löschen gefunden');
        }

        // Alle Galerie-Elemente holen
        const galleryItems = await driver.findElements(By.css('.admin-gallery-item'));

        let deleted = false;

        // Passendes Galerie-Element suchen und löschen
        for (const item of galleryItems) {
            const itemText = await item.getText();

            if (itemText.includes('Selenium Test Galerie Bild')) {
                const deleteButton = await item.findElement(
                    By.xpath(".//button[contains(text(), 'Löschen')]")
                );

                await deleteButton.click();
                deleted = true;
                break;
            }
        }

        if (!deleted) {
            throw new Error('Löschen-Button für Selenium-Testbild wurde nicht gefunden');
        }

        // Warten, bis Erfolgsmeldung erscheint
        await driver.wait(
            until.elementLocated(By.xpath("//*[contains(text(), 'Galerie-Bild wurde erfolgreich gelöscht')]")),
            10000
        );

        console.log('Admin gallery delete test passed');
    } catch (error) {
        console.error('Admin gallery delete test failed');
        console.error(error);
    } finally {
        // Browser schließen
        await driver.quit();
    }
}

// Test starten
adminGalleryDeleteTest();