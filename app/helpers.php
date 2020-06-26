<?php

function imploadValue($types){
    $strTypes = implode(",", $types);
    return $strTypes;
}

function explodeValue($types){
    $strTypes = explode(",", $types);
    return $strTypes;
}

function random_code(){

    return rand(1111, 9999);
}

function remove_special_char($text) {

    $t = $text;

    $specChars = array(
        ' ' => '-',    '!' => '',    '"' => '',
        '#' => '',    '$' => '',    '%' => '',
        '&amp;' => '',    '\'' => '',   '(' => '',
        ')' => '',    '*' => '',    '+' => '',
        ',' => '',    '₹' => '',    '.' => '',
        '/-' => '',    ':' => '',    ';' => '',
        '<' => '',    '=' => '',    '>' => '',
        '?' => '',    '@' => '',    '[' => '',
        '\\' => '',   ']' => '',    '^' => '',
        '_' => '',    '`' => '',    '{' => '',
        '|' => '',    '}' => '',    '~' => '',
        '-----' => '-',    '----' => '-',    '---' => '-',
        '/' => '',    '--' => '-',   '/_' => '-',

    );

    foreach ($specChars as $k => $v) {
        $t = str_replace($k, $v, $t);
    }

    return $t;
}

function getprefix($code,$size=5)
    {
        $string =   substr($code,0,$size);
        preg_match('/[^0-9]*/i',$string,$match);
        return $match[0];
    }
