import {Livewire} from '../../vendor/livewire/livewire/dist/livewire.esm';
import renderMathInElement from "katex/contrib/auto-render";
import JSConfetti from 'js-confetti'

const jsConfetti = new JSConfetti()

function renderMath() {
    renderMathInElement(document.body, {
        delimiters: [
            {left: '$$', right: '$$', display: true},
            {left: '$', right: '$', display: false},
            {left: '\\(', right: '\\)', display: false},
            {left: '\\[', right: '\\]', display: true}
        ],
        throwOnError: false,
    });
}


Livewire.hook('morph.updating', renderMath);
Livewire.hook('morph.updated', renderMath);
Livewire.hook('morph.added', renderMath);
Livewire.on('answer-correct', () => {
    jsConfetti.addConfetti()
});

document.addEventListener("DOMContentLoaded", renderMath);

Livewire.start()

