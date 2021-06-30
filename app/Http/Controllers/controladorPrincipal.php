<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class controladorPrincipal extends Controller
{
    /**
     * Va a inicio comprobando el login
     */
    public function inicio(Request $req) {
        $usuario = $this->comprobarLogin();
        $datos = [];
        if ($usuario != null) {
            $datos += [
                'usuarioIniciado' => $usuario
            ];
        }
        Return view('inicio', $datos);
    }

    public function aUpload() {
        $usuario = $this->comprobarLogin();
        $datos = [];
        if ($usuario != null) {
            $datos += [
                'usuarioIniciado' => $usuario
            ];
        }
        Return view('upload', $datos);
    }

    //------------------MÉTODOS PRIVADOS
    private function comprobarLogin() {
        if (session()->has('usuarioIniciado')) {
            return session()->get('usuarioIniciado');
        } else {
            return null;
        }
    }
}
