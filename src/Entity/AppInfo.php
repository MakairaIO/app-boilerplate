<?php

namespace App\Entity;

use App\Repository\AppInfoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppInfoRepository::class)]
class AppInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: false)]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $makairaDomain = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $makairaInstance = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $appSlug = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $appSecret = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?string $appConfig = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMakairaDomain(): ?string
    {
        return $this->makairaDomain;
    }

    public function setMakairaDomain(string $makairaDomain): self
    {
        $this->makairaDomain = $makairaDomain;

        return $this;
    }

    public function getMakairaInstance(): ?string
    {
        return $this->makairaDomain;
    }

    public function setMakairaInstance(string $makairaDomain): self
    {
        $this->makairaDomain = $makairaDomain;

        return $this;
    }

    public function getAppSlug(): ?string
    {
        return $this->appSlug;
    }

    public function setAppSlug(string $appSlug): self
    {
        $this->appSlug = $appSlug;

        return $this;
    }

    public function getAppSecret(): ?string
    {
        return $this->appSecret;
    }

    public function setAppSecret(string $appSecret): self
    {
        $this->appSecret = $appSecret;

        return $this;
    }

    public function getAppConfig(): ?string
    {
        return $this->appConfig;
    }

    public function setAppConfig(string $appConfig): self
    {
        $this->appConfig = $appConfig;

        return $this;
    }
}
