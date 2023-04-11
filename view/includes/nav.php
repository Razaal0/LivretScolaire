<?php
require_once('user-session.php');
require_once('' . __DIR__ . '/../../modele/BDD.php');
?>
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="<?php echo $path ?>/view/index.php" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">Livret Scolaire</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <?php
            if (UserConnected()) {
            ?>
                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle" style="font-size: 2rem;"></i>
                        <!-- <img src="/view/assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">  image de profile-->
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['PRENOM'] . " " . $_SESSION['NOM']; ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $_SESSION['PRENOM'] . " " . $_SESSION['NOM']; ?></h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo $path ?>/view/users-profile.php">
                                <i class="bi bi-gear"></i>
                                <span>Paramètres du compte</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo $path ?>/view/pages-faq.php">
                                <i class="bi bi-question-circle"></i>
                                <span>Besoin d'aide ?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo $path ?>/controller/logout-session.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Se déconnecter</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->
            <?php
            }
            ?>
        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="<?php echo $path ?>/view/index.php">
                <i class="bi bi-grid"></i>
                <span>Accueil</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <!-- 
            Menu administration
         -->
        <?php
        if (hasAccess(100)) {
        ?>
            <li class="nav-item">
                <a id="menu_administration" class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-wrench"></i><span>Administration</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
            </li>

            <!-- Bouton pour voir les menu dans la liste déroulante de l'administration -->
            <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?php echo $path ?>/controller/C_prof.php">
                        <i class="bi bi-circle"></i><span>Enseignants</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $path ?>/controller/C_matiere.php">
                        <i class="bi bi-circle"></i><span>Matières</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $path ?>/controller/C_affectation.php">
                        <i class="bi bi-circle"></i><span>Affectation</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $path ?>/controller/C_etudiant.php">
                        <i class="bi bi-circle"></i><span>Etudiants</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $path ?>/controller/C_import.php">
                        <i class="bi bi-circle"></i><span>Importer</span>
                    </a>
                </li>
            </ul>
        <?php
        }
        ?>
        <!-- Fin menu administration -->

        <!-- Menu professeurs -->
        <?php
        if (hasAccess(10)) {
        ?>
            <ul class="sidebar-nav" id="sidebar-nav">

                <!-- Saisr notes -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="<?php echo $path ?>/controller/C_classe.php">
                        <i class="bi bi-currency-bitcoin"></i>
                        <span>Saisr notes</span>
                    </a>
                </li>
            </ul>
        <?php
        }
        ?>


        <!-- End Dashboard Nav -->
        <li class="nav-heading">Pages</li>

        <?php
        if (!UserConnected()) {
        ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo $path ?>/view/pages-register.php">
                    <i class="bi bi-card-list"></i>
                    <span>Inscription</span>
                </a>
            </li><!-- End Register Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?php echo $path ?>/view/pages-login.php">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Connexion</span>
                </a>
            </li><!-- End Login Page Nav -->
        <?php
        }
        ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?php echo $path ?>/view/pages-faq.php">
                <i class="bi bi-question-circle"></i>
                <span>F.A.Q</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->

    </ul>

</aside><!-- End Sidebar-->