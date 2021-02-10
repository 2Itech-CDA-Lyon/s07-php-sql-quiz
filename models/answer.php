<?php

class Answer
{
    /**
     * Database ID
     * @var int|null
     */
    private ?int $id;
    /**
     * Text to display
     * @var string
     */
    private string $text;
    /**
     * Related question database ID
     * @var int|null
     */
    private ?int $questionId;

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
     * Get database ID
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
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
