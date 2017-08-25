<?php

namespace CMP;

use \CMP\Command;

class CommandCollection {
   private $list = [];
   private $alias = [];

   public function add($name, Command $command) {
      $this->list[$name] = $command;
   }

   public function alias($name, $alias) {
      $this->alias[$alias] = $name;
   }

   public function get($name) {
      if (isset($this->list[$name]))
         return $this->list[$name];
      else if (isset($this->alias[$name]) && isset($this->list[$this->alias[$name]]))
         return $this->list[$this->alias[$name]];
      else
         return NULL;
   }
}