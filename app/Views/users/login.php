<form method="post" action="?p=users.login" class="form-signin" style="text-align: center; width: 550px;max-width: 90%; padding: 20px; margin: 0 auto; background: #ededed">
    <div style="width:100%;height:210px;background: url('images/corporate/logo_bandai_namco.png') no-repeat center #222;background-size: contain;"></div>

    <h2 class="form-signin-heading" style="margin: 40px 0">ADMINISTRATION<br>Bandai Namco games</h2>
    <?php if(isset($errors)){ ?>
        <div class="alert alert-danger">
            Bad Login or password
        </div>
    <?php } ?>
    <?= $form->input('login', 'Login'); ?>
    <label for="inputPassword" class="sr-only">Password</label>
    <?= $form->input('password', 'password', ['type' => 'password']); ?>
   <!-- <div class="checkbox">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>-->
    <button class="btn btn-lg btn-primary btn-block" style="margin-top: 20px" type="submit">Sign in</button>
</form>