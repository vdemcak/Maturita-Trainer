<div x-data="{ answers: {} }" class="flex flex-col gap-y-4">
    <input
        type="string"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5"
        placeholder="Tvoja odpoveď"
        x-model="answers['{{ $q }}']">

    <button
        class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5"
        wire:click="submitAnswer(answers['{{ $q }}'] ?? '')">
        Odoslať
    </button>
</div>
