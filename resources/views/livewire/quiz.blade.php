<div class="grid h-full w-full justify-center gap-y-8 py-12 grid-rows-[min-content_auto]">

    {{-- Question Navigator --}}
    <div class="inline-flex w-full overflow-x-auto rounded-md shadow-sm" role="group">
        @foreach($questions as $question => $state)
            <span
                wire:click="changeQuestion('{{ $question }}')"
                class="navigator-btn border
                   @if($loop->first) rounded-s-lg @elseif($loop->last) border-l-0 rounded-e-lg @else border-t border-r border-b @endif
                   @if($q == $question) navigator-btn-active @else
                       @if($state['is_correct'] === false) navigator-btn-incorrect @endif
                       @if($state['is_correct'] === true) navigator-btn-correct @endif
                   @endif">
            {{ $question }}
        </span>
        @endforeach
    </div>

    {{-- Question Section --}}
    <div class="mx-auto flex w-full max-w-2xl flex-col gap-4">
        <div class="flex items-center justify-between">
            <span class="rounded-full bg-blue-500 px-3 py-1 text-sm text-white">{{ ucfirst($subject) }}</span>
            <p class="text-sm text-gray-400">{{$id}}</p>
        </div>

        @if($attachment)
            <img
                class="mx-auto w-2/3 rounded-lg"
                src="/storage/attachments/{{$year}}/{{$subject}}/{{$q}}.png"
                alt="Question Image"
            />
        @endif

        <article class="max-w-none prose">
            {!! $question_markdown !!}
        </article>

        {{-- Answer Section--}}
        <div class="flex flex-col gap-y-4" x-data="{ answers: {} }">
            {{-- Numeric--}}
            @if($answer_type == 'numeric')
                @include('components.answer-numeric')
            @endif

            {{-- Multiple Choice--}}
            @if($answer_type == 'multiple_choice')
                @include('components.answer-multiple-choice')
            @endif

            {{-- Answer status --}}
            @include('components.answer-status')
        </div>
    </div>
</div>
