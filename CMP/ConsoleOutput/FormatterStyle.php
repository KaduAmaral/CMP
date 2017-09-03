<?php

namespace CMP\ConsoleOutput;

class FormatterStyle {

   private static $_styles = [
      'foregrounds' => [
         'black'     => ['set' => 30, 'unset' => 39],
         'red'       => ['set' => 31, 'unset' => 39],
         'green'     => ['set' => 32, 'unset' => 39],
         'yellow'    => ['set' => 33, 'unset' => 39],
         'blue'      => ['set' => 34, 'unset' => 39],
         'magenta'   => ['set' => 35, 'unset' => 39],
         'cyan'      => ['set' => 36, 'unset' => 39],
         'white'     => ['set' => 37, 'unset' => 39],
         'default'   => ['set' => 39, 'unset' => 39]
      ],
      'backgrounds' => [
         'black'     => ['set' => 40, 'unset' => 49],
         'red'       => ['set' => 41, 'unset' => 49],
         'green'     => ['set' => 42, 'unset' => 49],
         'yellow'    => ['set' => 43, 'unset' => 49],
         'blue'      => ['set' => 44, 'unset' => 49],
         'magenta'   => ['set' => 45, 'unset' => 49],
         'cyan'      => ['set' => 46, 'unset' => 49],
         'white'     => ['set' => 47, 'unset' => 49],
         'default'   => ['set' => 49, 'unset' => 49]
      ],
      'styles' => [
         'bold'         => ['set' => 1, 'unset' => 22],
         'underscore'   => ['set' => 4, 'unset' => 24],
         'blink'        => ['set' => 5, 'unset' => 25],
         'reverse'      => ['set' => 7, 'unset' => 27],
         'conceal'      => ['set' => 8, 'unset' => 28],
      ]
   ];

   private $foreground;
   private $background;
   private $styles = [];

   public function __construct($foreground = null, $background = null, array $options = array()) {
       if (null !== $foreground) {
           $this->setForeground($foreground);
       }
       if (null !== $background) {
           $this->setBackground($background);
       }
       if (count($options)) {
           $this->setOptions($options);
       }
   }

   public function setForeground($color = null) {

      if (null === $color) {
           $this->foreground = null;
           return;
       }

       if (!$this->hasStyle('foregrounds', $color)) {
           throw new \InvalidArgumentException(sprintf(
               'Invalid foreground color specified: "%s". Expected one of (%s)',
               $color,
               implode(', ', array_keys(static::$_styles['foregrounds']))
           ));
       }
       $this->foreground = static::$_styles['foregrounds'][$color];
   }

   public function setBackground($color = null) {
       if (null === $color) {
           $this->background = null;
           return;
       }
       if (!$this->hasStyle('backgrounds', $color)) {
           throw new InvalidArgumentException(sprintf(
               'Invalid background color specified: "%s". Expected one of (%s)',
               $color,
               implode(', ', array_keys(static::$_styles['backgrounds']))
           ));
       }
       $this->background = static::$_styles['backgrounds'][$color];
   }

   public function setOption($option) {
       if (!$this->hasStyle('styles', $option)) {
           throw new InvalidArgumentException(sprintf(
               'Invalid option specified: "%s". Expected one of (%s)',
               $option,
               implode(', ', array_keys(static::$_styles['styles']))
           ));
       }
       if (!in_array(static::$_styles['styles'][$option], $this->styles)) {
           $this->styles[] = static::$_styles['styles'][$option];
       }
   }

   public function setOptions(array $options) {
       $this->styles = array();
       foreach ($options as $option) {
           $this->setOption($option);
       }
   }

   public function apply($text) {
       $setCodes = array();
       $unsetCodes = array();
       if (null !== $this->foreground) {
           $setCodes[] = $this->foreground['set'];
           $unsetCodes[] = $this->foreground['unset'];
       }
       if (null !== $this->background) {
           $setCodes[] = $this->background['set'];
           $unsetCodes[] = $this->background['unset'];
       }
       if (count($this->styles)) {
           foreach ($this->styles as $style) {
               $setCodes[] = $style['set'];
               $unsetCodes[] = $style['unset'];
           }
       }
       if (0 === count($setCodes)   ) {
           return $text;
       }
       return sprintf("\033[%sm%s\033[%sm", implode(';', $setCodes), $text, implode(';', $unsetCodes));
   }

   private function hasStyle($group, $style) {
      return isset(static::$_styles[$group]) && isset(static::$_styles[$group][$style]);
   }

   private static function canColorize() {
      return strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN';
   }

}