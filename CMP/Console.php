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
      return $this;
   }

   public function alias($name, $alias) {
      $this->commands->alias($name, $alias);
      return $this;
   }

   public function run() {
      
      $doc = $this->commands->dump();

      $docopt = \Docopt::handle($doc);

      if (empty($docopt->args)) {
         $this->writeln('<error>Command not found</error>');
         return FALSE;
      }
      $cname = null;
      foreach($docopt->args as $arg => $val) {
         if (\strpos($arg, '-') === 0)
            continue;
         else if ($val === true) {
            $cname = $arg;
            break;
         }
      }

      if (is_null($cname)) {
         $this->writeln('<error>Command not found</error>');
         return FALSE;
      }

      $command = $this->commands->get($cname);

      if ($command instanceof Command)
         return $command->execute($this, $docopt->args);
      
      $this->writeln('<error>Command not found</error>'); 
      return FALSE;
   }

   public function write($text, $color = NULL, $nl = FALSE) {
      $text = $this->formatter->format($text);
      echo $text.($nl?PHP_EOL:'');
      return $this;
   }

   public function writeln($text, $color = NULL) {
      $this->write($text, $color, TRUE);
      return $this;
   }

   public function read($text = '') {
      $line = readline($text);
      readline_add_history($line);

      return $line;
   }

   public function getCommand($name) {
      $command = $this->commands->get($name);

      if (is_null($command))
         throw new Exception('Command not found');

      return $command;
   }

}