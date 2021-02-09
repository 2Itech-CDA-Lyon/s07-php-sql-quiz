<?php

class Answer{
    private string $text;
    private int $id;
    private int $questionId;

    function __construct(string $text, int $id, int $questionId){
        $this->text   = $text; 
        $this->id        = $id;
        $this->questionId= $questionId;
    } 

    function getText(){
        return $this->text;
    }

    function getid(){
        return $this->id;
    }

    function getQuestionId(){
        return $this->questionId;
    }

    function setText($text){
        $this->text = $text;
    }

    function setId($id){
        $this->id = $id;
    }

    function setQuestionId($questionId){
        $this->questionId = $questionId;
    }

}

?>