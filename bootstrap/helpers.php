<?php
function parse_csv($csv_str)
{
    $csv_arr = explode("\n", $csv_str);
    $data_arr = array();
    $first_line = true;

    // Remove Hidden Chars From String
    $keys = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $csv_arr[0]);

    $keys = str_getcsv($keys, ",", '"');

    foreach ($csv_arr as $row) {
        if (strlen($row) > 1) {
            if (!$first_line) {
                array_push($data_arr, array_combine($keys, str_getcsv($row, ",", '"')));
            }
            $first_line = false;
        }
    }
    return $data_arr;
}

function sortArrayOfObjects($arr, $key, $order = 'asc')
{
    usort($arr, function ($a, $b) use ($key, $order) {
        $a_val = $a[$key];
        $b_val = $b[$key];
        if ($order === 'desc') {
            return $b_val <=> $a_val;
        } else {
            return $a_val <=> $b_val;
        }
    });
    return $arr;
}
