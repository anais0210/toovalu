<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Category
 *
 * @author Anais Sparesotto <a.sparesotto@icloud.com>
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotNull(
     *     message = "La catégorie doit avoir un nom"
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le nom de la catégorie doit avoir au minimum {{ limit }} caractères",
     *      maxMessage = "Le nom de la catégorie doit avoir au maximum {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="category")
     */
    private $article;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->article = new ArrayCollection();
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
     * @return Collection|Article[]
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    /**
     * @param Article $article
     * @return $this
     */
    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
            $article->setCategory($this);
        }

        return $this;
    }

    /**
     * @param Article $article
     * @return $this
     */
    public function removeArticle(Article $article): self
    {
        if ($this->article->removeElement($article)) {
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
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
