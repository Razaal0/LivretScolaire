<?php
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
                  <h5 class="card-title text-center pb-0 fs-4">Modifier le mot de passe</h5>
                  <p class="text-center small">Vous avez oublié votre mot de passe ? Pas de soucis, veuillez nous renseigner les informations ci-dessous.</p>
                </div>

                <form class="row g-3 needs-validation" action="/controller/C_edit_password.php"  method="POST" novalidate>

                  <div class="col-12">
                    <label for="prenom" class="form-label">Prénom</label>
                    <div class="input-group has-validation">
                      <input type="text" name="prenom" class="form-control" id="prenom" required>
                      <div class="invalid-feedback">Prénom</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="nom" class="form-label">Nom</label>
                    <div class="input-group has-validation">
                      <input type="text" name="nom" class="form-control" id="nom" required>
                      <div class="invalid-feedback">Nom</div>
                    </div>
                  </div>
                    
                  <div class="col-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                    <div class="invalid-feedback">Veuillez saisir une adresse email valide !</div>
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

<style>
  #footer {
    margin-left: 0px;
}
</style>