<?php

/**
 * Represents a question from a quiz
 */
class Question
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
     * Question rank in associated quiz
     * @var int
     */
    private int $order;
    /**
     * Right answer database ID
     * @var int|null
     */
    private ?int $rightAnswerId;
    
    /**
     * Create new question
     *
     * @param integer|null $id Database ID
     * @param string $text Text to display
     * @param integer $order Question rank in associated quiz
     * @param integer|null $rightAnswerId Right answer database ID
     */
    public function __construct(?int $id = null, string $text = '', int $order = 0, ?int $rightAnswerId = null)
    {
        $this->id = $id;
        $this->text = $text;
        $this->order = $order;
        $this->rightAnswerId = $rightAnswerId;
    }

    /**
     * 
     * Fetch All question from databas
     * 
     * @return array
     */
    public static function find(): array 
    {
        return Database::getInstance()->fetchAllTable('question', Question::class);
    }

    /**
     * Fetch question from database based on ID
     *
     * @param integer $id ID of the resource to fetch
     * @return Question|null
     */
    public static function findById(int $id): ?Question
    {
        return Database::getInstance()->fetchFromTableById('question', Question::class, $id);
    }
    
    /**
     * Fetch questions from database based on criteria
     *
     * @param array $criteria Criteria to be satisfied as collection of key/values
     * @return array
     */
    public static function findWhere(array $criteria): array
    {
        return Database::getInstance()->fetchFromTableWhere('question', Question::class, $criteria);
    }

    public function save(): void
    {
        // Si l'ID de l'objet est nul, c'est donc qu'il n'existe pas encore en BDD
        if (is_null($this->id)) {
            // Crée un enregistrement à partir des propriétés de l'objet en BDD
            $this->insert();
        // Sinon, c'est qu'il existe déjà en BDD
        } else {
            // Met à jour l'enregistrement existant en BDD par rapport aux propriétés de l'objet
            $this->update();
        }
    }
    
    private function insert(): void
    {
        $this->id = Database::getInstance()->insertIntoTable('question', [
            'text' => $this->text,
            'order' => $this->order,
        ]);
    }

    private function update(): void
    {
        Database::getInstance()->updateTable('question', $this->id, [
            'text' => $this->text,
            'order' => $this->order,
        ]);
    }

    public function delete(): void
    {
        Database::getInstance()->deleteFromTable('question', $this->id);
    }

    /**
     * Get database ID
     *
     * @return  int|null
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
     * Get question rank in associated quiz
     *
     * @return  int
     */ 
    public function getOrder()
    {
        return $this->order;
    }
    
    /**
     * Set question rank in associated quiz
     *
     * @param  int  $order  Question rank in associated quiz
     *
     * @return  self
     */ 
    public function setOrder(int $order)
    {
        $this->order = $order;
        
        return $this;
    }
    
    /**
     * Get right answer database ID
     *
     * @return  int|null
     */ 
    public function getRightAnswerId()
    {
        return $this->rightAnswerId;
    }
    
    /**
     * Set right answer database ID
     *
     * @param  int|null  $rightAnswerId  Right answer database ID
     *
     * @return  self
     */ 
    public function setRightAnswerId($rightAnswerId)
    {
        $this->rightAnswerId = $rightAnswerId;
        
        return $this;
    }
}