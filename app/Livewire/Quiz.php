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

    // Filenames of the questions in the current quiz
    public array $questions;

    // The year and subject of the current quiz
    public string $year;
    public string $subject;

    // Whether the answer is correct or not
    public $is_correct = null;

    // The correct answer to the question - gets sent to the front end if the answer is incorrect
    public $correct_answer = null;

    private function getQuestionMarkdown(string $question): RenderedContentInterface
    {
        $config = [];
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new FrontMatterExtension());
        $converter = new MarkdownConverter($environment);

        return $converter->convert(Storage::disk('questions')->get($this->year . '/' . $this->subject . '/' . $question . '.md'));
    }

    public function changeQuestion(string $question): void
    {
        $this->q = $question;
        $this->is_correct = null;
        $this->correct_answer = null;
    }

    public function submitAnswer(string $answer): void
    {
        $question_markdown = $this->getQuestionMarkdown($this->q);
        $answer = str_replace('.', ',', trim($answer));

        $this->is_correct = $question_markdown->getFrontMatter()['answer'] == $answer;

        if ($question_markdown->getFrontMatter()['answer_type'] == 'multiple_choice') {
            $this->correct_answer = $question_markdown->getFrontMatter()['choices'][$question_markdown->getFrontMatter()['answer']];
        }
        if ($question_markdown->getFrontMatter()['answer_type'] == 'numeric') {
            $this->correct_answer = $question_markdown->getFrontMatter()['answer'];
        }

        if ($this->is_correct) {
            $this->questions[$this->q] = true;
            $this->dispatch('answer-correct');
        } else {
            $this->questions[$this->q] = false;
        }
    }

    public function mount(string $year, string $subject): void
    {
        $question_files = Storage::disk('questions')->files($year . '/' . $subject);

        foreach ($question_files as $question_file) {
            $this->questions[explode('.', explode('/', $question_file)[2])[0]] = null;
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
