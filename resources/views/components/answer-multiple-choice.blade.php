@foreach($choices as $choice)
    <button
        wire:click="submitAnswer('{{ $loop->index }}')"

        class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 disabled:opacity-50 disabled:hover:bg-white
        {{ $questions[$q]['is_correct'] === true && $questions[$q]['answer'] === $choice ? 'bg-green-200 text-green-600 border-green-400 hover:bg-green-200 hover:text-green-600' : '' }}"

        @if($questions[$q]['is_correct'] === true)
            disabled
        @endif
    >
        {{$choice}}
    </button>
@endforeach
