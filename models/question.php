<?php

class Question{

  private ?int $id;
  private string $text;
  private int $order;
  private ?int $rightAnswerId;

  public function __construct(?int $id = null, string $text = '', int $order = 0, ?int $rightAnswerId = null) {
    $this->id = $id;
    $this->text = $text;
    $this->order = $order;
    $this->rightAnswerId = $rightAnswerId;
  }

  /**
   * Get the value of text
   */ 
  public function getText()
  {
    return $this->text;
  }

  /**
   * Set the value of text
   *
   * @return  self
   */ 
  public function setText($text)
  {
    $this->text = $text;

    return $this;
  }

  /**
   * Get the value of order
   */ 
  public function getOrder()
  {
    return $this->order;
  }

  /**
   * Set the value of order
   *
   * @return  self
   */ 
  public function setOrder($order)
  {
    $this->order = $order;

    return $this;
  }

  /**
   * Get the value of id
   */ 
  public function getId()
  {
    return $this->id;
  }

  /**
   * Get the value of rightAnswerId
   */ 
  public function getRightAnswerId()
  {
    return $this->rightAnswerId;
  }
}