<?php

$test_case_valid = '[8+{4/[(a+b)/3]*4}(a+b)]';
$test_case_invalid1 = '{[()]}()]';
$test_case_invalid2 = '][{[()]}(';
$test_case_invalid3 = '[{[()]}(';
$test_case_invalid4 = '[([) ';

class Validator
{
    const VALID = 'Верно';
    const INVALID = 'Не верно';


    function validate_brackets($str) {
        $stack = [];

        $brackets = [
            ')' => '(',
            '}' => '{',
            ']' => '['
        ];

        $closingBrackets = array_keys($brackets);
        $openingBrackets = array_values($brackets);

        $bracketsOnly = preg_replace('/[^(){}\[\]]/', '', $str);

        // TODO check if empty string is valid or not
        if (empty($bracketsOnly)) {
            return self::VALID;
        }

        if (strlen($bracketsOnly) % 2 !== 0) {
            return self::INVALID;
        }

        if (in_array($bracketsOnly[0], $closingBrackets) || in_array($bracketsOnly[strlen($bracketsOnly) - 1], $openingBrackets)) {
            return self::INVALID;
        }

        for ($i = 0; $i < strlen($bracketsOnly); $i++) {
            $char = $bracketsOnly[$i];

            if (in_array($char, $openingBrackets)) {
                $stack[] = $char;
            }

            if (in_array($char, $closingBrackets)) {
                if (empty($stack) || array_pop($stack) != $brackets[$char]) {
                    return self::INVALID;
                }
            }
        }

        return empty($stack) ? self::VALID : self::INVALID;
    }
}

$validator = new Validator();

echo $validator->validate_brackets($test_case_valid) . PHP_EOL;
echo $validator->validate_brackets($test_case_invalid1) . PHP_EOL;
echo $validator->validate_brackets($test_case_invalid2) . PHP_EOL;
echo $validator->validate_brackets($test_case_invalid3) . PHP_EOL;
echo $validator->validate_brackets($test_case_invalid4) . PHP_EOL;
