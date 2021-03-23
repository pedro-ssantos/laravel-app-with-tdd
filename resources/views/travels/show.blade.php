@extends ('layouts.app')

@section('content')
    <header class="flex items-center mb-3 pb-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-grey text-sm font-normal">
                <a href="/travels" class="text-grey text-sm font-normal no-underline hover:underline">My Travels</a>
                / {{ $travel->title }}
            </p>

            <a href="{{ $travel->path().'/edit' }}" class="button">Editar</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-grey font-normal mb-3">Tarefas</h2>

                    {{-- tasks --}}
                    @foreach ($travel->tasks as $task)
                        <div class="card mb-3">
                            <form method="POST" action="{{ $task->path() }}">
                                @method('PATCH')
                                @csrf

                                <div class="flex items-center">
                                    <input name="body" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-grey' : '' }}">
                                    <input name="completed" type="checkbox" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="card mb-3">
                        <form action="{{ $travel->path() . '/tasks' }}" method="POST">
                            @csrf

                            <input placeholder="Add a new task..." class="w-full" name="body">
                        </form>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>

                    {{-- general notes --}}
                    <form method="POST" action="{{ $travel->path() }}">
                        @method('PATCH')
                        @csrf

                        <textarea
                            name="notes"
                            class="card w-full mb-4"
                            style="min-height: 200px"
                            placeholder="Anything special that you want to make a note of?"
                        >{{ $travel->notes }}</textarea>

                        <button type="submit" class="button">Save</button>
                    </form>

                    @include('error')

                </div>
            </div>

            <div class="lg:w-1/4 px-3 lg:py-8">
                @include ('travels.card')
                @include ('travels.activity.card')
            </div>
        </div>
    </main>


@endsection
