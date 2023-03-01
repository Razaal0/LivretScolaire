<?php
require_once('../includes/user-session.php');
if (!hasAccess(28)) {
  add_notif_modal('danger', "Accès refusé", "Vous n'avez pas les droits pour accéder à cette page");
?>
  <script>
    // redirection vers la page de connexion
    window.location.replace("../index.php");
  </script>
<?php
  exit();
}
require_once('../includes/header.php');
require_once('../includes/nav.php');
require_once('../../modele/BDD.php');


$all_email = get_all_emails();
$all_email_alias = get_all_emails_alias();

// format dic : 
// {
//   "email":
//   {
//     "STRUCTURE":"",
//     "PASSWORD":"",
//     "ALIAS":[
//       "email1",
//       "email2"
//     ]
//   }
// }
$dic = array();
foreach ($all_email as $key => $value) {
  $email = strtolower($value["EMAIL"]);
  $structure = $value["STRUCTURE"];
  $password = $value["PASSWORD"];
  $dic[$email] = array($structure, $password, array());
}
foreach ($all_email_alias as $key => $value) {
  $email = strtolower($value["EMAIL_PRINCIPAL"]);
  $alias = strtolower($value["EMAIL"]);
  array_push($dic[$email][2], $alias);
}
?>
<script>
  var dic = <?php echo json_encode($dic); ?>;
</script>
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Gérer les emails</em></h1>
  </div>
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Email principal</h5>
            <table class="table datatable">
              <thead>
                <tr>
                  <th scope="col">Nombre alias</th>
                  <th scope="col">Structure</th>
                  <th scope="col">Email</th>
                  <th scope="col">Mot de passe</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($dic as $key => $value) {

                ?>
                  <tr data-email="<?php echo $key; ?>" data-toggle="collapse" data-target="#<?php echo $key; ?>" id="<?php echo $key; ?>">
                    <td id="nb_alias"><?php echo count($value[2]); ?></td>
                    <td id="structure"><?php echo $value[0]; ?></td>
                    <td id="email">
                      <div class="user-select-all"><?php echo $key; ?></div>
                    </td>
                    <td id="password">
                      <div class="user-select-all"><?php echo $value[1]; ?></div>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- table des alias -->
    <div class="row" id="alias-table">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Alias</h5>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Email</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</main><!-- End #main -->
<?php
require_once '../includes/footer.php';
?>

<script>
  $(document).ready(function() {
  $('table.datatable').DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
    }
  });
});
  $(document).ready(function() {
  // Initialisation de la table datatable
  var table = $('.datatable').DataTable();

  // Gestion du clic sur une ligne de la table des emails principaux
  $('.datatable tbody').on('click', 'tr', function() {
    // On récupère l'email de la ligne cliquée
    var email = $(this).data('email');

    // On récupère la liste des alias correspondant à cet email
    var aliases = dic[email][2];

    // On vide la table des alias
    $('#alias-table tbody').empty();

    // On ajoute chaque alias dans la table des alias
    for (var i = 0; i < aliases.length; i++) {
      var alias = aliases[i];
      var row = '<tr><td><div class="user-select-all">' + alias + '</div></td></tr>';
      $('#alias-table tbody').append(row);
    }

    // On supprime la classe active de toutes les lignes
    $('.datatable tbody tr').removeClass('active');

    // On ajoute la classe active à la ligne sélectionnée
    $('.table tbody tr').removeClass('active').css('background-color', 'white');
    $(this).addClass('active').css('background-color', 'papayawhip');
  });
});
</script>