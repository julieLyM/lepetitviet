<?php

namespace App\Entity\Newsletters;

use App\Entity\Newsletters\NewsLetters;
use App\Repository\Newsletters\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriesRepository::class)
 */
class Categories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, mappedBy="categories")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=NewsLetters::class, mappedBy="categeories", orphanRemoval=true)
     */
    private $newsLetters;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->newsLetters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addCategory($this);
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if($this->users->removeElement($user)) {
            $user->removeCategory($this);
        }
        return $this;
    }

    /**
     * @return Collection|NewsLetters[]
     */
    public function getNewsLetters(): Collection
    {
        return $this->newsLetters;
    }

    public function addNewsLetter(NewsLetters $newsLetter): self
    {
        if (!$this->newsLetters->contains($newsLetter)) {
            $this->newsLetters[] = $newsLetter;
            $newsLetter->setCategeories($this);
        }

        return $this;
    }

    public function removeNewsLetter(NewsLetters $newsLetter): self
    {
        if ($this->newsLetters->removeElement($newsLetter)) {
            // set the owning side to null (unless already changed)
            if ($newsLetter->getCategeories() === $this) {
                $newsLetter->setCategeories(null);
            }
        }

        return $this;
    }
}
