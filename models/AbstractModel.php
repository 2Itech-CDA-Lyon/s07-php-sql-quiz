<?php

abstract class AbstractModel
{
    /**
     * Database ID
     * @var int|null
     */
    protected ?int $id;

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
     * Fetch models from database based on criteria
     *
     * @param array $criteria Criteria to be satisfied as collection of key/values
     * @return array
     */
    public static function findWhere(array $criteria): array
    {
        return Database::getInstance()->fetchFromTableWhere(static::class, $criteria);
    }

    public function delete(): void
    {
        Database::getInstance()->deleteFromTable(static::class, $this->id);
    }
}
