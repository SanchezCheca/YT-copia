<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class adminController extends Controller
{
    /**
     * Manda al crud y carga los datos si es un administrador
     */
    public function aCrud()
    {
        $usuarioIniciado = $this->comprobarLogin();
        if ($usuarioIniciado && $usuarioIniciado->rol == 1) {
            //Carga los datos de todos los usuarios
            $usuarios = User::get();
            $datos = [
                'usuarioIniciado' => $usuarioIniciado,
                'usuarios' => $usuarios,
            ];
            return view('crud', $datos);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Edita un usuario
     */
    public function editUserCRUD(Request $request)
    {
        $usuarioIniciado = $this->comprobarLogin();
        if ($usuarioIniciado && $usuarioIniciado->rol == 1) {
            $usuarios = User::get();
            $datos = [
                'usuarioIniciado' => $usuarioIniciado,
                'usuarios' => $usuarios
            ];

            //Comprueba a qué botón se le ha dado
            if ($request->input('eliminar')) {
                $id = $request->input('userId');

                $usuario = User::find($id);
                $mensaje = 'Has eliminado al usuario ' . $usuario->username;
                $datos += [
                    'mensaje' => $mensaje
                ];

                //Elimina los registros relativos al usuario en videos, video_tag, user_following, video_likes, video_dislikes y commentaries
                DB::delete('DELETE FROM video_tag WHERE video_id IN (SELECT id FROM videos WHERE creator_id = ?)', [$usuario->id]);
                Video::where('creator_id','=',$usuario->id)->delete();
                DB::delete('DELETE FROM user_following WHERE user_id = ? OR user_following_id = ?', [$usuario->id, $usuario->id]);
                DB::delete('DELETE FROM video_likes WHERE user_id = ?', [$usuario->id]);
                DB::delete('DELETE FROM video_dislikes WHERE user_id = ?', [$usuario->id]);
                DB::delete('DELETE FROM commentaries WHERE user_id = ?', [$usuario->id]);

                $usuario->delete();

                $datos['usuarios'] = User::get();

                return view('crud', $datos);
            } else if ($request->input('guardar')) {
                //Actualiza todos los datos del usuario y devuelve al crud
                $usuario = User::find($request->input('userId'));
                $usuario->username = $request->input('username');
                $usuario->email = $request->input('email');
                $usuario->about = $request->input('about');
                $usuario->rol = $request->input('rol');
                $usuario->save();

                $datos['usuarios'] = User::get();
                $datos['mensaje'] = 'Has actualizado al usuario ' . $usuario->username;
                return view('crud', $datos);
            } else {
                $mensaje = 'Ha ocurrido algún error';
                $datos += [
                    'mensaje' => $mensaje
                ];
                return view('crud', $datos);
            }
        } else {
            return redirect()->back();
        }
    }

    /**
     * Recupera todos los contactos de la bd
     */
    public function verContactos() {
        $datos = [];
        $usuarioIniciado = $this->comprobarLogin();
        $datos += [
            'usuarioIniciado' => $usuarioIniciado
        ];
        if ($usuarioIniciado && $usuarioIniciado->rol == 1) {
            $contactos = Contacto::orderByDesc('created_at')->get();
            $datos += [
                'contactos' => $contactos
            ];
            return view('verContactos', $datos);
        } else {
            return redirect()->back();
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
