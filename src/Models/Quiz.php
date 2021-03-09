<?php

namespace App\Models;

use App\Models\AbstractModel;

class Quiz extends AbstractModel
{
    protected $title;
    protected $description;
    protected $difficulty;

    public function __construct(?int $id, string $title, string $description, int $difficulty)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->difficulty = $difficulty;
    }

    static public function getTableName(): string
    {
        return 'quiz';
    }

    public function getProperties(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'difficulty' => $this->difficulty,
        ];
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of difficulty
     */ 
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set the value of difficulty
     *
     * @return  self
     */ 
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }
}
