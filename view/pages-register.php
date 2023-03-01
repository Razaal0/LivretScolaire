<?php
require_once('includes/header.php');
require_once('includes/nav.php');
require_once('includes/user-session.php');

if (UserConnected()) {
  header('Location: ../view/');
  add_notif_modal('danger', 'Erreur', 'Vous êtes déjà connecté.');
  exit();
}
?>
<main id="main" class="main">
  <div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
              <a href="index.html" class="logo d-flex align-items-center w-auto">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">Livret Scolaire </span>
              </a>
            </div><!-- End Logo -->

            <div class="card mb-3">

              <div class="card-body">

                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Créer un compte</h5>
                  <p class="text-center small">Entrez vos données personnelles pour créer un compte</p>
                </div>

                <form class="row g-3 needs-validation" action="/controller/C_register.php"  method="POST" novalidate>

                  <div class="col-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                    <div class="invalid-feedback">Veuillez saisir une adresse email valide !</div>
                  </div>

                  <div class="col-12">
                    <label for="prenom" class="form-label">Prénom</label>
                    <div class="input-group has-validation">
                      <input type="text" name="prenom" class="form-control" id="prenom" required>
                      <div class="invalid-feedback">Veuillez choisir un prénom</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="nom" class="form-label">Nom</label>
                    <div class="input-group has-validation">
                      <input type="text" name="nom" class="form-control" id="nom" required>
                      <div class="invalid-feedback">Veuillez choisir un nom</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="yourPassword" class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" id="yourPassword" required>
                    <div class="invalid-feedback">Veuillez entrer votre mot de passe.</div>
                  </div>

                  <div class="col-12">
                    <div class="form-check">
                      <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                      <label class="form-check-label" for="acceptTerms">Je suis d'accord et j'accepte les <a href="#">conditions générales conditions</a></label>
                      <div class="invalid-feedback">Vous devez accepter les conditions d'utilisation de la plateforme pour pouvoir vous inscrire.</div>
                    </div>
                  </div>
                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Inscription</button>
                  </div>
                  <div class="col-12">
                    <p class="small mb-0">Vous avez déjà un compte ? <a href="pages-login.php">Connexion</a></p>
                  </div>
                </form>

              </div>
            </div>

          </div>
        </div>
      </div>

    </section>

  </div>
</main><!-- End #main -->
<?php
require_once 'includes/footer.php';
?>