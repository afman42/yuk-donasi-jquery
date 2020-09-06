<?php
function bad_words($text){
    $filterWords = array('jancok','pantek','bacot','kontol','fuck','motherfucker','bitch','shit','memek','anjing');
    $filterCount = sizeof($filterWords);
    for ($i = 0; $i < $filterCount; $i++) {
        $text = preg_replace_callback('/\b' . $filterWords[$i] . '\b/i', function($matches){return str_repeat('*', strlen($matches[0]));}, $text);
    }
    return $text;
}