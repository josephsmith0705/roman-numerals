<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        if(is_numeric($request->convert_number))
        {
            $outputType = 'roman numeral';

            $request->validate([
                'convert_number' => 'required|numeric|not_in:0'
            ]);
    
            $convertedNumeral = $this->convertNumberToRomanNumeral(intVal($request->convert_number));
        }
        else
        {
            $outputType = 'modern number';

            $request->validate([
                'convert_number' => 'required|regex:/^[a-zA-Z\s]*$/'
            ]);

            $request->convert_number = strtoupper(str_replace(' ', '', $request->convert_number));

            if(!$this->checkInvalidNumeralCharacter($request->convert_number))
            {
                throw ValidationException::withMessages(['convert_number' => 'The selected convert number is invalid']);
            }

            $convertedNumeral = $this->convertNumeralToNumber($request->convert_number);
        }

        $message = $request->convert_number . ' as a ' . $outputType . ' is ' . $convertedNumeral;

        return view('home.index', ['message' => $message]);
    }

    private function checkInvalidNumeralCharacter($numeral)
    {
        $invalidCharacters     = [];
        $numeralCharacterArray = str_split($numeral);

        foreach($numeralCharacterArray as $character)
        {
            if(!in_array($character, $this->numerals))
            {
                $invalidCharacters[] = $character;
            }
        }

        return count($invalidCharacters) == 0 ? true : false;
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

    private function convertNumeralToNumber($originalNumeral)
    {
        $numeralCharacterArray = str_split($originalNumeral);

        $highestValuePosition  = $this->findHighestNumeralPosition($originalNumeral);

        $total = array_search($numeralCharacterArray[$highestValuePosition], $this->numerals);

        //Subtract numerals before the highest
        for($i = $highestValuePosition-1; $i >= 0; $i--)
        {
            $total = $total - array_search($numeralCharacterArray[$i], $this->numerals);
        }

        //Add numerals after the highest
        for($i = $highestValuePosition+1; $i<count($numeralCharacterArray); $i++)
        {
            $total = $total + array_search($numeralCharacterArray[$i], $this->numerals);
        }

        return $total;
    }

    private function findHighestNumeralPosition($searchNumeral)
    {
        $highestNumeral = null;

        foreach($this->numerals as $value => $numeral)
        {
            if(str_contains($searchNumeral, $numeral) && ($highestNumeral === null || $value > $highestNumeral))
            {
                $highestNumeral = $value;
            }
        }

        $highestValuePosition = strpos($searchNumeral, $this->numerals[$highestNumeral]);

        return $highestValuePosition;
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
