<?php

function limit_words($string, $word_limit){
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit)) . "...";
}

$config = array(
	"sitename" => "CodeTogether",
	"author" => "Tino, Tony and Hei"
);