<?php

if (! function_exists('dd')) {

    /**
     * Non-essential dd function to debug variables.
     *
     * @param mixed   $var The variable to be output
     */
    function dd($var)
    {
        // echo '<code>';
        var_dump($var);
        // echo '</code>';
        die();
    }
}
