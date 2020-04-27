<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;

class dataManipulator extends Controller
 {
// Convert db array to normal kv-array
    static public function objArrToAssoc(Collection $object)
    {
        $output = array();
        foreach ($object as $element) {
            $output[$element['key']] = $element['value'];
        }
        return $output;
    }
}

