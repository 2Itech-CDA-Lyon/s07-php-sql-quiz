<?php

namespace App\Models;

use App\Models\AbstractModel;

/**
 * Represents a question from a quiz
 */
class Question extends AbstractModel
{
    /**
     * Text to display
     * @var string
     */
    protected string $text;
    /**
     * Question rank in associated quiz
     * @var int
     */
    protected int $order;
    /**
     * Right answer database ID
     * @var int|null
     */
    protected ?int $rightAnswerId;
    
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

    static public function getTableName(): string
    {
        return 'question';
    }

    public function getProperties(): array
    {
        return [
            'text' => $this->text,
            'order' => $this->order,
        ];
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