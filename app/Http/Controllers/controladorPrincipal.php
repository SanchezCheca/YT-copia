<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class controladorPrincipal extends Controller
{
    /**
     * Va a inicio comprobando el login
     */
    public function inicio(Request $req)
    {
        //Comprueba si el usuario ha iniciado sesión
        $usuarioIniciado = $this->comprobarLogin();
        $datos = [];
        if ($usuarioIniciado != null) {
            $datos += [
                'usuarioIniciado' => $usuarioIniciado
            ];
        }

        //Recoge los últimos 12 vídeos subidos
        $ultimosVideos = Video::take(12)->orderByDesc('created_at')->get();
        $ultimosVideosConCreatorUsername = [];
        foreach ($ultimosVideos as $video) {    //Añade el nombre del creador a cada vídeo
            $creator = User::find($video->creator_id);
            $video->creatorUsername = $creator->username;
            $video->creatorImageUrl = $creator->publicProfileImageUrl;
            $ultimosVideosConCreatorUsername[] = $video;
        }
        $datos += [
            'ultimosVideos' => $ultimosVideosConCreatorUsername
        ];

        //Recoge los 6 vídeos más vistos
        $videosMasVistos = Video::take(6)->orderByDesc('views')->get();
        $videosMasVistosConCreatorUsername = [];
        foreach ($videosMasVistos as $video) {
            $creator = User::find($video->creator_id);
            $video->creatorUsername = $creator->username;
            $video->creatorImageUrl = $creator->publicProfileImageUrl;
            $videosMasVistosConCreatorUsername[] = $video;
        }
        $datos += [
            'videosMasVistos' => $videosMasVistosConCreatorUsername
        ];

        //Recoge los últimos 6 vídeos de usuarios a los que está suscrito
        if ($usuarioIniciado) {
            $videosSuscripciones = DB::select('SELECT * FROM videos WHERE creator_id IN (SELECT user_following_id FROM user_following WHERE user_id = ?) ORDER BY created_at DESC LIMIT 6', [$usuarioIniciado->id]);
            if (sizeof($videosSuscripciones) > 0) {
                $videosSuscripcionesConCreatorUsername = [];
                foreach ($videosSuscripciones as $video) {    //Añade el nombre del creador a cada vídeo
                    $creator = User::find($video->creator_id);
                    $video->creatorUsername = $creator->username;
                    $video->creatorImageUrl = $creator->publicProfileImageUrl;
                    $videosSuscripcionesConCreatorUsername[] = $video;
                }
                $datos += [
                    'videosSuscripciones' => $videosSuscripcionesConCreatorUsername
                ];
            }
        }

        return view('inicio', $datos);
    }

    public function aUpload()
    {
        $usuario = $this->comprobarLogin();
        $datos = [];
        if ($usuario != null) {
            $datos += [
                'usuarioIniciado' => $usuario
            ];
        }
        return view('upload', $datos);
    }

    /**
     * Si ya ha iniciado sesión, vuelve hacia atrás
     */
    public function aLogin(Request $req)
    {
        $usuarioIniciado = $this->comprobarLogin();
        if ($usuarioIniciado) {
            return redirect()->back();
        } else {
            return view('login');
        }
    }

    public function aRegister()
    {
        $usuarioIniciado = $this->comprobarLogin();
        if ($usuarioIniciado) {
            return redirect()->back();
        } else {
            return view('register');
        }
    }

    //------------------MÉTODOS PRIVADOS
    private function comprobarLogin()
    {
        if (session()->has('usuarioIniciado')) {
            return session()->get('usuarioIniciado');
        } else {
            return null;
        }
    }
}
