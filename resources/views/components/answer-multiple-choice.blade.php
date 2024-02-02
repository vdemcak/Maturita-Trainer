@foreach($choices as $choice)
    <button
        wire:click="submitAnswer('{{ $loop->index }}')"
        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700">
        {{$choice}}
    </button>
@endforeach
