try:
    from os import system
    import random,time, datetime, os, selenium, sys,traceback, string
    from selenium import webdriver
    from selenium.webdriver.common.keys import Keys
    from selenium.webdriver.common.by import By
    from selenium.webdriver.support.ui import WebDriverWait
    from selenium.webdriver.chrome.options import Options
    from selenium.webdriver.support import expected_conditions as EC
    from selenium.webdriver.common.desired_capabilities import DesiredCapabilities
    from colorama import *
    from selenium.webdriver.common.action_chains import ActionChains
except ModuleNotFoundError as e:
    print("Erreur: "+str(e))
    system("python -m pip install -r requirements.txt")
    print("Les dépendances ont été installées, merci de relance le programme")



def generate_password():
    # Création d'une liste de caractères
    chars = list(string.ascii_letters + string.digits + string.punctuation)
    # enlever les caractères spéciaux qui peuvent poser problème
    chars.remove('"')
    chars.remove("'")
    chars.remove("\\")
    chars.remove("/")
    chars.remove("`")
    password = []
    for i in range(0, random.randint(8, 18)):
        password.append(random.choice(chars))
    return "".join(password)