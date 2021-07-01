<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class contentController extends Controller
{
    //Devuelve la información de un canal
    public function verCanal($username) {

    }

    public function upload(Request $req) {
        //Guarda el archivo original
        $path = $req->file('archivo')->store('videos','s3');
        $filename = basename($path);


        $usuarioIniciado = $this->comprobarLogin();
        $datos = [
            'usuarioIniciado' => $usuarioIniciado
        ];
        Return view('inicio', $datos);
    }

    public function videoExample() {
        $usuarioIniciado = $this->comprobarLogin();
        $videoActual = Video::where('id',2)->get();

        $datos = [
            'videoInfo' => $videoActual,
            'usuarioIniciado' => $usuarioIniciado
        ];
        Return view('videoExample', $datos);
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
