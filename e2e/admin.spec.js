// @ts-check
const { test, expect } = require('@playwright/test');

test('admin login to create article', async ({ page }) => {
  await page.goto('http://localhost:8000/');
  await page.locator('div').filter({ hasText: 'QUI SOMMES-NOUSSERVICESBLOGCONTACT' }).locator('#link-login').click();
  await page.getByPlaceholder('E-mail').click();
  await page.getByPlaceholder('E-mail').fill('admin12345@');
  await page.getByPlaceholder('E-mail').click();
  await page.getByPlaceholder('E-mail').fill('admin1@admin1.fr');
  await page.getByPlaceholder('E-mail').press('Tab');
  await page.getByPlaceholder('Mot de passe').fill('Admin12345&!');
  await page.getByRole('button', { name: 'Se connecter' }).click();
  await page.getByRole('link', { name: 'Icône admin' }).click();
  await page.getByRole('link', { name: '+ C.R.U.D. ' }).click();
  await page.getByRole('link', { name: ' Articles' }).click();
  await page.getByRole('link', { name: 'Créer Articles' }).click();
});