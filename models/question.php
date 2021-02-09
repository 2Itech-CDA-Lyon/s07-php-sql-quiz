<?php

class Question{

  private int $id;
  private int $order;
  private string $text;
  private int $rightAnswerId;

  public function __construct(int $id, int $order, string $text, int $rightAnswerId){
    $this->id = $id;
    $this->order = $order;
    $this->text = $text;
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