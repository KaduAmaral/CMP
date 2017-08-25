<?php
namespace tests;

use \CMP\Command;
use \CMP\Console;
use \CMP\ConsoleUtils;

class HelloWorldCommand extends Command {

   public function execute(Console $console, $args = []) {
      $console->writeln("Hello World", ConsoleUtils::FG_BLUE);
   }

   public function getOptionCollection() {
      return new \CMP\OptionCollection;
   }

}