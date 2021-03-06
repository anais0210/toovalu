<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Job
 *
 * @author Anais Sparesotto <a.sparesotto@icloud.com>
 * @ORM\Entity(repositoryClass=JobRepository::class)
 */
class Job
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private $id = UuidV4::class;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(
     *     message = "Le métier ne peut pas être vide"
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le métier doit avoir au minimum {{ limit }} caractères",
     *      maxMessage = "Le métier doit avoir au maximum {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity=Employee::class, mappedBy="job")
     */
    private $employee;

    /**
     * Job constructor.
     */
    public function __construct()
    {
        $this->employee = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }


    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Employee[]
     */
    public function getEmployee(): Collection
    {
        return $this->employee;
    }

    /**
     * @param Employee $employee
     * @return $this
     */
    public function addEmploye(Employee $employee): self
    {
        if (!$this->employee->contains($employee)) {
            $this->employee[] = $employee;
            $employee->setJob($this);
        }

        return $this;
    }

    /**
     * @param Employee $employee
     * @return $this
     */
    public function removeEmployee(Employee $employee): self
    {
        if ($this->employee->removeElement($employee)) {
            if ($employee->getJob() === $this) {
                $employee->setJob(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
