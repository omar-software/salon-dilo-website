const { Builder, By, until } = require('selenium-webdriver');

// Admin-Login-Test für das Laravel-Vue-Projekt
async function adminLoginTest() {
    // Chrome-Browser starten
    const driver = await new Builder().forBrowser('chrome').build();

    try {
        // Admin-Login-Seite öffnen
        await driver.get('http://127.0.0.1:8000/admin-login');

        // Warten, bis das E-Mail-Feld sichtbar ist
        const emailInput = await driver.wait(
            until.elementLocated(By.css('input[type="email"]')),
            10000
        );
        await emailInput.sendKeys('admin@salondilo.com');

        // Passwort-Feld finden und ausfüllen
        const passwordInput = await driver.findElement(By.css('input[type="password"]'));
        await passwordInput.sendKeys('123456');

        // Login-Button finden und klicken
        const loginButton = await driver.findElement(By.css('button[type="submit"]'));
        await loginButton.click();

        // Kurz warten, damit Redirect und Vue-Rendering fertig werden
        await driver.sleep(2000);

        // Aktuelle URL ausgeben
        const currentUrl = await driver.getCurrentUrl();
        console.log('Current URL:', currentUrl);

        // Body-Text ausgeben, damit wir sehen, was wirklich angezeigt wird
        const bodyText = await driver.findElement(By.css('body')).getText();
        console.log('Page text:', bodyText);

        // Prüfen, ob die URL auf /admin gewechselt hat
        if (!currentUrl.includes('/admin')) {
            throw new Error('Login redirect to /admin did not happen');
        }

        // Prüfen, ob Admin-Seite sichtbar ist
        if (bodyText.includes('Header-Bild ändern')) {
            console.log('Admin login test passed');
        } else {
            throw new Error('Admin page content was not found');
        }
    } catch (error) {
        console.error('Admin login test failed');
        console.error(error);
    } finally {
        // Browser schließen
        await driver.quit();
    }
}

// Test starten
adminLoginTest();