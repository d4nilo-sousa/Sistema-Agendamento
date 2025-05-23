<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index(){
        $places = Place::all(); // SELECT * FROM Places
        //dd($places);
        return view('Places/table',['places'=> $places]);
    }//fim do index


    /**
     * Exibe a view para criação de um novo local (Place).
     *
     * @return \Illuminate\View\View A view da página de criação de locais.
     */
    public function create()
    {
        return view('Places/form');
    }// fim do create

    /**
     * Armazena um novo local (Place) no banco de dados a partir dos dados da requisição.
     *
     * @param \Illuminate\Http\Request $request Os dados da requisição contendo nome, descrição e capacidade do local.
     * @return \Illuminate\Http\RedirectResponse Redireciona para a página inicial após salvar o local.
     */
    public function store(Request $request)
    {
        // Criando o objeto e definindo seus atributos
        $place = new Place();
        $place->name = $request->name;
        $place->description = $request->description;
        $place->capacity = $request->capacity;

        $place->save();

        // Redireciona para a página inicial após salvar
        return redirect()->back()->with('success', 'Cadastrado com Sucesso');
    }

    public function destroy($id){
        $place = Place::findOrFail($id);
        $place->delete();
        return redirect('/places');
    }// fim do destroy

    public function edit($id){
        $place = Place::findOrFail($id);
        return view('Places/form', ["place"=>$place]);
    }//fim do edit

    public function update(Request $request){
        $place = Place::findOrFail($request->id);
       
        $place->name = $request->name;
        $place->description = $request->description;
        $place->capacity = $request->capacity;

        $place->update();

        return redirect('/places');
        
    } //fim do update
}


