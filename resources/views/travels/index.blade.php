@extends ('layouts.app')

@section('content')
    <header class="flex items-center mb-3 pb-4">
        <div class="flex justify-between items-end w-full">
            <h2 class="text-grey text-sm font-normal">My Travels</h2>

            <a href="/travels/create" class="button">New Travel</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse ($travels as $travel)
            <div class="lg:w-1/3 px-3 pb-6">
                @include ('travels.card')
            </div>
        @empty
            <div>No travels yet.</div>
        @endforelse
    </main>
@endsection
