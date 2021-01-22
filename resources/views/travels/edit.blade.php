@extends ('layouts.app')

@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white py-12 px-16 rounded shadow">
        <h1 class="text-2xl font-normal mb-10 text-center">
            Editar seu Projeto
        </h1>

        <form 
            method="POST" 
            action="{{ $travel->path() }}" 
        >
            @method('PATCH')
            @include('travels.form', [
                'buttonText' => 'Atualizar Projeto'
            ])

        
        </form>
    </div>
   
@endsection
