<?php

namespace CMP;

use \CMP\Command\CommandCollection;
use \CMP\Command\Command;
use \CMP\ConsoleOutput\Formatter;

use \Exception;

class Console {
   
   private $commands;
   private $formatter;

   public function __construct() {
      $this->commands = new CommandCollection();
      $this->formatter = new Formatter(TRUE);
   }

   public function register($name, Command $command) {
      $this->commands->add($name, $command);
   }

   public function alias($name, $alias) {
      $this->commands->alias($name, $alias);
   }

   public function run() {
      
      $command = $this->getCommand();
      
      if (is_null($command)) return FALSE;

      $optcll = $command->getOptionCollection();

      $opts = $optcll->dump();

      $args = getopt($opts['options'], $opts['longopts']);

      return $command->execute($this, $args);
      
   }

   public function write($text, $color = NULL, $nl = FALSE) {
      $text = $this->formatter->format($text);
      echo $text.($nl?PHP_EOL:'');
   }

   public function writeln($text, $color = NULL) {
      $this->write($text, $color, TRUE);
   }

   public function read($text = '') {
      $line = readline($text);
      readline_add_history($line);

      return $line;
   }

   private function getCommand() {
      $args = getopt('c:');
      
      if (empty($args) || empty($args['c']))
         throw new Exception('Invalid Command');
   
      $command = $this->commands->get($args['c']);

      if (is_null($command))
         throw new Exception('Command not found');

      return $command;
   }

}