<?php

/**
 * Represents an answer to a question from a quiz
 */
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
     * Fetch answer from database based on ID
     *
     * @param integer $id ID of the resource to fetch
     * @return Answer|null
     */
    public static function findById(int $id): ?Answer
    {
        return Database::getInstance()->fetchFromTableById('answer', Answer::class, $id);
    }

    /**
     * Fetch answers from database based on criteria
     *
     * @param array $criteria Criteria to be satisfied as collection of key/values
     * @return array
     */
    public static function findWhere(array $criteria): array
    {
        return Database::getInstance()->fetchFromTableWhere('answer', Answer::class, $criteria);
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
