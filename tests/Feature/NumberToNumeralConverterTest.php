<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NumberToNumeralConverterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function validNumberToRomanNumeral()
    {
        $this->convertNumber(1, false, 'I');
    }

    /** @test */
    public function validStringToRomanNumeral()
    {
        $this->convertNumber('4', false, 'IV');
    }

    /** @test */
    public function invalidNumberToRomanNumeral()
    {
        $this->convertNumber(0, true);
    }

    /** @test */
    public function invalidTypeToRomanNumeral()
    {
        $this->convertNumber('test', true);
    }

    /** @test */
    public function invalidEmptyNumberToRomanNumeral()
    {
        $this->convertNumber('', true);
    }

    private function convertNumber($number, $error = false, $message = null)
    {
        $response = $this->post('/', [
            'convert_number' => $number
        ]);

        if($error)
        {
            $response->assertSessionHasErrors([
                'convert_number'
            ]);
        }
        else
        {
            $this->assertEquals($message, $response['message']);
        }
    }
}
