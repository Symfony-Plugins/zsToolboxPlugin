<?php

class zsTools
{
  public static function sluggify($text)
  {
    $text = trim($text);
    $text = str_replace("'", "", $text);
    $text = str_replace(" ", "_", $text);

    // Remove all non url friendly characters with the unaccent function
    $text = Doctrine_Inflector::unaccent($text);

    // Remove all none word characters
    $text = preg_replace('/\W/', ' ', $text);

    // More stripping. Replace spaces with dashes
    $text = preg_replace('/[^A-Z^a-z^0-9^\/]+/', '-',
            preg_replace('/([a-z\d])([A-Z])/', '\1_\2',
            preg_replace('/([A-Z]+)([A-Z][a-z])/', '\1_\2',
            preg_replace('/::/', '/', $text))));

    return trim($text, '-');
  }
}