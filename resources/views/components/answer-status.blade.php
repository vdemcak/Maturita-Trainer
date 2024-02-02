@if($is_correct === true)
    <span
        class="py-2.5 px-5 text-sm text-center font-medium text-green-600 bg-green-200 rounded-lg border border-green-400">
            Správne!
        </span>
@endif
@if($is_correct === false)
    <span
        class="py-2.5 px-5 text-sm text-center font-medium text-red-600 bg-red-200 rounded-lg border border-red-400">
            Nesprávne! Správna odpoveď je: {{$correct_answer}}
        </span>
@endif
