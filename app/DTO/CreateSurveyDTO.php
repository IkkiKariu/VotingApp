<?php

namespace App\DTO;

class CreateSurveyDTO
{
    public $title;

    public $content;

    public bool $hasMultipleChoice;

    public array $decisions;

    
    public function __construct($title, $content, $hasMultipleChoice, $decisions)
    {
        $this->title = $title;
        $this->content = $content;
        $this->hasMultipleChoice = $hasMultipleChoice;
        $this->decisions = $decisions;
    }
}

?>