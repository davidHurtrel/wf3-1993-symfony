<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $abstract = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $min_players = null;

    #[ORM\Column(nullable: true)]
    private ?int $max_players = null;

    #[ORM\Column(nullable: true)]
    private ?int $minimum_age = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $duration = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $editor = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $theme = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mecanism = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(length: 45)]
    private ?string $img1 = null;

    #[ORM\Column(length: 255)]
    private ?string $alt1 = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $img2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alt2 = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $img3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alt3 = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: OrderHasProduct::class)]
    private Collection $orderHasProducts;

    public function __construct()
    {
        $this->orderHasProducts = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getAbstract(): ?string
    {
        return $this->abstract;
    }

    public function setAbstract(string $abstract): self
    {
        $this->abstract = $abstract;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getMinPlayers(): ?int
    {
        return $this->min_players;
    }

    public function setMinPlayers(int $min_players): self
    {
        $this->min_players = $min_players;

        return $this;
    }

    public function getMaxPlayers(): ?int
    {
        return $this->max_players;
    }

    public function setMaxPlayers(?int $max_players): self
    {
        $this->max_players = $max_players;

        return $this;
    }

    public function getMinimumAge(): ?int
    {
        return $this->minimum_age;
    }

    public function setMinimumAge(?int $minimum_age): self
    {
        $this->minimum_age = $minimum_age;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(?\DateTimeInterface $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getEditor(): ?string
    {
        return $this->editor;
    }

    public function setEditor(?string $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getMecanism(): ?string
    {
        return $this->mecanism;
    }

    public function setMecanism(?string $mecanism): self
    {
        $this->mecanism = $mecanism;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getImg1(): ?string
    {
        return $this->img1;
    }

    public function setImg1(string $img1): self
    {
        $this->img1 = $img1;

        return $this;
    }

    public function getAlt1(): ?string
    {
        return $this->alt1;
    }

    public function setAlt1(string $alt1): self
    {
        $this->alt1 = $alt1;

        return $this;
    }

    public function getImg2(): ?string
    {
        return $this->img2;
    }

    public function setImg2(string $img2): self
    {
        $this->img2 = $img2;

        return $this;
    }

    public function getAlt2(): ?string
    {
        return $this->alt2;
    }

    public function setAlt2(?string $alt2): self
    {
        $this->alt2 = $alt2;

        return $this;
    }

    public function getImg3(): ?string
    {
        return $this->img3;
    }

    public function setImg3(?string $img3): self
    {
        $this->img3 = $img3;

        return $this;
    }

    public function getAlt3(): ?string
    {
        return $this->alt3;
    }

    public function setAlt3(?string $alt3): self
    {
        $this->alt3 = $alt3;

        return $this;
    }

    /**
     * @return Collection<int, OrderHasProduct>
     */
    public function getOrderHasProducts(): Collection
    {
        return $this->orderHasProducts;
    }

    public function addOrderHasProduct(OrderHasProduct $orderHasProduct): self
    {
        if (!$this->orderHasProducts->contains($orderHasProduct)) {
            $this->orderHasProducts->add($orderHasProduct);
            $orderHasProduct->setProduct($this);
        }

        return $this;
    }

    public function removeOrderHasProduct(OrderHasProduct $orderHasProduct): self
    {
        if ($this->orderHasProducts->removeElement($orderHasProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderHasProduct->getProduct() === $this) {
                $orderHasProduct->setProduct(null);
            }
        }

        return $this;
    }
}
