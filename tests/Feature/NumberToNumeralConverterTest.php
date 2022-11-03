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
        $response = $this->post('/', [
            'convert_number' => 1
        ]);

        $this->assertEquals(200, $response->status());
        $this->assertEquals('I', $response->getContent());
    }
}
