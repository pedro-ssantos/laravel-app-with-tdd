<div class="card" style="height: 200px">
  <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-light pl-4">
      <a href="{{ $travel->path() }}" class="text-black no-underline">{{ $travel->title }}</a>
  </h3>

  <div class="text-grey">{{ str_limit($travel->description, 100) }}</div>
</div>
