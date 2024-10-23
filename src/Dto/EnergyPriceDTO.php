<?php
namespace App\Dto;

use DateTime;

class EnergyPriceDTO
{

    /** @var int  */
    private int $id;

    /** @var EnergyPriceValuesDTO */
    private EnergyPriceValuesDTO $energy;

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

    public function setId(int $id): EnergyPriceDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getEnergy(): EnergyPriceValuesDTO
    {
        return $this->energy;
    }

    public function setEnergy(EnergyPriceValuesDTO $energy): EnergyPriceDTO
    {
        $this->energy = $energy;
        return $this;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(DateTime $startDate): EnergyPriceDTO
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(DateTime $endDate): EnergyPriceDTO
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): EnergyPriceDTO
    {
        $this->username = $username;
        return $this;
    }

}