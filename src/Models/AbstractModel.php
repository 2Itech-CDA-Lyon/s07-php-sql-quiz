<?php

namespace App\Models;

use App\Utils\Database;
use App\Interfaces\ActiveRecordModel;

/**
 * Abstract model featuring default implementations for any Active Record model
 */
abstract class AbstractModel implements ActiveRecordModel
{
    /**
     * Database ID
     * 
     * @var int|null
     */
    protected ?int $id;

    /**
     * Get database ID
     *
     * @return  int|null
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * Fetch all models from database
     * 
     * @return array
     */
    public static function findAll(): array 
    {
        return Database::getInstance()->fetchAllFromTable(static::class);
    }

    /**
     * Fetch model from database based on ID
     *
     * @param integer $id ID of the resource to fetch
     * @return AbstractModel|null
     */
    public static function findById(int $id): ?AbstractModel
    {
        return Database::getInstance()->fetchFromTableById(static::class, $id);
    }
    
    /**
     * Fetch collection of models from database based on criteria
     *
     * @param array $criteria Criteria to be satisfied as collection of key/values
     * @return array
     */
    public static function findWhere(array $criteria): array
    {
        return Database::getInstance()->fetchFromTableWhere(static::class, $criteria);
    }

    /**
     * Save current objet state in database
     *
     * Decides whether to create a new record or update an existing record based on ID
     * 
     * @return void
     */
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
    
    /**
     * Create new record in database
     *
     * @return void
     */
    protected function insert(): void
    {
        $this->id = Database::getInstance()->insertIntoTable($this);
    }

    /**
     * Update existing record in database
     *
     * @return void
     */
    protected function update(): void
    {
        Database::getInstance()->updateTable($this);
    }

    /**
     * Delete record associated with current object from database
     *
     * @return void
     */
    public function delete(): void
    {
        Database::getInstance()->deleteFromTable($this);
        $this->id = null;
    }
}
