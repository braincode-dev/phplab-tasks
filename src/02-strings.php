<?php
/**
 * The $input variable contains text in snake case (i.e. hello_world or this_is_home_task)
 * Transform it into a camel-cased string and return (i.e. helloWorld or thisIsHomeTask)
 * @see http://xahlee.info/comp/camelCase_vs_snake_case.html
 *
 * @param  string  $input
 * @return string
 */
function snakeCaseToCamelCase(string $input)
{
    $chars = str_split($input);
    $arrNum = [];
    $newStr = [];
    foreach($chars as $key => $word){
        if($word == '_'){
            $key = $key + 1;
            $arrNum[] = $key;
        }
    }

    foreach($chars as $key => $word){
        $check = in_array($key, $arrNum);
        if($check){
            $newStr[] = mb_strtoupper($word);
        }else{
            $newStr[] = $word;
        }
    }

    $implode = implode('', $newStr);
    $doneStr = str_replace('_', '', $implode);

    return $doneStr;
}

/**
 * The $input variable contains multibyte text like 'ФЫВА олдж'
 * Mirror each word individually and return transformed text (i.e. 'АВЫФ ждло')
 * !!! do not change words order
 *
 * @param  string  $input
 * @return string
 */
function mirrorMultibyteString(string $input)
{
    $words = explode(' ', $input);
    $allWordsDone = [];
    foreach($words as $word){
        $arrWord = preg_split('//u', $word, null, PREG_SPLIT_NO_EMPTY);
        $reverseArr = array_reverse($arrWord);
        $wordRes = implode('', $reverseArr);
        $allWordsDone[] = $wordRes;
    }

    $result = implode(' ', $allWordsDone);
    return $result;
}

/**
 * My friend wants a new band name for her band.
 * She likes bands that use the formula: 'The' + a noun with the first letter capitalized.
 * However, when a noun STARTS and ENDS with the same letter,
 * she likes to repeat the noun twice and connect them together with the first and last letter,
 * combined into one word like so (WITHOUT a 'The' in front):
 * dolphin -> The Dolphin
 * alaska -> Alaskalaska
 * europe -> Europeurope
 * Implement this logic.
 *
 * @param  string  $noun
 * @return string
 */
function getBrandName(string $noun)
{
    $firstWord = $noun[0];
    $lastWord = substr($noun, -1);
    if($firstWord == $lastWord){
        $first = ucfirst($noun);
        $second = substr($noun, 1);
        $res = "{$first}{$second}";
        return $res;
    }

    $first = 'The ';
    $second = ucfirst($noun);
    $res = "{$first}{$second}";
    return $res;
}