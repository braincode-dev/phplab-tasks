<?php
/**
 * The $airports variable contains array of arrays of airports (see airports.php)
 * What can be put instead of placeholder so that function returns the unique first letter of each airport name
 * in alphabetical order
 *
 * Create a PhpUnit test (GetUniqueFirstLettersTest) which will check this behavior
 *
 * @param  array $airports
 * @return string[]
 */
function getUniqueFirstLetters(array $airports)
{
    // put your logic here

    $arrUniqueFirstLetter = [];

    foreach ($airports as $key => $airport) {
        $first = $airport['name'][0];
        if ( !in_array($first , $arrUniqueFirstLetter) ){
            $arrUniqueFirstLetter[] = $first;
        }
    }

    sort($arrUniqueFirstLetter);
    return $arrUniqueFirstLetter;
}