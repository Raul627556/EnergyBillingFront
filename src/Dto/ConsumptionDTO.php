<?php

namespace App\Dto;

use phpDocumentor\Reflection\Types\Integer;

class ConsumptionDTO
{

    /** @var int  */
    private int $p1;

    /** @var int */
    private int $p2;

    /** @var int */
    private int $p3;

    public function getP1(): int
    {
        return $this->p1;
    }

    public function setP1(int $p1): ConsumptionDTO
    {
        $this->p1 = $p1;
        return $this;
    }

    public function getP2(): int
    {
        return $this->p2;
    }

    public function setP2(int $p2): ConsumptionDTO
    {
        $this->p2 = $p2;
        return $this;
    }

    public function getP3(): int
    {
        return $this->p3;
    }

    public function setP3(int $p3): ConsumptionDTO
    {
        $this->p3 = $p3;
        return $this;
    }


}