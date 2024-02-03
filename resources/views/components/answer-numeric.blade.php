<div class="flex flex-col gap-y-4">
    <input
        type="string"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 disabled:opacity-50"
        placeholder="Tvoja odpoveď"
        x-model="answers['{{ $q }}']"
        @if($questions[$q]['is_correct'] === true)
            disabled
        @endif
    >

    <button
        class="text-white bg-blue-500 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 disabled:opacity-50 disabled:hover:bg-blue-500"
        wire:click="submitAnswer(answers['{{ $q }}'] ?? '')"
        @if($questions[$q]['is_correct'] === true)
            disabled
        @endif
    >
        Odoslať
    </button>
</div>
