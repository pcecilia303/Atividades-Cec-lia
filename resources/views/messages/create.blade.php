<h1>Formulário de Cadastro de Mensagens</h1>
<hr>

<form action="/messages" method="post"> 
    {{ csrf_field() }}
     Título: <input type="text" name="titulo"> <br>
    Texto: <input type="text" name="texto"> <br>
    Autor: <input type="text" name="autor"> <br>
    <hr>
    <input type="submit" value="Salvar">
</form>

@if (Session::has('sucess'))
    <div class="container">
        <div class="alert alert-sucess">
            {{\Session::get('sucess')}}
        </div>
    </div>
@endif


<!--Mensagem -->
@if ($errors->any())
    <div class="container">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif