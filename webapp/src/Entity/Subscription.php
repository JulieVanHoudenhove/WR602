<?php

namespace App\Entity;

use App\Repository\SubscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
class Subscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $pdf_limit = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $media = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPdfLimit(): ?int
    {
        return $this->pdf_limit;
    }

    public function setPdfLimit(int $pdf_limit): static
    {
        $this->pdf_limit = $pdf_limit;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(?string $media): static
    {
        $this->media = $media;

        return $this;
    }

    public function getSubscriptionEndAt(): ?User
    {
        return $this->subscription_end_at;
    }

    public function setSubscriptionEndAt(?User $subscription_end_at): static
    {
        // unset the owning side of the relation if necessary
        if ($subscription_end_at === null && $this->subscription_end_at !== null) {
            $this->subscription_end_at->setSubscription(null);
        }

        // set the owning side of the relation if necessary
        if ($subscription_end_at !== null && $subscription_end_at->getSubscription() !== $this) {
            $subscription_end_at->setSubscription($this);
        }

        $this->subscription_end_at = $subscription_end_at;

        return $this;
    }
}
