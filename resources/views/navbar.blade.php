<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom py-0 mx-0">
    <a class="navbar-brand" href="/"><img src="images/logo.svg" width="50px"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <form class="form-inline mx-auto">
        <input class="form-control mr-0" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-dark ml-0" type="submit"><i class="fas fa-search"></i></button>
      </form>

        <?php
            if (isset($logged)) {

            } else {
                ?>
                <a class="d-inline mr-2" href="/register">Crear cuenta</a>
                |
                <a class="d-inline ml-2" href="/login">Iniciar sesión</a>

                <?php
            }
        ?>

    </div>
  </nav>
