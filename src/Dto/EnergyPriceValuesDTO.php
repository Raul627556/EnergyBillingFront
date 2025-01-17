<?php

namespace App\Dto;

class EnergyPriceValuesDTO
{
    /** @var float */
    private float $p1;

    /** @var float */
    private float $p2;

    /** @var float */
    private float $p3;


    public function getP1(): float
    {
        return $this->p1;
    }

    public function setP1(float $p1): EnergyPriceValuesDTO
    {
        $this->p1 = $p1;
        return $this;
    }

    public function getP2(): float
    {
        return $this->p2;
    }

    public function setP2(float $p2): EnergyPriceValuesDTO
    {
        $this->p2 = $p2;
        return $this;
    }

    public function getP3(): float
    {
        return $this->p3;
    }

    public function setP3(float $p3): EnergyPriceValuesDTO
    {
        $this->p3 = $p3;
        return $this;
    }

}
