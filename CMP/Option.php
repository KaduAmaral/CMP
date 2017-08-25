<?php

namespace CMP;

class Option {

   /**
    * String of 1 character
    *
    * @var string
    */
   public $short;

   /**
    * Option name
    *
    * @var string
    */
   public $name;

   /**
    * Description of option
    *
    * @var string
    */
   public $description;

   /**
    * This option must have value?
    *
    * @var boolean
    */
   public $hasValue;

}