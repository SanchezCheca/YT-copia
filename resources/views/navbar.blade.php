<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom py-0 mx-0">
    <a class="navbar-brand" href="{{url('inicio')}}"><img src="{{url('images/logo.svg')}}" width="50px"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <form class="form-inline mx-auto">
        <input class="form-control mr-0" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-dark ml-0" type="submit"><i class="fas fa-search"></i></button>
      </form>

        <?php
            if (isset($usuarioIniciado)) {
                ?>
                <ul class="navbar-nav mt-2 mt-lg-0">
                    <li class="nav-item my-auto mr-2">
                        <a href="{{url('upload')}}" class="my-auto text-dark"><i class="fas fa-upload"></i> Subir</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{url('images/defaultUserImage.png')}}" class="perfilRedondo" alt="Perfil">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink2">
                            <a class="dropdown-item" href="{{url('user/' . $usuarioIniciado->username)}}"><i class="fas fa-video"></i> Mi canal</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-trophy"></i> Ranking</a>

                            <?php
                            if ($usuarioIniciado->rol == 1) {
                                ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('crud')}}">Zona ADMIN</a>
                                <?php
                            }
                            ?>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{url('cerrarSesion')}}"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                        </div>
                    </li>
                </ul>
                <?php
            } else {
                ?>
                <a class="d-inline mr-2" href="{{url('register')}}">Crear cuenta</a>
                |
                <a class="d-inline ml-2" href="{{url('login')}}">Iniciar sesión</a>

                <?php
            }
        ?>

    </div>
  </nav>
