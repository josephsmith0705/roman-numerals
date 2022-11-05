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
    public function validStringToRomanNumeral()
    {
        $this->convertNumber('4', false, 'IV');
    }

    private function convertNumber($number, $error = false, $message = null)
    {
        $response = $this->post('/', [
            'convert_number' => $number
        ]);

        $responseContent = $response->getContent();

        $this->assertEquals(200, $response->status());
        $this->assertEquals(($error ? 1 : 0), $responseContent['error']);

        if(!empty($message))
        {
            $this->assertEquals($message, $responseContent['message']);
        }
    }
}
