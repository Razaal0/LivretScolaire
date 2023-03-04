<?php
require_once('user-session.php');
?>
</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>Livret Scolaire</span></strong>. Tous droits réservés
    </div>
</footer>
<!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="/view/assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="/view/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/view/assets/vendor/chart.js/chart.min.js"></script>
<script src="/view/assets/vendor/echarts/echarts.min.js"></script>
<script src="/view/assets/vendor/quill/quill.min.js"></script>
<script src="/view/assets/vendor/datatables/jquery.dataTables.js"></script>
<script src="/view/assets/vendor/tinymce/tinymce.min.js"></script>
<script src="/view/assets/vendor/php-email-form/validate.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"></script>

<!-- Template Main JS File -->
<script src="/view/assets/js/main.js"></script>

<!-- créer un Toasts avec un modal qui est en bas à droite -->
<!-- il s'affiche seulement si la session "notif-modal" qui est une arraylist est supérieur à 0 -->
<!-- elle reste 5 secondes après elle disparait -->
<!-- pensez à la supprimer dans la session -->
<!-- pensez à faire une boucle pour afficher tous les messages -->
<?php
if (count($_SESSION['notif-modal']) > 0) {
?>
    <div class="toast-container position-fixed p-3 bottom-0 end-0" style="z-index: 11;">
        <?php
        foreach ($_SESSION['notif-modal'] as $notif) { ?>
            <div id="toast" class="toast align-items-center text-white bg-<?= $notif['type'] ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong><?= $notif['title'] ?></strong>
                        <br>
                        <?= $notif['message'];?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php }
        unset($_SESSION['notif-modal']);
        ?>
    </div>
    <script>
        // id du toast
        function AfficheNotif() {
        var toastElList = [].slice.call(document.querySelectorAll('#toast'))
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl);
        });
        // affiche le toast
        toastList.forEach(toast => toast.show());
        // supprime le toast après 5 secondes
        setTimeout(function() {
            toastList.forEach(toast => toast.hide());
        }, 5000);
    }
    AfficheNotif();
    </script>
<?php } ?>
</body>

</html>
