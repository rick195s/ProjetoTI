<header>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Smart Factory</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./dashboard">Dashboard</a>
                </li>
            </ul>
        </div>

        <a class="nav-link" style="color:white;"><?php echo $_SESSION["username"]; ?>&nbsp</a>

        <form method="post" action="auth/logout">
            <button class="btn btn-outline-light" name="btn-logout" type="submit">Logout</button>
        </form>
    </nav>
</header>