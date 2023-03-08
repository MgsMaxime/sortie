<?php

namespace App\Model;

use App\Entity\Campus;
use phpDocumentor\Reflection\Types\Boolean;

class FiltresAccueil

{
private Campus $campus;
private ?string $recherche;
private ?\DateTimeInterface $dateDebut;
private ?\DateTimeInterface $dateFin;
private Boolean $checkOrga;
private Boolean $checkInscrit;
private Boolean $checkNonInscrit;
private Boolean $checkPassees;

    public function __construct()
    {
    }


    /**
     * @return Campus
     */
    public function getCampus(): Campus
    {
        return $this->campus;
    }

    /**
     * @param Campus $campus
     */
    public function setCampus(Campus $campus): void
    {
        $this->campus = $campus;
    }

    /**
     * @return string|null
     */
    public function getRecherche(): ?string
    {
        return $this->recherche;
    }

    /**
     * @param string|null $recherche
     */
    public function setRecherche(?string $recherche): void
    {
        $this->recherche = $recherche;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTimeInterface|null $dateDebut
     */
    public function setDateDebut(?\DateTimeInterface $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTimeInterface|null $dateFin
     */
    public function setDateFin(?\DateTimeInterface $dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return bool
     */
    public function isCheckOrga(): bool
    {
        return $this->checkOrga;
    }

    /**
     * @param bool $checkOrga
     */
    public function setCheckOrga(bool $checkOrga): void
    {
        $this->checkOrga = $checkOrga;
    }

    /**
     * @return bool
     */
    public function isCheckInscrit(): bool
    {
        return $this->checkInscrit;
    }

    /**
     * @param bool $checkInscrit
     */
    public function setCheckInscrit(bool $checkInscrit): void
    {
        $this->checkInscrit = $checkInscrit;
    }

    /**
     * @return bool
     */
    public function isCheckNonInscrit(): bool
    {
        return $this->checkNonInscrit;
    }

    /**
     * @param bool $checkNonInscrit
     */
    public function setCheckNonInscrit(bool $checkNonInscrit): void
    {
        $this->checkNonInscrit = $checkNonInscrit;
    }

    /**
     * @return bool
     */
    public function isCheckPassees(): bool
    {
        return $this->checkPassees;
    }

    /**
     * @param bool $checkPassees
     */
    public function setCheckPassees(bool $checkPassees): void
    {
        $this->checkPassees = $checkPassees;
    }


}