<?php

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
     */
    static public function getTableName(): string;

    /**
     * Get an array of all object's properties
     *
     * @return array
     */
    public function getProperties(): array;
}
