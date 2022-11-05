<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NumeralToNumberConverterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function validNumeralToNumber()
    {
        $this->convertNumber('IV', false, 'IV as a modern number is 4');
    }

    /** @test */
    public function validNumeralWithOutsideSpaceToNumber()
    {
        $this->convertNumber(' XI ', false, 'XI as a modern number is 11');
    }

    /** @test */
    public function validNumeralWithInsideSpaceToNumber()
    {
        $this->convertNumber(' X X V ', false, 'XXV as a modern number is 25');
    }

    /** @test */
    public function invalidNumeralToNumber()
    {
        $this->convertNumber('XTE', true);
    }

    /** @test */
    public function invalidTypeNumeralToNumber()
    {
        $this->convertNumber('X2T', true);
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
