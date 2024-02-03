<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Output\RenderedContentInterface;
use Livewire\Attributes\Url;
use Livewire\Component;

class Quiz extends Component
{
    // The current question - synced with the URL
    #[Url(keep: true)]
    public string $q = '01';

    public array $questions;

    // The year and subject of the current quiz
    public string $year;
    public string $subject;

    private function getQuestionMarkdown(string $question): RenderedContentInterface
    {
        $config = [];
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new FrontMatterExtension());
        $converter = new MarkdownConverter($environment);

        if (!Storage::disk('questions')->exists($this->year . '/' . $this->subject . '/' . $question . '.md')) {
            abort(404, 'No question found for ' . $this->year . '/' . $this->subject . '/' . $question);
        }

        return $converter->convert(Storage::disk('questions')->get($this->year . '/' . $this->subject . '/' . $question . '.md'));
    }

    public function changeQuestion(string $question): void
    {
        $this->q = $question;
    }

    public function submitAnswer(string $answer): void
    {
        $question_markdown = $this->getQuestionMarkdown($this->q);

        $user_answer = str_replace('.', ',', trim($answer));
        $correct_answer = $question_markdown->getFrontMatter()['answer'];

        $this->questions[$this->q]['is_correct'] = $user_answer == $correct_answer;

        // If the answer type is multiple_choice, we need to convert the correct answer from an index to the actual answer
        if ($question_markdown->getFrontMatter()['answer_type'] === 'multiple_choice') {
            $correct_answer = $question_markdown->getFrontMatter()['choices'][$correct_answer];
        }

        $this->questions[$this->q]['answer'] = $correct_answer;

        if ($this->questions[$this->q]['is_correct']) {
            $this->dispatch('answer-correct');
        } else {
            $this->questions[$this->q]['explanation'] = $question_markdown->getFrontMatter()['explanation'] ?? null;
        }
    }

    public function mount(string $year, string $subject): void
    {
        $question_files = Storage::disk('questions')->files($year . '/' . $subject);

        foreach ($question_files as $question_file) {
            $this->questions[explode('.', explode('/', $question_file)[2])[0]] = [
                'is_correct' => null,
                'answer' => null,
            ];
        }

        $this->year = $year;
        $this->subject = $subject;
    }

    public function render()
    {
        $question_markdown = $this->getQuestionMarkdown($this->q);

        return view('livewire.quiz', [
            'id' => $question_markdown->getFrontMatter()['id'],
            'answer_type' => $question_markdown->getFrontMatter()['answer_type'],
            'choices' => $question_markdown->getFrontMatter()['choices'] ?? null,
            'attachment' => $question_markdown->getFrontMatter()['attachment'] ?? null,
            'question_markdown' => $question_markdown->getContent(),
        ]);
    }
}
