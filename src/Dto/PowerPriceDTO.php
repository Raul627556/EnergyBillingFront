<?php

namespace App\Dto;

use DateTime;

class PowerPriceDTO
{

    /** @var int  */
    private int $id;

    private PowerPriceValuesDTO $power;

    /** @var Datetime */
    private Datetime $startDate;

    /** @var Datetime */
    private Datetime $endDate;

    /** @var string */
    private string $username;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): PowerPriceDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getPower(): PowerPriceValuesDTO
    {
        return $this->power;
    }

    public function setPower(PowerPriceValuesDTO $power): PowerPriceDTO
    {
        $this->power = $power;
        return $this;
    }

    public function getStartDate(): Datetime
    {
        return $this->startDate;
    }

    public function setStartDate(Datetime $startDate): PowerPriceDTO
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): Datetime
    {
        return $this->endDate;
    }

    public function setEndDate(Datetime $endDate): PowerPriceDTO
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): PowerPriceDTO
    {
        $this->username = $username;
        return $this;
    }


}