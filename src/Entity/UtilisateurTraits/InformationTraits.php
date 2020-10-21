<?php


namespace App\Entity\UtilisateurTraits;


/**
 * Class InformationTraits
 * @package App\Entity\UtilisateurTraits
 * @author jaures kano <ruddyjaures@mail.com>
 */
Trait InformationTraits
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fonction;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isConnected;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastConnexion;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastDeconnexion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $insertAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $genre;

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(?string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getIsConnected(): ?bool
    {
        return $this->isConnected;
    }

    public function setIsConnected(?bool $isConnected): self
    {
        $this->isConnected = $isConnected;

        return $this;
    }

    public function getLastConnexion(): ?\DateTimeInterface
    {
        return $this->lastConnexion;
    }

    public function setLastConnexion(?\DateTimeInterface $lastConnexion): self
    {
        $this->lastConnexion = $lastConnexion;

        return $this;
    }

    public function getLastDeconnexion(): ?\DateTimeInterface
    {
        return $this->lastDeconnexion;
    }

    public function setLastDeconnexion(?\DateTimeInterface $lastDeconnexion): self
    {
        $this->lastDeconnexion = $lastDeconnexion;

        return $this;
    }

    public function getInsertAt(): ?\DateTimeInterface
    {
        return $this->insertAt;
    }

    public function setInsertAt(\DateTimeInterface $insertAt): self
    {
        $this->insertAt = $insertAt;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

}