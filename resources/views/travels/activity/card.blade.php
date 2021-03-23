<div class="card mt-3">
  <ul class="text-xs list-reset">
    @foreach ($travel->activity as $activity)
      <li class="{{ $loop->last ? '' : 'mb-1' }}">
        @include ("travels.activity.{$activity->description}")
        <span class="text-grey">{{ $activity->created_at->diffForHumans(null, true) }}</span>
      </li>
    @endforeach
  </ul>  
</div>
