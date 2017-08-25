<?php

namespace CMP;

use \CMP\Console;


abstract class Command {

   /**
    * Method for execute the commands
    *
    * @return void
    */
   abstract public function execute(Console $console, $args = []);

   /**
    * Method for return the argument list, 
    * Must return an OptionCollection object
    *
    * @return OptionCollection
    */
   abstract public function getOptionCollection();

}