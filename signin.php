<?php
include 'header.php';
if(isset($_SESSION['auth']['isAuth']) && $_SESSION['auth']['isAuth'] ) {
    header('location: /index.php');
    exit();
}
$errors = $_SESSION['errors'] ?? [];
$post =  $_SESSION['post'] ?? [];

?>
    <div class="row">
        <div class="col-md-8 col-lg-6 mx-auto bg-dark shadow border p-4 text-light">
            <h1 class="mb-3">
                Sign In
                <i class="fas fa-sign-in-alt float-right"></i>
            </h1>
            <form action="action/signin.php" method="POST">
                <small class="text-warning"><?= $errors['signin'] ?? "" ?></small>
                <div class="form-group">
                    <input type="text" class="form-control rounded-0 border-0 border-left" id="formUsername" name="username"
                           placeholder="Username" value="<?= $post['username'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control rounded-0 border-0 border-left" id="formPassword" name="password"
                           placeholder="Password">
                </div>
                <div class="form-check">
                <input type="checkbox" class="form-check-input" id="formStayLogged" name="formStayLogged">
                    <label for="formStayLogged" class="form-check-label">Remember me</label>
                </div>
                <button type="submit" class="btn btn-light float-right btn-sm">Sign in</button>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
<?php
include 'footer.php';
?>