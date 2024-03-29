<?php
require_once('../modele/BDD.php');
require_once('includes/header.php');
require_once('includes/user-session.php');

if (UserConnected()) {
  header('Location: ../view/');
  add_notif_modal('danger', 'Erreur', 'Vous êtes déjà connecté.');
  exit();
}
require_once('includes/header.php');
require_once('includes/nav.php');
?>
<main id="main" class="main">
  <div class="container">

    <section class="section register d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
              <a href="<?php echo $path?>index.html" class="logo d-flex align-items-center w-auto">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">Livret Scolaire</span>
              </a>
            </div><!-- End Logo -->

            <div class="card mb-3">

              <div class="card-body">

                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Modifier le mot de passe</h5>
                  <p class="text-center small">Vous avez oublié votre mot de passe ? Pas de soucis, veuillez nous renseigner les informations ci-dessous.</p>
                </div>

                <form class="row g-3 needs-validation" action="<?php echo $path?>/controller/C_edit_password.php"  method="POST" novalidate>

                  <div class="col-12">
                    <label for="mdp" class="form-label">Nouveau mot de passe</label>
                    <div class="input-group has-validation">
                      <input type="password" name="mdp" class="form-control" id="mdp" required>
                      <div class="invalid-feedback">Nouveau mot de passe</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="rmdp" class="form-label">Répétez de nouveau votre mot de passe</label>
                    <div class="input-group has-validation">
                      <input type="password" name="rmdp" class="form-control" id="rmdp" required>
                      <div class="invalid-feedback">Nouveau mot de passe</div>
                    </div>
                  </div>
                    
                 

                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Modifier le mot de passe</button>
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