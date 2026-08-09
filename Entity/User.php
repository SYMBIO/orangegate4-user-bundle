<?php

declare(strict_types=1);

namespace Symbio\OrangeGate\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser3;

/**
 * OrangeGate user on legacy fos_user_user (profile + groups beyond Sonata User 5 BaseUser).
 * Extends BaseUser3 so roles use Doctrine `json` (DBAL 4 removed `array`).
 */
#[ORM\Entity]
#[ORM\Table(name: 'fos_user_user')]
class User extends BaseUser3
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    protected $id;

    #[ORM\ManyToOne(targetEntity: 'Symbio\OrangeGate\MediaBundle\Entity\Media', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'image_id', referencedColumnName: 'id', nullable: true)]
    private ?object $image = null;

    /** @var Collection<int, Group> */
    #[ORM\ManyToMany(targetEntity: Group::class)]
    #[ORM\JoinTable(
        name: 'user_group',
        joinColumns: [new ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')],
        inverseJoinColumns: [new ORM\JoinColumn(name: 'group_id', referencedColumnName: 'id')],
    )]
    protected Collection $groups;

    #[ORM\Column(name: 'date_of_birth', type: Types::DATETIME_MUTABLE, nullable: true)]
    protected ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(type: Types::STRING, length: 64, nullable: true)]
    protected ?string $firstname = null;

    #[ORM\Column(type: Types::STRING, length: 64, nullable: true)]
    protected ?string $lastname = null;

    #[ORM\Column(type: Types::STRING, length: 64, nullable: true)]
    protected ?string $website = null;

    #[ORM\Column(type: Types::STRING, length: 1000, nullable: true)]
    protected ?string $biography = null;

    #[ORM\Column(type: Types::STRING, length: 1, nullable: true)]
    protected ?string $gender = null;

    #[ORM\Column(type: Types::STRING, length: 8, nullable: true)]
    protected ?string $locale = null;

    #[ORM\Column(type: Types::STRING, length: 64, nullable: true)]
    protected ?string $timezone = null;

    #[ORM\Column(type: Types::STRING, length: 64, nullable: true)]
    protected ?string $phone = null;

    #[ORM\Column(name: 'facebook_uid', type: Types::STRING, length: 255, nullable: true)]
    protected ?string $facebookUid = null;

    #[ORM\Column(name: 'facebook_name', type: Types::STRING, length: 255, nullable: true)]
    protected ?string $facebookName = null;

    #[ORM\Column(name: 'facebook_data', type: Types::JSON, nullable: true)]
    protected ?array $facebookData = null;

    #[ORM\Column(name: 'twitter_uid', type: Types::STRING, length: 255, nullable: true)]
    protected ?string $twitterUid = null;

    #[ORM\Column(name: 'twitter_name', type: Types::STRING, length: 255, nullable: true)]
    protected ?string $twitterName = null;

    #[ORM\Column(name: 'twitter_data', type: Types::JSON, nullable: true)]
    protected ?array $twitterData = null;

    #[ORM\Column(name: 'gplus_uid', type: Types::STRING, length: 255, nullable: true)]
    protected ?string $gplusUid = null;

    #[ORM\Column(name: 'gplus_name', type: Types::STRING, length: 255, nullable: true)]
    protected ?string $gplusName = null;

    #[ORM\Column(name: 'gplus_data', type: Types::JSON, nullable: true)]
    protected ?array $gplusData = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $token = null;

    #[ORM\Column(name: 'two_step_code', type: Types::STRING, length: 255, nullable: true)]
    protected ?string $twoStepVerificationCode = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    protected ?bool $locked = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    protected ?bool $expired = null;

    #[ORM\Column(name: 'credentials_expired', type: Types::BOOLEAN, nullable: true)]
    protected ?bool $credentialsExpired = null;

    public function __construct()
    {
        // Sonata BaseUser3 / Model\User have no constructor (DBAL/ORM 3).
        $this->groups = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
        }

        return $this;
    }

    public function removeGroup(Group $group): void
    {
        $this->groups->removeElement($group);
    }

    /**
     * @return Collection<int, Group>
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function setImage(?object $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImage(): ?object
    {
        return $this->image;
    }

    public function getName(): string
    {
        return trim(sprintf('%s %s', $this->firstname ?? '', $this->lastname ?? ''));
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setLocale(?string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setTimezone(?string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setFacebookUid(?string $facebookUid): self
    {
        $this->facebookUid = $facebookUid;

        return $this;
    }

    public function getFacebookUid(): ?string
    {
        return $this->facebookUid;
    }

    public function setFacebookName(?string $facebookName): self
    {
        $this->facebookName = $facebookName;

        return $this;
    }

    public function getFacebookName(): ?string
    {
        return $this->facebookName;
    }

    public function setFacebookData(?array $facebookData): self
    {
        $this->facebookData = $facebookData;

        return $this;
    }

    public function getFacebookData(): ?array
    {
        return $this->facebookData;
    }

    public function setTwitterUid(?string $twitterUid): self
    {
        $this->twitterUid = $twitterUid;

        return $this;
    }

    public function getTwitterUid(): ?string
    {
        return $this->twitterUid;
    }

    public function setTwitterName(?string $twitterName): self
    {
        $this->twitterName = $twitterName;

        return $this;
    }

    public function getTwitterName(): ?string
    {
        return $this->twitterName;
    }

    public function setTwitterData(?array $twitterData): self
    {
        $this->twitterData = $twitterData;

        return $this;
    }

    public function getTwitterData(): ?array
    {
        return $this->twitterData;
    }

    public function setGplusUid(?string $gplusUid): self
    {
        $this->gplusUid = $gplusUid;

        return $this;
    }

    public function getGplusUid(): ?string
    {
        return $this->gplusUid;
    }

    public function setGplusName(?string $gplusName): self
    {
        $this->gplusName = $gplusName;

        return $this;
    }

    public function getGplusName(): ?string
    {
        return $this->gplusName;
    }

    public function setGplusData(?array $gplusData): self
    {
        $this->gplusData = $gplusData;

        return $this;
    }

    public function getGplusData(): ?array
    {
        return $this->gplusData;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setTwoStepVerificationCode(?string $twoStepVerificationCode): self
    {
        $this->twoStepVerificationCode = $twoStepVerificationCode;

        return $this;
    }

    public function getTwoStepVerificationCode(): ?string
    {
        return $this->twoStepVerificationCode;
    }

    public function setLocked(?bool $locked): self
    {
        $this->locked = $locked;

        return $this;
    }

    public function getLocked(): ?bool
    {
        return $this->locked;
    }

    public function setExpired(?bool $expired): self
    {
        $this->expired = $expired;

        return $this;
    }

    public function getExpired(): ?bool
    {
        return $this->expired;
    }

    public function setCredentialsExpired(?bool $credentialsExpired): self
    {
        $this->credentialsExpired = $credentialsExpired;

        return $this;
    }

    public function getCredentialsExpired(): ?bool
    {
        return $this->credentialsExpired;
    }
}
