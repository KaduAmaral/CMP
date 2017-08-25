<?php

namespace CMP;

use \CMP\CommandCollection;
use \CMP\Command;
use \CMP\ConsoleUtils;

use \Exception;

class Console {
   
   private $commands;

   public function __construct() {
      $this->commands = new CommandCollection();
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

      $opts = $command->getOptionCollection();

      $args = $opts->dump();

      if (!empty($args['c']))
         unset($args['c']);

      if (!empty($args['command']))
         unset($args['command']);

      return $command->execute($this, $args);
      
   }

   public function write($text, $color = NULL) {
      echo !is_null($color) ? ConsoleUtils::setColor($text, $color) : $text;
   }

   public function writeln($text, $color = NULL) {
      $this->write($text.PHP_EOL, $color);
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