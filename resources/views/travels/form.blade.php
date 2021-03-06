
@csrf

<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="title">Título</label>

    <div class="control">
        <input type="text" 
        class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full" 
        name="title" 
        placeholder="Meu próximo projeto."
        value="{{ $travel->title }}"
        >
    </div>
</div>

<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="description">Descrição</label>

    <div class="control">
        <textarea name="description" 
        rows="10" 
        class="textarea bg-transparent border border-grey-light rounded p-2 text-xs w-full" 
        placeholder="Devo começar com ...">{{ $travel->description }}</textarea>
    </div>
</div>

<div class="field">
    <div class="control">
        <button type="submit" class="button is-link mr-2">{{ $buttonText }}</button>
        <a href="{{ $travel->path() }}">Cancelar</a>
    </div>
</div>

@include('error')
