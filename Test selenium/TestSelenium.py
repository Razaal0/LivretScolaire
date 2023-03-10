from driver import *

class TestSelenium(driver):
    def __init__(self):
      super().__init__("http://localhost:3000/")

    def TestEnseignant(self):

      self.Connexion_site("test@test.fr", "root")

      # dérouler le menu Administration
      WebDriverWait(self.driver, 10).until(EC.element_to_be_clickable((By.ID, 'menu_administration'))).click()
      # Cliquez sur le bouton "Enseignant"
      WebDriverWait(self.driver, 10).until(EC.element_to_be_clickable((By.CSS_SELECTOR, 'a[href="/controller/C_prof.php"]'))).click()

      # vérifier que le "#titre" de la page est "Enseignant"
      self.driver.find_element(By.CSS_SELECTOR, '[class="pagetitle"] > h1').get_attribute("innerText") == "Enseignants"

      # ajouter un enseignant
      # ajouter le prénom
      self.driver.find_element(By.ID, 'prenom').send_keys("SeleniumTest_Prenom")
      # ajouter le nom
      self.driver.find_element(By.ID, 'nom').send_keys("SeleniumTest_Nom")
      # Cliquer sur le bouton "Ajouter"
      self.driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]').click()

      # vérifier que le message est "Enseignant ajouté"
      if self.comparer_titre_notif("Enseignant ajouté") == False:
         raise Exception("La notification d'ajoût d'enseignant n'a pas été trouvé")

      # vérifier que l'enseignant a été ajouté
      ligne = self.rechercher_donnee_tableau("SeleniumTest_Nom", "SeleniumTest_Nom", "SeleniumTest_Prenom")
      if ligne == False:
        raise Exception("L'enseignant n'a pas été trouvé dans le tableau")


      # modifier un enseignant
      # cliquer sur le bouton "Modifier"
      ligne.find_element(By.CSS_SELECTOR, 'a[href^="../Controller/C_modif.php?codeens="]').click()

      # modifier le prénom
      self.driver.find_element(By.ID, 'prenom').clear()
      self.driver.find_element(By.ID, 'prenom').send_keys("SeleniumTest_Prenom_Modifier")
      # modifier le nom
      self.driver.find_element(By.ID, 'nom').clear()
      self.driver.find_element(By.ID, 'nom').send_keys("SeleniumTest_Nom_Modifier")
      # Cliquer sur le bouton "Modifier"
      self.driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]').click()

      time.sleep(500)
      self.driver.quit()

test = TestSelenium()
test.TestEnseignant()