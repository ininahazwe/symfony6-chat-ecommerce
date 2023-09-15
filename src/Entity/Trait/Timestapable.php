<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait Timestapable
{
    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true, options={"default": "CURRENT_TIMESTAMP"})
     */
    private $updatedAt;

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function updateTimestamps ()
    {
        if($this->getCreatedAt() === null){
            $this->setCreatedAt(new \DateTimeImmutable);
        }
        $this->setUpdatedAt(new \DateTimeImmutable);
    }

    /**
     * @return string
     * @Groups({"read:blog", "read:comment"})
     */
    public function getCreatedAtString($option = null){

        $date_1 = $this->getCreatedAt();
        switch ($option) {
            case 1:
                return $this->geDayFr($date_1) . $date_1->format(' j ') . $this->getMoisFr($date_1) . $date_1->format(' Y ');
            case 2:
                return $this->geDayFr($date_1) . $date_1->format(' j ') . $this->getMoisFr($date_1) . $date_1->format(' Y '). ' à '.$date_1->format(' H:m ');
            case 3:
                return $date_1->format(' j ') . $this->getMoisFr($date_1) . $date_1->format(' Y ');
            case 4:
                return $date_1->format(' j ') . $this->getMoisFr($date_1) . $date_1->format(' Y '). ' à '.$date_1->format(' H:m ');;
        }
        return $this->geDayFr($date_1) . $date_1->format(' j ') . $this->getMoisFr($date_1) . $date_1->format(' Y '). ' à '.$date_1->format(' H:m ');

    }

    /**
     * @return string
     * @Groups({"read:blog", "read:comment"})
     */
    public function getUpdatedAtString($nonHeure = false){

        $date_1 = $this->getUpdatedAt();
        if ($date_1){
            if ($nonHeure){
                return $this->geDayFr($date_1) . $date_1->format(' j ') . $this->getMoisFr($date_1) . $date_1->format(' Y ');
            }
            return $this->geDayFr($date_1) . $date_1->format(' j ') . $this->getMoisFr($date_1) . $date_1->format(' Y '). ' à '.$date_1->format(' H:m ');
        }
        return null;

    }
}

