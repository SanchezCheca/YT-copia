<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        Administración de usuarios - YT-copia
    </title>

    @include('estilos')
</head>

<body>
    @include('navbar')

    <div class="container">
        <div class="row">
            <?php
            if (isset($usuarios)) {
                //CARGA LA LISTA DE USUARIOS
                ?>

            <table class="table mt-2">
                <?php
    if (isset($mensaje)){
        ?>
                <p class="mx-auto rounded p-2 bg-warning text-black mt-2">
                    {{ $mensaje }}
                </p>
                <?php
    }
    ?>

                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">About</th>
                        <th scope="col">Rol</th>
                        <th scope="col" colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
        foreach ($usuarios as $usuario) {
            ?>
                    <form name="editarUsuarioCRUD" action="editUserCRUD" method="POST">
                        @csrf
                        <input type="hidden" name="userId" value="{{ $usuario->id }}">
                        <tr>
                            <th scope="row">{{ $usuario->id }}</th>
                            <td><input type="text" name="username" value="{{ $usuario->username }}"></td>
                            <td><input type="text" name="email" value="{{ $usuario->email }}"></td>
                            <td><textarea class="form-control" name="about" rows="3" placeholder="about"
                                    id="about">{{ $usuario->about }}</textarea></td>
                            <td><input type="number" name="rol" value="{{ $usuario->rol }}"></td>
                            <td><input type="submit" name="guardar" value="Guardar" class="btn btn-success"></td>
                            <td><input type="submit" class="btn btn-danger" name="eliminar" id="eliminar" value="Eliminar"></td>
                        </tr>
                    </form>
                    <?php
        }
      ?>
                </tbody>
            </table>

            <?php

            } else {
                echo 'Algo ha cargado mal';
            }
            ?>
        </div>
    </div>

    @include('footer')
    @include('scripts')
    <script type="text/javascript">
        $(function() {
            $("#eliminar").click(function() {
                var result = confirm("¿Estás seguro?\nEsta acción no se puede deshacer");

                if (result == true) {
                    return true;
                } else {
                    return false;
                }
            });
        });
    </script>
</body>

</html>
