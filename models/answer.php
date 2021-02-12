<?php

/**
 * Represents an answer to a question from a quiz
 */
class Answer extends GeneralModel
{
    const TABLE_NAME = 'answer';

    /**
     * Text to display
     * @var string
     */
    protected string $text;
    /**
     * Related question database ID
     * @var int|null
     */
    protected ?int $questionId;

    /**
     * Create new answer
     *
     * @param integer $id Database ID
     * @param string $text Text to display
     * @param integer $questionId Related question database ID
     */
    function __construct(?int $id = null, string $text = '', ?int $questionId = null)
    {
        $this->id = $id;
        $this->text = $text; 
        $this->questionId= $questionId;
    }

    /**
     * Get text to display
     *
     * @return  string
     */ 
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set text to display
     *
     * @param  string  $text  Text to display
     *
     * @return  self
     */ 
    public function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }


    /**
     * Get related question database ID
     *
     * @return  int
     */ 
    public function getQuestionId()
    {
        return $this->questionId;
    }

    /**
     * Set related question database ID
     *
     * @param  int  $questionId  Related question database ID
     *
     * @return  self
     */ 
    public function setQuestionId(int $questionId)
    {
        $this->questionId = $questionId;

        return $this;
    }
}
