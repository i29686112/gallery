<?php


if ( ! function_exists('exceptionToString'))
{
    function exceptionToString(\Exception $e)
    {
        return $e->getMessage() . " at [" . $e->getFile() . ":" . $e->getLine() . "]";
    }

}
