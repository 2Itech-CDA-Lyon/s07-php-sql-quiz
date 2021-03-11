<?php

namespace App\Models;

use App\Models\AbstractModel;

class User extends AbstractModel
{
    /**
     * Email address
     * @var string
     */
    protected string $email;
    /**
     * Password
     * @var string
     */
    protected string $password;

    /**
     * Create new user
     *
     * @param integer|null $id Database ID
     * @param string $email Email address
     * @param string $password Password
     */
    public function __construct(?int $id = null, string $email = '', string $password = '')
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Get the name of the table associated with the model
     *
     * @return string
     * @static
     */
    static public function getTableName(): string
    {
        return 'user';
    }

    /**
     * Get an array of all object's properties
     *
     * @return array
     */
    public function getProperties(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    /**
     * Get email address
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email address
     *
     * @param  string  $email  Email address
     *
     * @return  self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get password
     *
     * @return  string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param  string  $password  Password
     *
     * @return  self
     */ 
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }
}
