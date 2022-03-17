<?php

namespace App\Http\Controllers;

use App\Models\Nature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $natures = Nature::all();
        return view('nature.index', compact('natures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
           'nom' => 'required|max:100|unique:natures',
           'seuil' => 'required|integer'
        ]);

        $nature = new Nature();
        $nature->nom = $request->nom;
        $nature->seuil = $request->seuil;
        $nature->slug = Str::slug($request->nom);
        $nature->save();

        return redirect()->route('natures.index')->with('success', "Nature enregistrée avec succès");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $slug)
    {
        $nature = Nature::where(['slug' => $slug])->firstOrFail();
        if ($nature->slug != Str::slug($request->nom)){
            $check = Nature::where(['slug' => Str::slug($request->nom)])->first();
            if ($check != null){
                return redirect()->route('natures.index')->with('error', "Ce nom existe déja");
            }else {
                $nature->nom = $request->nom;
                $nature->slug = Str::slug($request->nom);
                $nature->seuil = $request->seuil;
                $nature->save();
                return redirect()->route('natures.index')->with('success', "Nature modifiée avec succès");

            }

        }else {
            $nature->seuil = $request->seuil;
            $nature->save();
            return redirect()->route('natures.index')->with('success', "Nature modifiée avec succès");
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
