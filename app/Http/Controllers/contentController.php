<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
//use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Pawlox\VideoThumbnail\Facade\VideoThumbnail;

class contentController extends Controller
{
    //Devuelve la información de un canal
    public function verCanal($username)
    {
    }

    /**
     * Manda a la vista de subir vídeo
     */
    public function aUpload()
    {
        $usuarioIniciado = $this->comprobarLogin();
        if ($usuarioIniciado != null) {
            $datos = [
                'usuarioIniciado' => $usuarioIniciado
            ];
            return view('upload', $datos);
        } else {

            return view('upload');
        }
    }

    /**
     * Sube un vídeo :)
     */
    public function upload(Request $req)
    {
        //Comprueba el usuario logueado
        $usuarioIniciado = $this->comprobarLogin();

        //Guarda el archivo original
        $path = $req->file('archivo')->store('videos', 's3');
        $filename = basename($path);

        //Miniatura del vídeo
        $publicPath = 'https://vdm2.s3.eu-west-3.amazonaws.com/videos/' . $filename;
        $thumbnailFilename = substr($filename, 0, strrpos($filename, ".")) . '.jpg';    //Mismo nombre que el vídeo pero con extensión jpg
        VideoThumbnail::createThumbnail($publicPath, public_path(), $thumbnailFilename, 0, 1280, 720);   //Crea la imagen de miniatura y la guarda en local
        Storage::disk('s3')->put('thumbnails/' . $thumbnailFilename, file_get_contents($thumbnailFilename)); //Guarda la miniatura en el servidor s3
        File::delete($thumbnailFilename);    //Elimina la imagen de miniatura guardada en local

        //Guarda en BD
        $video = new Video;
        $video->filename = $filename;
        $video->publicUrl = $publicPath;
        $video->thumbnailFilename = $thumbnailFilename;
        $video->creator_id = $usuarioIniciado->id;
        $video->title = $req->get('titulo');
        $video->description = $req->get('descripcion');
        $video->save();

        //Etiquetas
        $tags = $req->get('etiquetas');
        $tagsSinEspacios = str_replace(' ', '', $tags);
        $tagsArray = explode(',', $tagsSinEspacios);
        foreach ($tagsArray as $tag) {
            $tagActual = Tag::where('name', 'LIKE', $tag)->first();
            if ($tagActual == null) {
                //La etiqueta introducida no existe en BD, se crea
                $tagActual = Tag::create([
                    'name' => $tag
                ]);
            }
            //Se asigna la etiqueta introducida a la publicación
            DB::table('video_tag')->insert([
                'video_id' => $video->id,
                'tag_id' => $tagActual->id
            ]);
        }

        return response()->json(['success' => $video->filename]);
    }

    /**
     * Carga la vista para ver un vídeo
     */
    public function verVideo($filename) {
        //Carga el propio vídeo
        $video = Video::where('filename','LIKE',$filename)->first();
        $datos = [
            'video' => $video
        ];

        //Añade 1 visualización al vídeo en cuestión
        if ($video) {
            $video->views++;
            $video->save();
        }

        //Carga los vídeos recomendados (con un atributo extra para el nombre de usuario del creador)
        $videosRecomendados = Video::take(10)->orderByDesc('created_at')->get();
        $videosRecConNombre = [];
        foreach ($videosRecomendados as $videoRec) {
            $creador = User::find($videoRec->creator_id);
            $videoRec['creatorUsername'] = $creador->username;
            $videosRecConNombre[] = $videoRec;
        }
        $datos += [
            'videosRecomendados' => $videosRecConNombre
        ];

        //Carga el usuario logueado
        $usuarioIniciado = $this->comprobarLogin();
        if ($usuarioIniciado != null) {
            $datos += [
                'usuarioIniciado' => $usuarioIniciado
            ];
        }

        return view('video', $datos);
    }

    public function videoExample()
    {
        $usuarioIniciado = $this->comprobarLogin();
        $videoActual = Video::where('id', 2)->get();

        $datos = [
            'videoInfo' => $videoActual,
            'usuarioIniciado' => $usuarioIniciado
        ];
        return view('videoExample', $datos);
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
