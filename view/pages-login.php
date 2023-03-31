<?php
require_once 'includes/header.php';
require_once('includes/nav.php');
require_once 'includes/user-session.php';

if (UserConnected()) {
  header('Location: ../view/');
  add_notif_modal('danger', 'Erreur', 'Vous êtes déjà connecté.');
  exit();
}

?>
<main id="main" class="main">
  <div class="container">

    <section class="section register d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
              <a href="index.html" class="logo d-flex align-items-center w-auto">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">Livret Scolaire</span>
              </a>
            </div><!-- End Logo -->

            <div class="card mb-3">

              <div class="card-body">

                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Connectez-vous à votre compte</h5>
                  <p class="text-center small">Entrez votre email et votre mot de passe pour vous connecter</p>
                </div>

                <form class="row g-3 needs-validation" action="<?php echo $path?>/controller/C_login.php" method="POST" novalidate>

                  <div class="col-12">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group has-validation">
                      <input type="text" name="email" class="form-control" id="email" required>
                      <div class="invalid-feedback">Veuillez entrer votre email.</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                    <div class="invalid-feedback">Veuillez entrer votre mot de passe.</div>
                    <p class="small mb-0">Mot de passe oublié ? <a href="edit-password.php">Modifier le mot de passe</a></p>
                    <br>
                  </div>

                  <div class="col-12">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                      <label class="form-check-label" for="rememberMe">Se souvenir de moi</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Connexion</button>
                  </div>
                  <div class="col-12">
                    <p class="small mb-0">Vous n'avez pas de compte ? <a href="pages-register.php">Créer un compte</a></p>
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
