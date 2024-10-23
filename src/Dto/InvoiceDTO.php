<?php

namespace App\Dto;

use DateTime;

class InvoiceDTO
{

    /** @var int */
    private int $id;

    /** @var ConsumptionDTO $consumption */
    private ConsumptionDTO $consumption;

    /** @var ContractedPowerDTO $contractedpower */
    private ContractedPowerDTO $contractedpower;

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

    public function setId(int $id): InvoiceDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getConsumption(): ConsumptionDTO
    {
        return $this->consumption;
    }

    public function setConsumption(ConsumptionDTO $consumption): InvoiceDTO
    {
        $this->consumption = $consumption;
        return $this;
    }

    public function getContractedpower(): ContractedPowerDTO
    {
        return $this->contractedpower;
    }

    public function setContractedpower(ContractedPowerDTO $contractedpower): InvoiceDTO
    {
        $this->contractedpower = $contractedpower;
        return $this;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(DateTime $startDate): InvoiceDTO
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(DateTime $endDate): InvoiceDTO
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): InvoiceDTO
    {
        $this->username = $username;
        return $this;
    }


}