<?php
namespace tests;

use \CMP\Command\Command;
use \CMP\Console;
use \CMP\ConsoleOutput\FormatterStyle;

class HelloWorldCommand extends Command {

   public function execute(Console $console, $args = []) {
      $console->writeln("<red>Hellow Wolrd</red>");
   }

   public function getOptionCollection() {
      return new \CMP\Command\OptionCollection;
   }

}