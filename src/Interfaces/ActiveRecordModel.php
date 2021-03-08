<?php

namespace App\Interfaces;

/**
 * Ensures compatibility with all model classes
 */
interface ActiveRecordModel
{
    /**
     * Get database ID
     *
     * @return integer|null
     */
    public function getId(): ?int;

    /**
     * Get the name of the table associated with the model
     *
     * @return string
     * @static
     */
    static public function getTableName(): string;

    /**
     * Get an array of all object's properties
     *
     * @return array
     */
    public function getProperties(): array;
}
