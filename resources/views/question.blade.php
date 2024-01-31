<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/contrib/auto-render.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            renderMathInElement(document.body, {
                delimiters: [
                    {left: '$$', right: '$$', display: true},
                    {left: '$', right: '$', display: false},
                    {left: '\\(', right: '\\)', display: false},
                    {left: '\\[', right: '\\]', display: true}
                ],
                throwOnError: false,
            });
        });
    </script>

    @vite('resources/css/main.css')
</head>
<body class="flex flex-col h-screen w-screen items-center py-12 gap-y-8">

{{-- Question Navigator --}}
<div class="inline-flex rounded-md shadow-sm" role="group">
    @foreach($files as $file)

        @if($loop->first)
            <a href="/otazky/2023-{{ explode('.', explode('/', $file)[1])[0] }}"
               class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-300 rounded-s-lg hover:bg-gray-900 hover:text-white">
                {{ explode('.', explode('/', $file)[1])[0] }}
            </a>
        @elseif ($loop->last)
            <a href="/otazky/2023-{{ explode('.', explode('/', $file)[1])[0] }}"
               class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-l-0 border-gray-300 rounded-e-lg hover:bg-gray-900 hover:text-white">
                {{ explode('.', explode('/', $file)[1])[0] }}
            </a>
        @else
            <a href="/otazky/2023-{{ explode('.', explode('/', $file)[1])[0] }}"
               class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-r border-b border-gray-300 hover:bg-gray-900 hover:text-white">
                {{ explode('.', explode('/', $file)[1])[0] }}
            </a>
        @endif
    @endforeach
</div>

<div class="w-full max-w-2xl mx-auto p-4 md:p-8 flex flex-col gap-4">
    <div class="w-full flex justify-between items-center">
        <span class="bg-blue-500 text-white rounded-full px-3 py-1 text-sm">Matematika</span>
        <p class="text-gray-400 text-sm">{{$id}}</p>
    </div>

    @if($attachment)
        <img
            src="/storage/{{$attachment}}"
            alt="Quiz Image"
            class="object-contain rounded-lg h-96"
        />
    @endif

    <article class="prose w-full max-w-none">
        {!! $question !!}
    </article>

    {{-- Answer Section --}}
    <div class="w-full flex flex-col gap-4">
        {{-- Numeric --}}
        @if($answer_type == 'numeric')
            <input type="text"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5"
                   placeholder="Tvoja odpoveď">

            <button
                class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Odoslať
            </button>
        @endif

        {{-- Multiple Choice --}}
        @if($answer_type == 'multiple_choice')
            @foreach($choices as $choice)
                <button
                    class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700">
                    {{$choice}}
                </button>
            @endforeach
        @endif

        {{--        <button--}}
        {{--            class="text-white bg-green-500 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">--}}
        {{--            Preskočiť--}}
        {{--        </button>--}}
    </div>
</div>


</body>


</html>
