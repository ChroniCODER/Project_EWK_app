<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[Vich\Uploadable]
class Product
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $purchase_Date = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;

    #[ORM\Column]
    private ?int $warrantyDuration = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $receipt = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'receipts', fileNameProperty: 'receipt')]
    private ?File $receiptFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $expiration_date = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductDoc::class, orphanRemoval: true)]
    private Collection $productDocs;

    public function __construct()
    {
        $this->productDocs = new ArrayCollection();
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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchase_Date;
    }

    public function setPurchaseDate(\DateTimeInterface $purchase_Date): self
    {
        $this->purchase_Date = $purchase_Date;

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

        
    public function getWarrantyDuration(): ?int
    {
        return $this->warrantyDuration;
    }

    public function setWarrantyDuration(int $warrantyDuration): self
    {
        $this->warrantyDuration = $warrantyDuration;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(\DateTimeInterface $expiration_date): self
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getReceipt()
    {
        return $this->receipt;
    }

    public function setReceipt($receipt): self
    {
        $this->receipt = $receipt;

        return $this;
    }

    public function setReceiptFile(?File $receiptFile = null): void
    {
        $this->receiptFile = $receiptFile;

        if (null !== $receiptFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getReceiptFile(): ?File
    {
        return $this->receiptFile;
    }

    /**
     * @return Collection<int, ProductDoc>
     */
    public function getProductDocs(): Collection
    {
        return $this->productDocs;
    }

    public function addProductDoc(ProductDoc $productDoc): self
    {
        if (!$this->productDocs->contains($productDoc)) {
            $this->productDocs->add($productDoc);
            $productDoc->setProduct($this);
        }

        return $this;
    }

    public function removeProductDoc(ProductDoc $productDoc): self
    {
        if ($this->productDocs->removeElement($productDoc)) {
            // set the owning side to null (unless already changed)
            if ($productDoc->getProduct() === $this) {
                $productDoc->setProduct(null);
            }
        }

        return $this;
    }

    function __toString()
    {
        return $this->getName();
    }
}