@extends ('layouts.app')

@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white py-12 px-16 rounded shadow">
        <h1 class="text-2xl font-normal mb-10 text-center">
            Vamos começar algo Novo!
        </h1>

        <form 
            method="POST" 
            action="/travels" 
        >
            @include('travels.form', [
                'travel' => new App\Travel,
                'buttonText' => 'Criar Projeto'
            ])
        </form>
    </div>
    
@endsection
