<?php
/**
 * Pre the array
 *
 *@param mixed $array
 *@param int $exit
 *@return void
 */
function pre($array, $exit = 0)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
    if ($exit == 1) exit();
}

/**
 * Convert array to string
 * 
 * @param mixed $var
 * @return void
 */
function encode($var)
{
    echo json_encode($var);
}