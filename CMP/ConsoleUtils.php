<?php

namespace CMP;

class ConsoleUtils {
   
   // Colors
   const FG_BLACK = 30;
   const FG_RED = 31;
   const FG_GREEN = 32;
   const FG_YELLOW = 33;
   const FG_BLUE = 34;
   const FG_MAGENTA = 35;
   const FG_CYAN = 36;
   const FG_WHITE = 37;

   const BG_BLACK = 40;
   const BG_RED = 41;
   const BG_GREEN = 42;
   const BG_YELLOW = 43;
   const BG_BLUE = 44;
   const BG_MAGENTA = 45;
   const BG_CYAN = 46;
   const BG_WHITE = 47;

   const ST_OFF = 0; // All attributes off
   const ST_BOLD = 1; // Bold on
   const ST_UNDERSCORE = 4; // Underscore (on monochrome display adapter only)
   const ST_BLINK = 5; // Blink on
   const ST_REVERSE = 7; // Reverse video on
   const ST_CONCEALED = 8; // Concealed on

   public static function setColor($text, $color) {
      return self::setText($text, $color);
   }

   public static function setText($text, $foreground = 37, $style = 0, $background = 40) {
      return "\033[{$style};{$foreground};{$background}m{$text}\033[0m";
   }

}