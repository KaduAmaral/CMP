<?php
namespace tests;

use \CMP\Command\Command;
use \CMP\Console;
use \CMP\ConsoleOutput\FormatterStyle;

class HelloWorldCommand extends Command {

   public function execute(Console $console, $args = []) {
      $console->writeln("<red>Hellow {$args['--who']}</red>");
   }

   public function getOptionCollection() {
      $cl = new \CMP\Command\OptionCollection;

      $cl->add('w|who:?', 'Quem receberá o Olá?', 'World');

      return $cl;
   }

}