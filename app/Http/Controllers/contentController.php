<?php

namespace App\Http\Controllers;

use App\Models\Dislike;
use App\Models\Like;
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
        $usuarioIniciado = $this->comprobarLogin();
        $datos = [
            'usuarioIniciado' => $usuarioIniciado
        ];
        $user = User::where('username', 'LIKE', $username)->first();
        if ($user) {
            //nº de suscriptores
            $subs = DB::select('SELECT COUNT(user_following_id) AS subs FROM user_following WHERE user_following_id = ?', [$user->id]);
            $user->subs = $subs[0]->subs;

            //Visitas totales
            $views = DB::select('SELECT SUM(views) AS views FROM videos WHERE creator_id = ?', [$user->id]);
            $user->views = $views[0]->views;

            //nº de likes
            $likes = DB::select('SELECT COUNT(video_id) AS likes FROM video_likes WHERE video_id IN (SELECT id FROM videos WHERE creator_id = ?)', [$user->id]);
            $user->likes = $likes[0]->likes;

            //nº de dislikes
            $dislikes = DB::select('SELECT COUNT(video_id) AS dislikes FROM video_dislikes WHERE video_id IN (SELECT id FROM videos WHERE creator_id = ?)', [$user->id]);
            $user->dislikes = $dislikes[0]->dislikes;

            //Comprueba si ya está suscrito
            if ($usuarioIniciado) {
                $suscrito = DB::select('SELECT COUNT(user_id) AS suscrito FROM user_following WHERE user_id = ? AND user_following_id = ?', [$usuarioIniciado->id, $user->id]);
                if ($suscrito[0]->suscrito == 0) {
                    $suscrito = false;
                } else {
                    $suscrito = true;
                }
                $datos += [
                    'estaSuscrito' => $suscrito
                ];
            }

            //Carga los vídeos del usuario
            $userVideos = Video::where('creator_id', '=', $user->id)->take(9)->orderByDesc('created_at')->get();
            if ($userVideos) {
                $datos += [
                    'userVideos' => $userVideos
                ];
            }

            //Carga el nº de vídeos del usuario
            $nVideos = DB::select('SELECT COUNT(id) AS nVideos FROM videos WHERE creator_id = ?', [$user->id]);
            $user->nVideos = $nVideos[0]->nVideos;

            $datos += [
                'user' => $user
            ];
            return view('canal', $datos);
        } else {
            //El usuario no existe
            return view('canal', $datos);
        }
    }

    /**
     * Carga todos los vídeos de un canal
     */
    public function verVideosCanal($username)
    {
        $usuarioIniciado = $this->comprobarLogin();
        $datos = [
            'usuarioIniciado' => $usuarioIniciado
        ];
        $user = User::where('username','LIKE',$username)->first();
        if ($user) {
            //nº de suscriptores
            $subs = DB::select('SELECT COUNT(user_following_id) AS subs FROM user_following WHERE user_following_id = ?', [$user->id]);
            $user->subs = $subs[0]->subs;

            //Visitas totales
            $views = DB::select('SELECT SUM(views) AS views FROM videos WHERE creator_id = ?', [$user->id]);
            $user->views = $views[0]->views;

            //Comprueba si ya está suscrito
            if ($usuarioIniciado) {
                $suscrito = DB::select('SELECT COUNT(user_id) AS suscrito FROM user_following WHERE user_id = ? AND user_following_id = ?', [$usuarioIniciado->id, $user->id]);
                if ($suscrito[0]->suscrito == 0) {
                    $suscrito = false;
                } else {
                    $suscrito = true;
                }
                $datos += [
                    'estaSuscrito' => $suscrito
                ];
            }

            //Vídeos
            $userVideos = Video::where('creator_id', '=', $user->id)->orderByDesc('created_at')->get();
            $datos += [
                'user' => $user,
                'userVideos' => $userVideos
            ];

            return view('verVideosCanal',$datos);
        } else {
            return view('verVideosCanal',$datos);
        }
    }

    /**
     * Carga el usuario para ir a editar perfil
     */
    public function aEditProfile() {
        $usuarioIniciado = $this->comprobarLogin();
        if ($usuarioIniciado) {
            $datos = [
                'usuarioIniciado' => $usuarioIniciado
            ];
            return view('editProfile', $datos);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Actualiza un usuario
     */
    public function editProfile(Request $req) {
        $usuarioIniciado = $this->comprobarLogin();
        if ($usuarioIniciado) {
            //Guarda la imagen si existe
            if ($req->file('profileImage')) {
                $path = $req->file('profileImage')->store('profileImages', 's3');
                $filename = basename($path);
                $publicProfileImageUrl = 'https://vdm2.s3.eu-west-3.amazonaws.com/profileImages/' . $filename;

                //Elimina la imagen de perfil actual del servidor
                if ($usuarioIniciado->publicProfileImageUrl != 'images/defaultUserImage.png') {
                    $actualFilename = explode('/', $usuarioIniciado->publicProfileImageUrl);
                    $actualFilename = $actualFilename[sizeof($actualFilename) - 1];

                    Storage::disk('s3')->delete('profileImages/' . $actualFilename);
                }

                $usuarioIniciado->publicProfileImageUrl = $publicProfileImageUrl;
            }

            //Guarda la descripción
            $usuarioIniciado->about = $req->input('descripcion');

            $usuarioIniciado->save();
            return redirect(url('user/' . $usuarioIniciado->username));
        } else {
            return redirect()->back();
        }
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
    public function verVideo($filename)
    {
        //Carga el propio vídeo
        $video = Video::where('filename', 'LIKE', $filename)->first();
        $likes = DB::select('SELECT COUNT(video_id) AS "likes" FROM video_likes WHERE video_id = :id', ['id' => $video->id]);
        $video->likes = $likes[0]->likes;
        $dislikes = DB::select('SELECT COUNT(video_id) AS "dislikes" FROM video_dislikes WHERE video_id = :id', ['id' => $video->id]);
        $video->dislikes = $dislikes[0]->dislikes;

        $datos = [
            'video' => $video
        ];

        //Datos del creador del vídeo
        $creator = User::where('id','=',$video->creator_id)->first();
        $nSubs = DB::select('SELECT COUNT(user_following_id) AS nSubs FROM user_following WHERE user_following_id = ?', [$creator->id]);
        $creator->nSubs = $nSubs[0]->nSubs;
        $datos += [
            'creator' => $creator
        ];

        //Carga el usuario logueado
        $usuarioIniciado = $this->comprobarLogin();
        if ($usuarioIniciado != null) {
            $datos += [
                'usuarioIniciado' => $usuarioIniciado
            ];

            //Comprueba si el usuario ha dado like al vídeo
            $hasLiked = DB::select('SELECT COUNT(video_id) AS "liked" FROM video_likes WHERE user_id = :id AND video_id = :videoId', ['id' => $usuarioIniciado->id, 'videoId' => $video->id]);
            if ($hasLiked[0]->liked == 1) {
                $hasLiked = true;
            } else {
                $hasLiked = false;
            }
            $datos += [
                'hasLiked' => $hasLiked
            ];

            //Comprueba si el usuario ha dado dislike al vídeo
            $hasDisliked = DB::select('SELECT COUNT(video_id) AS "disliked" FROM video_dislikes WHERE user_id = :id AND video_id = :videoId', ['id' => $usuarioIniciado->id, 'videoId' => $video->id]);
            if ($hasDisliked[0]->disliked == 1) {
                $hasDisliked = true;
            } else {
                $hasDisliked = false;
            }
            $datos += [
                'hasDisliked' => $hasDisliked
            ];
        }

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

        return view('video', $datos);
    }

    //Like a un video
    public function likeVideo($filename)
    {
        //Comprueba que se ha iniciado sesión
        $usuarioIniciado = $this->comprobarLogin();
        if ($usuarioIniciado) {
            $video = Video::where('filename', 'LIKE', $filename)->first();

            //Comprueba si se le ha dado like ya
            $like = Like::where('user_id', '=', $usuarioIniciado->id)->where('video_id', '=', $video->id)->first();
            if ($like != null) {
                //Ya ha dado like, lo quita
                DB::delete('DELETE FROM video_likes WHERE video_id = ? AND user_id = ?', [$video->id, $usuarioIniciado->id]);
                return redirect(url('video/' . $filename));
            } else {
                //Elimina el dislike de haberlo
                $dislike = Dislike::where('user_id', '=', $usuarioIniciado->id)->where('video_id', '=', $video->id)->first();
                if ($dislike != null) {
                    DB::delete('DELETE FROM video_dislikes WHERE video_id = ? AND user_id = ?', [$video->id, $usuarioIniciado->id]);
                }

                //Añade el like
                DB::insert('INSERT INTO video_likes VALUES (?, ?, null, null)', [$video->id, $usuarioIniciado->id]);
                return redirect(url('video/' . $filename));
            }
        } else {
            //No se ha iniciado sesión
            return redirect(url('login'));
        }
    }

    //Dislike a un video
    public function dislikeVideo($filename)
    {
        //Comprueba que se ha iniciado sesión
        $usuarioIniciado = $this->comprobarLogin();
        if ($usuarioIniciado) {
            $video = Video::where('filename', 'LIKE', $filename)->first();

            //Comprueba si se le ha dado dislike ya
            $dislike = Dislike::where('user_id', '=', $usuarioIniciado->id)->where('video_id', '=', $video->id)->first();
            if ($dislike != null) {
                //Ya ha dado dislike, lo quita
                DB::delete('DELETE FROM video_dislikes WHERE video_id = ? AND user_id = ?', [$video->id, $usuarioIniciado->id]);
                return redirect(url('video/' . $filename));
            } else {
                //Elimina el like de haberlo
                $like = Like::where('user_id', '=', $usuarioIniciado->id)->where('video_id', '=', $video->id)->first();
                if ($like != null) {
                    DB::delete('DELETE FROM video_likes WHERE video_id = ? AND user_id = ?', [$video->id, $usuarioIniciado->id]);
                }

                //Añade el dislike
                DB::insert('INSERT INTO video_dislikes VALUES (?, ?, null, null)', [$video->id, $usuarioIniciado->id]);
                return redirect(url('video/' . $filename));
            }
        } else {
            //No se ha iniciado sesión
            return redirect(url('login'));
        }
    }

    //Se suscribe/desuscribe a un usuario
    public function subscribe($username)
    {
        $usuarioIniciado = $this->comprobarLogin();
        $user = User::where('username', 'LIKE', $username)->first();
        //No se puede suscribir a si mismo
        if ($usuarioIniciado) {
            if ($usuarioIniciado->id != $user->id) {
                if ($usuarioIniciado) {
                    //Comprueba si ya está suscrito
                    $suscrito = DB::select('SELECT COUNT(user_id) AS suscrito FROM user_following WHERE user_id = ? AND user_following_id = ?', [$usuarioIniciado->id, $user->id]);
                    if ($suscrito[0]->suscrito == 0) {
                        //No está suscrito, se suscribe
                        DB::insert('INSERT INTO user_following VALUES (?,?)', [$usuarioIniciado->id, $user->id]);
                        return redirect()->back();
                    } else {
                        //Está suscrito, se desuscribe
                        DB::delete('DELETE FROM user_following WHERE user_id = ? AND user_following_id = ?', [$usuarioIniciado->id, $user->id]);
                        return redirect()->back();
                    }
                }
            } else {
                return redirect()->back();
            }
        } else {
            return redirect(url('login'));
        }
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
