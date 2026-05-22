const { Builder, By, until } = require('selenium-webdriver');

// Test für Admin-Login und Logout
async function adminLogoutTest() {
    // Chrome-Browser starten
    const driver = await new Builder().forBrowser('chrome').build();

    try {
        // Admin-Login-Seite öffnen
        await driver.get('http://127.0.0.1:8000/admin-login');

        // Login-Daten eingeben
        const emailInput = await driver.wait(
            until.elementLocated(By.css('input[type="email"]')),
            10000
        );
        await emailInput.sendKeys('admin@salondilo.com');

        const passwordInput = await driver.findElement(By.css('input[type="password"]'));
        await passwordInput.sendKeys('123456');

        // Login ausführen
        const loginButton = await driver.findElement(By.css('button[type="submit"]'));
        await loginButton.click();

        // Warten, bis Admin-Seite geladen ist
        await driver.wait(until.urlContains('/admin'), 10000);

        // Logout-Button klicken
        const logoutButton = await driver.wait(
            until.elementLocated(By.xpath("//button[contains(text(), 'Ausloggen')]")),
            10000
        );
        await logoutButton.click();

        // Warten, bis Login-Seite wieder geladen ist
        await driver.wait(until.urlContains('/admin-login'), 10000);

        const currentUrl = await driver.getCurrentUrl();

        if (!currentUrl.includes('/admin-login')) {
            throw new Error('Logout hat nicht zur Login-Seite geführt');
        }

        console.log('Admin logout test passed');
    } catch (error) {
        console.error('Admin logout test failed');
        console.error(error);
    } finally {
        // Browser schließen
        await driver.quit();
    }
}

// Test starten
adminLogoutTest();