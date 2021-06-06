<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::withTrashed()->orderBy('id')->get();

        return view('layouts.images.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.images.create');
    }

    /**
     * Store a newly created resource in storage.
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

        //Se agrega a los datos la ruta de guardado
        $data['route'] = $path;

        $image = Image::create($data);

        return redirect('/images/' . $image->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        return view('layouts.images.show', compact('image'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        return view('layouts.images.edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Image $image)
    {
        //Se carga la imagen
        $data = $request->validate([
            'name' => '',
            'description' => '',
            'route' => ''
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
     * Remove the specified resource.
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
     * Restore the specified resource.
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
     * Restore the specified resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function dashboard()
    {
        $images = Image::all();
        return view('layouts.images.dashboard', compact('images'));
    }

}
