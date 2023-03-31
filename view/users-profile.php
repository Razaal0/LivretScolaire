<?php
require_once 'includes/user-session.php';

if (!UserConnected()) {
  header('Location: ../view/');
  add_notif_modal('danger', 'Erreur', 'Vous devez être connecté pour accéder à cette page.');
  exit();
}
require_once('includes/header.php');
require_once('includes/nav.php');
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Profil</h1>

  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <!-- <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> -->
            <i class="bi bi-person-circle" style="font-size: 6rem;"></i>
            <h2><?php echo $_SESSION['PRENOM'] . ' ' . $_SESSION['NOM']; ?></h2>
          </div>
        </div>

      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Profil</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Éditer le profil</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Changer le mot de passe</button>
              </li>

            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">

                <h5 class="card-title">Détails du profile</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8"><?php echo $_SESSION['EMAIL']; ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Prénom</div>
                  <div class="col-lg-9 col-md-8"><?php echo $_SESSION['PRENOM']; ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Nom</div>
                  <div class="col-lg-9 col-md-8"><?php echo $_SESSION['NOM']; ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Type de compte</div>
                  <!-- 
                    Si la permission est égal à :
                    0 = Visiteur
                    10 = professeur
                    100 = Administrateur
                   -->
                  <div class="col-lg-9 col-md-8">
                    <?php echo $_SESSION['Permission'] == 0 ? 'Visiteur':
                    ($_SESSION['Permission'] == 10 ? 'Professeur':
                    ($_SESSION['Permission'] == 100 ? 'Administrateur':
                    'Aucune permission')); ?></div>
                </div>

              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                <!-- Profile Edit Form -->
                <form class="row g-3 needs-validation" action="<?php echo $path?>/controller/C_edit_password.php"  method="POST" novalidate>

                <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="change_email" type="email" class="form-control" id="Email" value="<?php echo $_SESSION['EMAIL']; ?>" require>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="prenom" class="col-md-4 col-lg-3 col-form-label">Prenom</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="change_prenom" type="text" class="form-control" id="prenom" value="<?php echo $_SESSION['PRENOM']; ?>" require>
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <label for="nom" class="col-md-4 col-lg-3 col-form-label">Nom</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="change_nom" type="text" class="form-control" id="nom" value="<?php echo $_SESSION['NOM']; ?>" require>
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                  </div>
                </form><!-- End Profile Edit Form -->

              </div>

              <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form class="row g-3 needs-validation" action="<?php echo $path?>/controller/C_edit_password.php"  method="POST" novalidate>

                  <div class="row mb-3">
                    <label for="CurrentPassword" class="col-md-4 col-lg-3 col-form-label w-auto">Mot de passe actuel</label>
                    <div class="col-md-8 col-lg-4">
                      <input name="CurrentPassword" type="password" class="form-control" id="CurrentPassword" required">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="NewPassword" class="col-md-4 col-lg-3 col-form-label w-auto">Nouveau mot de passe</label>
                    <div class="col-md-8 col-lg-4">
                      <input name="NewPassword" type="password" class="form-control" id="NewPassword" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="ConfirmPassword" class="col-md-4 col-lg-3 col-form-label w-auto">Nouveau mot de passe</label>
                    <div class="col-md-8 col-lg-4">
                      <input name="ConfirmPassword" type="password" class="form-control" id="ConfirmPassword" required>
                    </div>
                  </div>

                  <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary justify-content-end">Changer le mot de passe</button>
                  </div>
                </form><!-- End Change Password Form -->

              </div>

            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
  </section>

</main><!-- End #main -->
<?php
require_once 'includes/footer.php';
?>