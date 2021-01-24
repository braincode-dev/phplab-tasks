<?php
/**
 * The $input variable contains an array of digits
 * Return an array which will contain the same digits but repetitive by its value
 * without changing the order.
 * Example: [1,3,2] => [1,3,3,3,2,2]
 *
 * @param  array  $input
 * @return array
 */
function repeatArrayValues(array $input)
{
    $arr = [];
    foreach($input as $item){
        for($i = 1; $i <= $item; $i++){
            $arr[] = $item;
        }
    }
    return $arr;
}

/**
 * The $input variable contains an array of digits
 * Return the lowest unique value or 0 if there is no unique values or array is empty.
 * Example: [1, 2, 3, 2, 1, 5, 6] => 3
 *
 * @param  array  $input
 * @return int
 */
function getUniqueValue(array $input)
{
    if(!is_array($input) || empty($input)){
        return 0;
    }

    $count = array_count_values($input);
    $uniqueNum = array_keys($count, 1);

    if(!empty($uniqueNum)){
        $minNum = min($uniqueNum);
        return (int)$minNum;
    }else{
        return 0;
    }
}

/**
 * The $input variable contains an array of arrays
 * Each sub array has keys: name (contains strings), tags (contains array of strings)
 * Return the list of names grouped by tags
 * !!! The 'names' in returned array must be sorted ascending.
 *
 * Example:
 * [
 *  ['name' => 'potato', 'tags' => ['vegetable', 'yellow']],
 *  ['name' => 'apple', 'tags' => ['fruit', 'green']],
 *  ['name' => 'orange', 'tags' => ['fruit', 'yellow']],
 * ]
 *
 * Should be transformed into:
 * [
 *  'fruit' => ['apple', 'orange'],
 *  'green' => ['apple'],
 *  'vegetable' => ['potato'],
 *  'yellow' => ['orange', 'potato'],
 * ]
 *
 * @param  array  $input
 * @return array
 */
function groupByTag(array $input)
{
    $arrTags = [];
    foreach($input as $arrs){
        foreach($arrs['tags'] as $tag){
            if (!in_array($tag, $arrTags)) {
                $arrTags[] = $tag;
            }
        }
    }

    sort($arrTags);

    $arrTags = array_flip($arrTags);
    foreach($arrTags as $key => $tag){
        $list = [];
        foreach($input as $arrays){
            foreach($arrays['tags'] as $item){

                if($item == $key){
                    $list[] = $arrays['name'];
                }
            }
        }
        $arrTags[$key] = $list;
        sort($arrTags[$key]);
    }

    return $arrTags;
}