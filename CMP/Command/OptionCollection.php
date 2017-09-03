<?php

namespace CMP\Command;

use \CMP\Command\Option;

class OptionCollection {
   private $options = [];

   public function add($option, $description) {
      $p = $this->parseOption($option);
      $o = new Option;
      
      $o->short = $p['short'];

      if ($o->short == 'c')
         throw new Exception('The option "c" is reserved, you can\'t use.');

      $o->name = $p['name'];
      $o->hasValue = $p['hasValue'];
      $o->description = $description;
      $o->optional = $p['optional'];
      $this->options[] = $o;
   }

   private function parseOption($option) {
      $pieces = explode('|', $option);
      
      return [
         'short' => $pieces[0],
         'name' => str_replace(':', '', $pieces[1]),
         'hasValue' => (strpos($option, ':') > -1),
         'optional' => (strpos($option, '?') > -1)
      ];
   }

   public function _dump() {
         $params = [];
         $options = [];
         /**
          * -h --help     Show this screen.
          * --version     Show version.
          * --prod        Build prod
          * 
          */
         foreach($this->options as $option) {
            if ($option->hasValue)
               $params[] = '';
            
            // options
   
            $short .= $option->short . ($option->hasValue ? ':' : '');
            $long[] = $option->name . ($option->hasValue ? ':' : '');
         }
   
         return [
            'options' => $short,
            'longopts' => $long
         ];
   }

   public function dump() {
      $short = 'c:';
      $long = ['command'];
      foreach($this->options as $option) {
         $short .= $option->short . ($option->hasValue ? ':' : '');
         $long[] = $option->name . ($option->hasValue ? ':' : '');
      }

      return [
         'options' => $short,
         'longopts' => $long
      ];
   }
}