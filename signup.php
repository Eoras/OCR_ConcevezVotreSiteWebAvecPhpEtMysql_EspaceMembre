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
                Sign Up
                <i class="fas fa-user-plus float-right"></i>
            </h1>
            <form action="action/signup.php" method="POST">
                <div class="form-group">
                    <label for="formUsername">Username</label>
                    <input type="text" class="form-control" id="formUsername" name="username"
                           placeholder="Username" value="<?= $post['username'] ?? '' ?>">
                    <small class="text-warning"><?= $errors['username'] ?? "" ?></small>
                </div>
                <div class="form-group">
                    <label for="formEmail">E-mail adress</label>
                    <input type="email" class="form-control" id="formEmail" name="email" placeholder="E-mail adress"
                           value="<?= $post['email'] ?? '' ?>">
                    <small class="text-warning"><?= $errors['email'] ?? "" ?></small>
                </div>
                <div class="form-group">
                    <label for="formPassword1">Password</label>
                    <input type="password" class="form-control" id="formPassword1" name="password1"
                           placeholder="Password" value="<?= $post['password1'] ?? '' ?>">
                    <small class="text-warning"><?= $errors['password1'] ?? "" ?></small>
                </div>
                <div class="form-group">
                    <label for="formPassword2">Retype password</label>
                    <input type="password" class="form-control" id="formPassword2" name="password2"
                           placeholder="Retype password">
                    <small class="text-warning"><?= $errors['password2'] ?? "" ?></small>
                </div>
                <div>
                    <div class="g-recaptcha" data-sitekey="<?= $reCaptchaGoogle_dataSiteKey ?? ""?>"></div>
                    <small class="text-warning"><?= $errors['recaptcha'] ?? "" ?></small>
                </div>
                <button type="submit" class="btn btn-primary btn-sm float-right">Sign up</button>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
<?php
include 'footer.php';
?>