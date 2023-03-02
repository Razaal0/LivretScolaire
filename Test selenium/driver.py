from tools import *

class driver:
    def __init__(self, url):
      
      # Variables globales
      self.url = url

      options = webdriver.ChromeOptions()
      options.add_experimental_option('excludeSwitches', ['enable-logging'])
      # mettre en plein écran
      options.add_argument("--start-maximized")
      # instancier le driver
      self.driver = webdriver.Chrome("chromedriver.exe",chrome_options=options)
      self.driver.implicitly_wait(5)
      self.driver.set_page_load_timeout(5)
      self.driver.set_script_timeout(5)
      self.driver.get(url)


    def Connexion_site(self,email,password):
      """
      Méthode qui permet de se connecter au site
      :param email: l'email de l'utilisateur
      :param password: le mot de passe de l'utilisateur
      """
      try:
        #  Cliquez sur le bouton "Connexion"
        self.driver.find_element(By.CSS_SELECTOR, 'a[href="/view/pages-login.php"]').click()

        #  Remplir le champ "Email"
        self.driver.find_element(By.ID, 'email').send_keys(email)

        #  Remplir le champ "Mot de passe"
        self.driver.find_element(By.ID, 'password').send_keys(password)

        #  Cliquez sur le bouton "Connexion"
        self.driver.find_element(By.CSS_SELECTOR, 'button[type="submit"]').click()
        return True
      except Exception as e:
        stacktrace = traceback.format_exc()
        print("Erreur lors de l'inserion des données dans le formulaire de connexion" + stacktrace)
        self.driver.quit()
        return False

    

    def comparer_titre_notif(self, texte):
      """
      Méthode qui permet de comparer le titre de la notification avec le texte passé en paramètre
      :param texte: le texte à comparer
      :return: True si le titre de la notification est le même que le texte, False sinon
      """
      try:
        #récupérer le titre de la notification
        titre = self.driver.find_element(By.CSS_SELECTOR, '#toast > div > div > strong').get_attribute("innerText")
      except Exception as e:
        stacktrace = traceback.format_exc()
        print("Erreur il y a pas de notification : " + "Notificaiton recherché : " + texte)
        self.driver.quit()

      #vérifier que le titre de la notification est le même que le texte
      if titre == texte:
        return True
      return False
    

    def rechercher_donnee_tableau(self, texte, *kwargs):
      """
      Méthode qui permet de rechercher un texte dans le tableau et de vérifier que les données passées en paramètre sont bien dans le tableau
      :param texte: le texte à rechercher
      :param kwargs: mettre les données à comparer pour vérifier que le texte recherché est bien dans le tableau
      # exemple le tableau est comme suit
      # | Nom | Prénom | Email | Téléphone |
      # appel de la méthode : rechercher_donnee_tableau("test", "test_nom", "test_prenom", "test_email", "test_telephone")
      :return: True si le texte est trouvé, False sinon
      """
      try:
        # Faire la recherche dans le tableau
        self.driver.find_element(By.CSS_SELECTOR, '#DataTables_Table_0_filter input[type=search]').send_keys(texte)
        #récupérer le tableau
        tableau = self.driver.find_elements(By.CSS_SELECTOR, '#DataTables_Table_0 > tbody tr')

        #vérifier que le tableau n'est pas vide
        if len(tableau) > 0:
          # vérifier que le texte recherché est dans le tableau
          for ligne in tableau:
            #récupérer les données de la ligne
            donnees = ligne.find_elements(By.CSS_SELECTOR, 'td')
            # parcourir les données moins le bouton supprimer et modifier
            compteur = 0
            for i in range(len(donnees) - 2):
              #vérifier que la donnée est la même que celle passée en paramètre
              if str(donnees[i].get_attribute("innerText")) == str(kwargs[i]):
                compteur += 1 

            #vérifier que toutes les données sont les mêmes
            if compteur == len(donnees) - 2:
              return True

          return False
        else:
          return False
      except Exception as e:
        stacktrace = traceback.format_exc()
        print("Erreur lors de la recherche du texte dans le tableau : " + stacktrace)
        self.driver.quit()
        return False
