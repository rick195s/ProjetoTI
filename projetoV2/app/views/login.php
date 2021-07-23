<div class="container-fluid" id="login-container">

	<?php
	$this->title = "Login Page";

	if (isset($this->errors["auth"])) { ?>
        <div class="alert alert-danger bg-danger" role="alert">

            <lord-icon alt="danger" class="icon-danger" src="https://cdn.lordicon.com//tdrtiskw.json" trigger="loop"
                       colors="primary:#ffffff,secondary:#ffffff">
            </lord-icon>
            <h4 class="alert-heading">Autentificação falhada!</h4>
			<?php foreach ($this->errors["auth"] as $error) {
				echo "<p>" . $error . "</p>";
			}
			?>
        </div>
	<?php }
	?>


    <div class="row text-center" id="login-row">

        <div class="shadow-lg col-md-5 col-10" id="login-box">
            <form action="auth" method="POST" class="mx-auto form-login">
                <img class="mb-4" src="<?php echo $this->path; ?>public/assets/images/logoSF.png" alt="" width="72"
                     height="72"/>

                <h1 class="h3 mb-3 font-weight-normal ">LOGIN</h1>

                <label for="username" class="sr-only">Username</label>
                <input type="text" id="username" class="form-control" name="username" value="" placeholder="Username"
                       required autofocus/>

                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" class="form-control" name="password" value=""
                       placeholder="Password"
                       required/>
                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" id="rememberMe" value="lsRememberMe"> Remember me
                    </label>
                </div>
                <button onclick="lsRememberMe()" class="btn btn-lg btn-primary" name="btn-login"
                        type="submit">Entrar
                </button>
            </form>

        </div>

    </div>
</div>