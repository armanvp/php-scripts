<?php

/**
 * Searches a row in a multidimentional array with multiple field filters
 * @param array $array Array to search
 * @param array &$result Row that matches the filter
 * @param array $filter Field and the value of the filter
 * @param boolean $binarySearch TRUE if search using binary search, FALSE if linear search
 * @return int Index of the found match in the array, -1 if no match is found
 */
function arman_array_search($array, &$result, $filter, $binarySearch = false) {

    if ($binarySearch) {

        $low = 0;
        $high = count($array) - 1;
        
        while ($low <= $high) {
            $mid = floor(($low + $high) / 2);
            $row = $array[$mid];
    
            foreach($filter as $field => $value) {
                $cmp = $value <=> $row[$field];
                if($cmp != 0) {
                    break;
                }
            }
    
            if ($cmp < 0) {
                $high = $mid - 1;
            } else if ($cmp > 0) {
                $low = $mid + 1;
            } else {
                $result = $row;
                return $mid;
            }
    
        }

    } else {

        foreach($array as $idx => $row) {
            foreach($filter as $field => $value) {
                if($row[$field] != $value) {
                    continue 2;
                }
            }
            $result = $row;
            return $idx;
        }

    }

    return -1;
}

/**
 * Sort a multidimentional array by multiple fields
 * @param array $array Array to sort
 * @param array $sortBy Field and the sort order (SORT_ASC or SORT_DESC)
 * @return array Sorted array
 */
function arman_sort($array, $sortBy) {

    foreach($sortBy as $field => $order) {
        $args[] = array_column($array, $field);
        $args[] = $order;
    }
    $args[] = &$array;

    call_user_func_array('array_multisort', $args);

    return $array;
}

/**
 * TESTS
 */
$data = [
    ['id'=>'ABC', 'cat'=>'ZZ', 'code'=>100],
    ['id'=>'DEF', 'cat'=>'CC', 'code'=>500],
    ['id'=>'DEF', 'cat'=>'AA', 'code'=>300],
    ['id'=>'DEF', 'cat'=>'BB', 'code'=>600, 'name'=>'John'],
    ['id'=>'HIJ', 'cat'=>'CC', 'code'=>200]
];

$data = zsort($data, ['id'=>SORT_ASC, 'code'=> SORT_ASC, 'cat'=>SORT_ASC]);
$result = readb($data, $row, ['id'=>'DEF', 'code'=> 301], true);
print_r(['return' => $result, 'row'=>$row]);