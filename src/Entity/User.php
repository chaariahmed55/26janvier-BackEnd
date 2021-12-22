<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * normalizationContext={"groups"={"user","article","otherresource",,"partenaire","programme","pledoyer","projectiondebat","temoignage","archive","retombemediatique"}},
 * denormalizationContext={"groups"={"user","article","otherresource",,"partenaire","programme","pledoyer","projectiondebat","temoignage","archive","retombemediatique"}}
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user","article","otherresource","partenaire","programme","pledoyer","projectiondebat","temoignage","archive","retombemediatique"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user","otherresource","partenaire","programme","pledoyer","projectiondebat","temoignage","archive","retombemediatique"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user"})
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Partenaire::class, mappedBy="admin")
     *
     */
    private $partenaires;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="admin")
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity=RetombeMediatique::class, mappedBy="admin")
     */
    private $retombeMediatiques;

    /**
     * @ORM\OneToMany(targetEntity=Programme::class, mappedBy="admin")
     */
    private $programmes;

    /**
     * @ORM\OneToMany(targetEntity=OtherResouce::class, mappedBy="admin")
     */
    private $otherResouces;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="admin")
     */
    private $articles;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user","article","otherresource","partenaire","programme","pledoyer","projectiondebat","temoignage","archive"})
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity=Archive::class, mappedBy="admin")
     */
    private $archives;

    /**
     * @ORM\OneToMany(targetEntity=Pledoyer::class, mappedBy="admin")
     */
    private $pledoyers;


    /**
     * @ORM\OneToMany(targetEntity=Temoignage::class, mappedBy="admin")
     */
    private $temoignages;

    /**
     * @ORM\OneToMany(targetEntity=ProjectionDebat::class, mappedBy="admin")
     */
    private $projectionDebats;

    public function __construct()
    {
        $this->partenaires = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->retombeMediatiques = new ArrayCollection();
        $this->programmes = new ArrayCollection();
        $this->otherResouces = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->archives = new ArrayCollection();
        $this->pledoyers = new ArrayCollection();
        $this->temoignages = new ArrayCollection();
        $this->projectionDebats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Partenaire[]
     */
    public function getPartenaires(): Collection
    {
        return $this->partenaires;
    }

    public function addPartenaire(Partenaire $partenaire): self
    {
        if (!$this->partenaires->contains($partenaire)) {
            $this->partenaires[] = $partenaire;
            $partenaire->setAdmin($this);
        }

        return $this;
    }

    public function removePartenaire(Partenaire $partenaire): self
    {
        if ($this->partenaires->removeElement($partenaire)) {
            // set the owning side to null (unless already changed)
            if ($partenaire->getAdmin() === $this) {
                $partenaire->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setAdmin($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getAdmin() === $this) {
                $contact->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RetombeMediatique[]
     */
    public function getRetombeMediatiques(): Collection
    {
        return $this->retombeMediatiques;
    }

    public function addRetombeMediatique(RetombeMediatique $retombeMediatique): self
    {
        if (!$this->retombeMediatiques->contains($retombeMediatique)) {
            $this->retombeMediatiques[] = $retombeMediatique;
            $retombeMediatique->setAdmin($this);
        }

        return $this;
    }

    public function removeRetombeMediatique(RetombeMediatique $retombeMediatique): self
    {
        if ($this->retombeMediatiques->removeElement($retombeMediatique)) {
            // set the owning side to null (unless already changed)
            if ($retombeMediatique->getAdmin() === $this) {
                $retombeMediatique->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Programme[]
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programme $programme): self
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes[] = $programme;
            $programme->setAdmin($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): self
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getAdmin() === $this) {
                $programme->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OtherResouce[]
     */
    public function getOtherResouces(): Collection
    {
        return $this->otherResouces;
    }

    public function addOtherResouce(OtherResouce $otherResouce): self
    {
        if (!$this->otherResouces->contains($otherResouce)) {
            $this->otherResouces[] = $otherResouce;
            $otherResouce->setAdmin($this);
        }

        return $this;
    }

    public function removeOtherResouce(OtherResouce $otherResouce): self
    {
        if ($this->otherResouces->removeElement($otherResouce)) {
            // set the owning side to null (unless already changed)
            if ($otherResouce->getAdmin() === $this) {
                $otherResouce->setAdmin(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAdmin($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getAdmin() === $this) {
                $article->setAdmin(null);
            }
        }

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection|Archive[]
     */
    public function getArchives(): Collection
    {
        return $this->archives;
    }

    public function addArchive(Archive $archive): self
    {
        if (!$this->archives->contains($archive)) {
            $this->archives[] = $archive;
            $archive->setAdmin($this);
        }

        return $this;
    }

    public function removeArchive(Archive $archive): self
    {
        if ($this->archives->removeElement($archive)) {
            // set the owning side to null (unless already changed)
            if ($archive->getAdmin() === $this) {
                $archive->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Pledoyer[]
     */
    public function getPledoyers(): Collection
    {
        return $this->pledoyers;
    }

    public function addPledoyer(Pledoyer $pledoyer): self
    {
        if (!$this->pledoyers->contains($pledoyer)) {
            $this->pledoyers[] = $pledoyer;
            $pledoyer->setAdmin($this);
        }

        return $this;
    }

    public function removePledoyer(Pledoyer $pledoyer): self
    {
        if ($this->pledoyers->removeElement($pledoyer)) {
            // set the owning side to null (unless already changed)
            if ($pledoyer->getAdmin() === $this) {
                $pledoyer->setAdmin(null);
            }
        }

        return $this;
    }

    

    /**
     * @return Collection|Temoignage[]
     */
    public function getTemoignages(): Collection
    {
        return $this->temoignages;
    }

    public function addTemoignage(Temoignage $temoignage): self
    {
        if (!$this->temoignages->contains($temoignage)) {
            $this->temoignages[] = $temoignage;
            $temoignage->setAdmin($this);
        }

        return $this;
    }

    public function removeTemoignage(Temoignage $temoignage): self
    {
        if ($this->temoignages->removeElement($temoignage)) {
            // set the owning side to null (unless already changed)
            if ($temoignage->getAdmin() === $this) {
                $temoignage->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProjectionDebat[]
     */
    public function getProjectionDebats(): Collection
    {
        return $this->projectionDebats;
    }

    public function addProjectionDebat(ProjectionDebat $projectionDebat): self
    {
        if (!$this->projectionDebats->contains($projectionDebat)) {
            $this->projectionDebats[] = $projectionDebat;
            $projectionDebat->setAdmin($this);
        }

        return $this;
    }

    public function removeProjectionDebat(ProjectionDebat $projectionDebat): self
    {
        if ($this->projectionDebats->removeElement($projectionDebat)) {
            // set the owning side to null (unless already changed)
            if ($projectionDebat->getAdmin() === $this) {
                $projectionDebat->setAdmin(null);
            }
        }

        return $this;
    }
}
