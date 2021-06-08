<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Mostrar listado de imágenes.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::withTrashed()->orderBy('id')->where('user_id',Auth::id())->get();

        return view('layouts.images.index', compact('images'));
    }

    /**
     * Mostrar vista de creación de imágenes.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.images.create');
    }

    /**
     * Recibir los datos y guardar una imagen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required',
            'description' => ''
        ]);

        //Se guarda la imagen obtenida
        $path = Storage::disk('images')
            ->putFileAs(
                Auth::id(),
                $request->file('file-upload'),
                $request->file('file-upload')->hashName()
            );

        //Se agrega a los datos la ruta de guardado y el usuario autenticado
        $data['route'] = $path;
        $data['user_id'] = Auth::id();

        $image = Image::create($data);

        return redirect('/images/' . $image->id);
    }

    /**
     * Mostrar una imagen específica.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        return view('layouts.images.show', compact('image'));
    }

    /**
     * Mostrar vista de edición de imágenes.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        return view('layouts.images.edit', compact('image'));
    }

    /**
     * Recibir los datos de una imagen específica y actualizarlos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Image $image)
    {
        //Se carga la imagen
        $data = $request->validate([
            'name' => 'required',
            'description' => ''
        ]);

        //Se guarda la imagen obtenida en caso de ser enviada
        if($request->file('file-upload')){

            $path = Storage::disk('images')
                ->putFileAs(
                    Auth::id(),
                    $request->file('file-upload'),
                    $request->file('file-upload')->hashName()
                );

            //Se borra la imagen anterior
            Storage::disk('images')->delete($image->route);

            //Se agrega a los datos la ruta de guardado
            $data['route'] = $path;
        }

        $image->update($data);

        return redirect('/images/' . $image->id);
    }

    /**
     * Eliminar una imagen especifica.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(Image $image)
    {
        $image->delete();
        return redirect('/images');
    }

    /**
     * Restaurar una imagen específica.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function restore($id)
    {
        Image::withTrashed()
            ->where('id', $id)
            ->restore();
        return redirect('/images');
    }

    /**
     * Mostrar el dashboard con las imágenes cargadas del usuario.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function dashboard()
    {
        $images = Image::where('user_id',Auth::id())->orderBy('id')->get();
        return view('layouts.images.dashboard', compact('images'));
    }

}
