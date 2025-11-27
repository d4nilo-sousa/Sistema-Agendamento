<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index(){
        $places = Place::all(); //SELECT * FROM places
        //dd($places);
        return view('Places/table', ['places' => $places]);
        
    }


/**
 * Exibe a view de criação de um novo local (Place).
 *
 * @return \Illuminate\View\View Retorna a view 'Places/index' para criar um novo local.
 */
public function create(){
    return view('Places/form');
} //Fim do create

/**
 * Armazena um novo local (Place) no banco de dados.
 *
 * Recebe os dados do formulário por meio de uma requisição HTTP e cria um novo
 * objeto Place com os atributos nome, descrição e capacidade. Após salvar os dados,
 * redireciona o usuário para a página principal.
 *
 * @param \Illuminate\Http\Request $request Objeto da requisição contendo os dados do formulário.
 * @return \Illuminate\Http\RedirectResponse Redireciona para a página de índice após salvar.
 */
public function store(Request $request){
    //Criando o objeto e definindo os seus atributos
    $place = new Place();
    $place->name = $request->name;
    $place->description = $request->description;
    $place->capacity = $request->capacity;

    //Chama a função que salva no banco de dados
    $place->save();

    // CORREÇÃO: Redireciona para a rota places.index com mensagem de sucesso
    return redirect()->route('places.index')->with('success','Espaço cadastrado com sucesso!');
    }// Fim do store

public function destroy($id){
    $place = Place::findOrFail($id);
    $place->delete();
    // Redireciona para a rota places.index
    return redirect()->route('places.index');
}//Fim do destroy

public function edit($id){
    $place = Place::findOrFail($id);
    return view('Places/form', ["place"=>$place]);
}//Fim do edit

public function update(Request $request){
    $place = Place::findOrFail($request->id);

    $place->name = $request->name;
    $place->description = $request->description;
    $place->capacity = $request->capacity;

    //Chama a função que atualiza no banco de dados
    $place->update();
    // CORREÇÃO: Redireciona para a rota places.index com mensagem de sucesso
    return redirect()->route('places.index')->with('success','Espaço atualizado com sucesso!');
}//Fim do update

}//Fim da classe