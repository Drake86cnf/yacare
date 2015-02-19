<?php
namespace Tapir\BaseBundle\Helper;

use \Tests\Tapir\PruebaUnitaria;

class DammTest extends PruebaUnitaria
{

    public function testtaq()
    {
        $this->assertEquals('7', Damm::taq('25248532'));
        $this->assertEquals('6', Damm::taq('12345678'));
        $this->assertEquals('9', Damm::taq('3257'));
    }

    public function testCalcCheckDigit()
    {
        $this->assertEquals('25248532-7', Damm::CalcCheckDigit('25248532'));
        $this->assertEquals('12345678-6', Damm::CalcCheckDigit('12345678'));
        $this->assertEquals('3257-9', Damm::CalcCheckDigit('3257'));
    }

    public function testIsCheckDigitValid()
    {
        $this->assertEquals(false, Damm::IsCheckDigitValid('252485320'));
        $this->assertEquals(false, Damm::IsCheckDigitValid('252485321'));
        $this->assertEquals(false, Damm::IsCheckDigitValid('252485322'));
        $this->assertEquals(false, Damm::IsCheckDigitValid('252485323'));
        $this->assertEquals(false, Damm::IsCheckDigitValid('252485324'));
        $this->assertEquals(false, Damm::IsCheckDigitValid('252485325'));
        $this->assertEquals(false, Damm::IsCheckDigitValid('252485326'));
        $this->assertEquals(true, Damm::IsCheckDigitValid('252485327'));
        $this->assertEquals(false, Damm::IsCheckDigitValid('252485328'));
        $this->assertEquals(false, Damm::IsCheckDigitValid('252485329'));
    }
}
