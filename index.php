<?php
include 'header.php';
?>
    <div class="row">
        <div class="col-12">
            <?php if ($_SESSION['auth']['isAuth'] ?? false) :
                include 'messages.php';
            else : ?>
                <h1>Welcome on Eöras Mini-Chat</h1>
                <h2>Pleas <a href="signin.php">Sign in</a> or <a href="signup.php">Sign up</a> to see and send
                    messages.</h2>
                <p>Thanks for watching this project ;) If you have questions or want to report a bug, click
                    <a href="https://github.com/Eoras/OCR_ConcevezVotreSiteWebAvecPhpEtMysql_EspaceMembre/issues" target="_blank">here</a> !
                </p>
            <?php endif; ?>
        </div>
    </div>
    <div class="clearfix"></div>
<?php
include 'footer.php';
?>