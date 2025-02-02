<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaymentMappingRepository")
 */
class PaymentMapping
{
    public const TO_CAPTURE = 'to_capture';
    public const CAPTURED = 'captured';
    public const CANCELED = 'canceled';

    /**
     * @ORM\Id()
     *
     * @ORM\GeneratedValue()
     *
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $miraklCommercialOrderId;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $stripeChargeId;

    /**
     * @ORM\Column(type="string")
     */
    private string $status = self::TO_CAPTURE;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $stripeAmount;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     *
     * @Gedmo\Timestampable(on="create")
     */
    private \DateTimeInterface $creationDatetime;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     *
     * @Gedmo\Timestampable(on="update")
     */
    private \DateTimeInterface $modificationDatetime;

    public function getId(): int
    {
        return $this->id;
    }

    public function getMiraklCommercialOrderId(): ?string
    {
        return $this->miraklCommercialOrderId;
    }

    public function setMiraklCommercialOrderId(?string $miraklCommercialOrderId): self
    {
        $this->miraklCommercialOrderId = $miraklCommercialOrderId;

        return $this;
    }

    public function getStripeChargeId(): string
    {
        return $this->stripeChargeId;
    }

    public function setStripeChargeId(string $stripeChargeId): self
    {
        $this->stripeChargeId = $stripeChargeId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public static function getAvailableStatus()
    {
        return [
            self::TO_CAPTURE,
            self::CAPTURED,
            self::CANCELED,
        ];
    }

    /**
     * @param string $status
     */
    public function setStatus($status): self
    {
        if (!in_array($status, (array) self::getAvailableStatus(), true)) {
            throw new \InvalidArgumentException('Invalid payment status');
        }

        $this->status = $status;

        return $this;
    }

    /**
     * @return self
     */
    public function capture()
    {
        return $this->setStatus(self::CAPTURED);
    }

    /**
     * @return self
     */
    public function cancel()
    {
        return $this->setStatus(self::CANCELED);
    }

    public function getStripeAmount(): ?int
    {
        return $this->stripeAmount;
    }

    public function setStripeAmount(int $stripeAmount): self
    {
        $this->stripeAmount = $stripeAmount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreationDatetime()
    {
        return $this->creationDatetime;
    }

    public function setCreationDatetime(\DateTimeInterface $creationDatetime): self
    {
        $this->creationDatetime = $creationDatetime;

        return $this;
    }

    public function getModificationDatetime(): ?\DateTimeInterface
    {
        return $this->modificationDatetime;
    }

    public function setModificationDatetime(\DateTimeInterface $modificationDatetime): self
    {
        $this->modificationDatetime = $modificationDatetime;

        return $this;
    }
}
