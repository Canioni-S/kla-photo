<?php
require_once "./Include/myAutoloader.php";
if (isset($_GET['id']) && isset($_GET['token'])) {
    $auth = App::getAuth();
    $db = App::getDB();
    $user = $auth->checkResetToken($db, $_GET['id'], $_GET['token']);
    if ($user) {
        if (!empty($_POST)) {
            $validator = new Validator($_POST);
            $validator->isConfirmed("password");
            if ($validator->isValid()) {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $db->queryReq("UPDATE USERS SET password = ?, reset_at = NULL, reset_token = NULL WHERE id_user = ?", [$password, $_GET['id']]);
                Session::getInstance()->setFlash('success', "Votre mot de passe a bien été modifié");
                $auth->connect($user);
                App::redirect("account.php");
            }
        }
    } else {
        Session::getInstance()->setFlash('danger', "Ce token n'est pas valide");
        App::redirect("login.php");
    }
} else {
    App::redirect("login.php");
}
?>


<!-- PASSWORD RESET VIEW -->
<?php
$title = 'Reset du mot de passe';
$extraCss = 'form';
?>

<?php require_once './Include/navbar.php' ?>

<div class="formPageContainer">
    <h1>Réinitialiser mon mot de passe</h1>

    <form class="form" action="" method="POST">

        <div class="formItem">
            <label class="formItem" for="">Mot de passe</label>
            <input type="password" name="password" class="formInput" />
        </div>

        <div class="formItem">
            <label class="formItem" for="">Confirmation du mot de passe</label>
            <input type="password" name="password_confirm" class="formInput" />
        </div>

        <button type="submit" class="formBtn">Réinitialiser votre mot de passe</button>
    </form>
</div>

<?php require './Include/footer.php'; ?>