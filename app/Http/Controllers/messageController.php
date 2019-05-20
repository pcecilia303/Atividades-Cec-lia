<?php

namespace App\Http\Controllers;

use App\messages;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\Response;

class messageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaMessages = Messages::all();
        return view('messages.list',['messages' => $listaMessages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('messages.create');
    }

    public function store (Request $request)
    {
        //faço as validações dos campos
            //vetor com as mensagens de erro
            $mensagem = array(
                'titulo.required' => 'É obrigatório inserir um título para a mensagem',
                'texto.required' => 'É obrigatório inserir uma descrição para a mensagem',
                'autor.required' => 'É obrigatório inserir o cadastro do autor da mensagem',
            );
            //vetor com as especificações de validações
            $regras = array(
                'titulo' => 'required|string|max:255',
                'texto' => 'required',
                'autor' => 'required',
            );
            //cria o objeto com as regras de validcreated_atação
            $validador = Validator::make($request->all(), $regras, $mensagem);
            //executa as validações
            if ($validador->fails()) {
                return redirect('messages/create')
                ->withErrors($validador)
                ->withInput($request->all);
            }
            //se passou pelas validações, processa e salva no banco...
            $obj_Message = new Messages();
            $obj_Message->titulo = $request['titulo'];
            $obj_Message->texto = $request['texto'];
            $obj_Message->autor = $request['autor'];
            $obj_Message->save();
            return redirect('/messages')->with('success', 'Mensagem criada com sucesso!!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $messages = Messages::find($id);
        return view('messages.show',['messages' => $messages]);//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $obj_Messages = Messages::find($id);
        return view('messages.edit',['messages' => $obj_Messages]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\messages  $messages
     * @return \Illuminate\Http\Responsecreated_at
     */
    public function update(Request $request, $id)
    {
        //faço as validações dos campos
            //vetor com as mensagens de erro
            $mensagem = array(
                'titulo.required' => 'É obrigatório inserir um título para a mensagem',
                'texto.required' => 'É obrigatório inserir uma descrição para a mensagem',
                'autor.required' => 'É obrigatório inserir o cadastro do autor da mensagem',
            );
            //vetor com as especificações de validações
            $regras = array(
                'titulo' => 'required|string|max:255',
                'texto' => 'required',
                'autor' => 'required',
            );
            //cria o objeto com as regras de validação
            $validador = Validator::make($request->all(), $regras, $mensagem);
           
            if ($validador->fails()) {
                return redirect("messages/$id/edit")
                ->withErrors($validador)
                ->withInput($request->all);
            }
            //se passou pelas validações, processa e salva no banco...
            $obj_Messages = Messages::findOrFail($id);
            $obj_Messages->titulo = $request['titulo'];
            $obj_Messages->texto = $request['texto'];
            $obj_Messages->autor = $request['autor'];
            $obj_Messages->save();
            return redirect('/messages')->with('success', 'Mensagem editada com sucesso!!');

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $obj_Messages = Messages::find($id);
        return view('messages.delete',['messages' => $obj_Messages]);
    }


    public function destroy($id)
    {
        $obj_Messages= Messages::findOrFail($id);
        $obj_Messages->delete($id);
        return redirect('/messages')->with('sucess','Mensagem excluída com sucesso');
     //
    }
}

