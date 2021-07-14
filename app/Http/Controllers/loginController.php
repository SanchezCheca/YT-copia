<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class loginController extends Controller
{
    /**
     * Crea una cuenta
     */
    public function registrarCuenta(Request $req) {
        $username = $req->get('username');
        $correo = $req->get('correo');
        $pass = password_hash($req->get('pass'), PASSWORD_DEFAULT);

        //Comprueba el nombre de usuario
        $existe = User::where('username','LIKE',$username)->first();
        if ($existe) {
            $datos = [
                'exito' => false,
                'mensaje' => 'Nombre de usuario en uso'
            ];
            Return view('register', $datos);
        } else {
            $existe = User::where('email','LIKE',$correo)->first();
            if ($existe) {
                $datos = [
                    'exito' => false,
                    'mensaje' => 'Correo electrónico en uso'
                ];
                Return view('register', $datos);
            } else {
                $user = new User;
                $user->username = $username;
                $user->email = $correo;
                $user->password = $pass;
                $user->save();

                $datos = [
                    'exito' => true,
                    'mensaje' => 'Has creado tu cuenta',
                    'vieneDeCrearCuenta' => true
                ];
                Return view('login', $datos);
            }
        }
    }

    /**
     * Guarda toda la información del usuario en la sesión
     */
    public function iniciarSesion(Request $req) {
        $usuarioIniciado = null;
        $emailOrUsername = $req->get('emailOrUsername');
        $pass = $req->get('pass');

        $usuarioIniciado = User::where('username','LIKE',$emailOrUsername)->first();
        if ($usuarioIniciado) {
            //Existe con ese nombre de usuario, se comprueba la contraseña
            if (password_verify($pass, $usuarioIniciado->password)) {
                session()->put('usuarioIniciado', $usuarioIniciado);
                $datos = [
                    'mensaje' => 'Has iniciado sesión',
                    'usuarioIniciado' => $usuarioIniciado
                ];
                Return redirect()->back();
            } else {
                $datos = [
                    'mensaje' => 'La combinación nombre de usuario y contraseña no es correcta.'
                ];
                Return view('login', $datos);
            }
        } else {
            $usuarioIniciado = User::where('email','LIKE',$emailOrUsername)->first();
            if ($usuarioIniciado) {
                //Existe con ese correo, se comprueba la contraseña
                if (password_verify($pass, $usuarioIniciado->password)) {
                    session()->put('usuarioIniciado', $usuarioIniciado);
                    $datos = [
                        'mensaje' => 'Has iniciado sesión',
                        'usuarioIniciado' => $usuarioIniciado
                    ];
                    Return redirect()->back();
                } else {
                    $datos = [
                        'mensaje' => 'La combinación correo electrónico y contraseña no es correcta.'
                    ];
                    Return view('login', $datos);
                }
            } else {
                //No existe ese correo ni nombre de usuario
                $datos = [
                    'mensaje' => 'El nombre de usuario o correo electrónico no existe'
                ];
                Return view('login', $datos);
            }
        }
    }

    /**
     * Cierra la sesión
     */
    public function cerrarSesion() {
        session()->forget('usuarioIniciado');
        Return redirect()->back();
    }
}
