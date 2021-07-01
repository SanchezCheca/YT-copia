<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pawlox\VideoThumbnail\Facade\VideoThumbnail;

class contentController extends Controller
{
    //Devuelve la información de un canal
    public function verCanal($username) {

    }

    public function upload(Request $req) {
        //Guarda el archivo original
        //$path = $req->file('archivo')->store('videos','s3');
        //$filename = basename($path);

        $filename = 'HzZ45w8bGiK61mTfmY8y6PTcKFVaZSzFvNwLSofi.mp4';

        //Video thumbnail
        $publicPath = 'https://vdm2.s3.eu-west-3.amazonaws.com/videos/' . $filename;
        VideoThumbnail::createThumbnail($publicPath, public_path(), 'movie.jpg', 0, 1280, 721);

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
