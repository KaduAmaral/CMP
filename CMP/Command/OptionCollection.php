<?php

namespace CMP\Command;

use \CMP\Command\Option;

class OptionCollection {
   private $options = [];

   public function add($option, $description, $default = NULL) {
      $p = $this->parseOption($option);
      $o = new Option;
      
      $o->short = $p['short'];

      if ($o->short == 'c')
         throw new Exception('The option "c" is reserved, you can\'t use.');

      $o->name = $p['name'];
      $o->hasValue = $p['hasValue'];
      if ($o->hasValue) $o->defaultValue = $default;
      $o->description = $description;
      $o->optional = $p['optional'];
      
      $this->options[] = $o;
   }

   private function parseOption($option) {
      $pieces = explode('|', $option);
      
      return [
         'short' => $pieces[0],
         'name' => str_replace([':', '?'], '', $pieces[1]),
         'hasValue' => (strpos($option, ':') > -1),
         'optional' => (strpos($option, '?') > -1)
      ];
   }

   public function buildCommand() {
      $cmd = '';
      foreach($this->options as $option) {
         if ($option->optional) $cmd .= '[';
         $cmd .= " --{$option->name}";
         if ($option->hasValue)
         $cmd .= "=<{$option->short}v>";
         if ($option->optional) $cmd .= '] ';
      }
      return $cmd;
   }

   private function buildOption(Option $option) {
      $alias = '-'.$option->short;
      $name = '--'.$option->name;
      $description = $option->description;

      if ($option->hasValue) {
         $valk = "{$option->short}v";
         $alias .= "=<{$valk}>";
         $name .= "=<{$valk}>";

         if (!is_null($option->defaultValue))
            $description .= " [default: {$option->defaultValue}]";
      }

      return [
         'colunm1' => "$alias $name ",
         'colunm2' => $description,
         'c1len' => strlen($alias) + strlen($name) + 1
      ];
   }

   public function dumpOptions() {
         $options = [];
         /*
           -h --help     Show this screen.
           --version     Show version.
           --prod        Build prod
            --speed=<kn>  Speed in knots [default: 10].
           
          */
         $fcs = 0;
         foreach($this->options as $option) {
            $o = $this->buildOption($option);
            $options[] = $o;
            if ($o['c1len']>$fcs) $fcs = $o['c1len'];
         }

         $fcs += 3;

         $lines = [];
         foreach ($options as $option) {
            $lines[] = $o['colunm1'] . str_repeat(' ', $fcs - $o['c1len']) . $o['colunm2'] . PHP_EOL;
         }
   
         return $lines;
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