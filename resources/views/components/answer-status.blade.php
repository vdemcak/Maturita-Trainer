@if ($questions[$q]['is_correct'] === true)
    <span
        class="py-2.5 px-5 text-sm text-center font-medium text-green-600 bg-green-200 rounded-lg border border-green-400">
        Správne!
    </span>
@endif

@if ($questions[$q]['is_correct'] === false)
    <div class="p-4 text-red-800 border border-red-300 rounded-lg bg-red-50" x-data="{ revealed: false }">
        <div class="flex items-center">
            <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <h3 class="text-lg font-medium">Tvoja odpoveď je nesprávna!</h3>
        </div>
        <div class="mt-2 mb-4 text-sm">
            Správna odpoveď je:
            <span
                class="font-bold transition-all duration-300 ease-in-out"
                :class="revealed ? '' : 'blur-sm select-none'">
                {{ $questions[$q]['answer'] }}
            </span>.
            Ak chceš, tak si môžes pozrieť video vysvetlujúce túto úlohu alebo môžes odhaliť rozostretú odpoveď.
        </div>
        <div class="flex">
            <a href="{{ $questions[$q]['explanation'] }}"
               target="_blank"
               class="text-white bg-red-800 hover:bg-red-900 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center">
                Vysvetlenie
            </a>
            <button @click="revealed = !revealed"
                    class="text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white font-medium rounded-lg text-xs px-3 py-1.5 text-center inline-flex items-center">
                <svg class="me-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                     viewBox="0 0 20 14">
                    <path
                        d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>
                </svg>
                Odhaliť odpoveď
            </button>
        </div>
    </div>
@endif
