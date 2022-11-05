<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConverterController extends Controller
{
    public function __construct()
    {
        $this->numerals = [
            1    => 'I',
            5    => 'V',
            10   => 'X',
            50   => 'L',
            100  => 'C',
            500  => 'D',
            1000 => 'M'
        ];
    }

    public function show()
    {
        return view('home.index');
    }

    public function convert(Request $request)
    {
        $request->validate([
            'convert_number' => 'required'
        ]);

        $message = $this->convertNumberToRomanNumeral(intVal($request->convert_number));

        return view('home.index', ['message' => $message]);
    }

    private function convertNumberToRomanNumeral($originalNumber)
    {
        $currentNumber = null;
        $remainder     = $originalNumber;

        while($remainder != 0)
        {
                $positive       = $remainder > 0 ? true : false;

                $closestKey     = $this->findClosestKey(abs($remainder), $this->numerals);
                $closestNumeral = $this->numerals[$closestKey];
                $currentNumber  = ($remainder < 0) ? ($closestNumeral . $currentNumber) : ($currentNumber . $closestNumeral);
                $remainder      = $positive ? $remainder - $closestKey : $remainder + $closestKey;
        }

        return $currentNumber;
    }

    private function findClosestKey($search, $array)
    {
        $closestKey = null;

        foreach($array AS $key => $element)
        {
            if($closestKey === null || abs($search - $closestKey) > abs($key - $search))
            {
                $closestKey = $key;
            }
        }

        return $closestKey;
    }
}
