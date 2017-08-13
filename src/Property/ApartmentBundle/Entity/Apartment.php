<?php

namespace Property\ApartmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Apartment
 *
 * @ORM\Table(name="apartment")
 * @ORM\Entity(repositoryClass="Property\ApartmentBundle\Repository\ApartmentRepository")
 * @ORM\Entity
 */
class Apartment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="count_rooms", type="smallint", nullable=false)
     */
    private $countRooms;

    /**
     * @var integer
     *
     * @ORM\Column(name="count_bathrooms", type="smallint", nullable=false)
     */
    private $countBathrooms;

    /**
     * @var integer
     *
     * @ORM\Column(name="square", type="smallint", nullable=false)
     */
    private $square;

    /**
     * @var boolean
     *
     * @ORM\Column(name="has_parking", type="boolean", nullable=false)
     */
    private $hasParking;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=10, nullable=true)
     */
    private $unit;

    /**
     * @var string
     *
     * @ORM\Column(name="building", type="string", length=10, nullable=false)
     */
    private $building;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=50, nullable=false)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=false)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=50, nullable=false)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=50, nullable=false)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=6, nullable=false)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="access_token", type="string", length=32, nullable=false)
     */
    private $accessToken;

    /**
     * @var string
     *
     * @ORM\Column(name="owner_email", type="string", length=255, nullable=false)
     */
    private $ownerEmail;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="apartment_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @return int
     */
    public function getCountRooms()
    {
        return $this->countRooms;
    }

    /**
     * @param int $countRooms
     */
    public function setCountRooms($countRooms)
    {
        $this->countRooms = $countRooms;
    }

    /**
     * @return int
     */
    public function getCountBathrooms()
    {
        return $this->countBathrooms;
    }

    /**
     * @param int $countBathrooms
     */
    public function setCountBathrooms($countBathrooms)
    {
        $this->countBathrooms = $countBathrooms;
    }

    /**
     * @return int
     */
    public function getSquare()
    {
        return $this->square;
    }

    /**
     * @param int $square
     */
    public function setSquare($square)
    {
        $this->square = $square;
    }

    /**
     * @return boolean
     */
    public function isHasParking()
    {
        return $this->hasParking;
    }

    /**
     * @param boolean $hasParking
     */
    public function setHasParking($hasParking)
    {
        $this->hasParking = $hasParking;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    /**
     * @return string
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * @param string $building
     */
    public function setBuilding($building)
    {
        $this->building = $building;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getOwnerEmail()
    {
        return $this->ownerEmail;
    }

    /**
     * @param string $ownerEmail
     */
    public function setOwnerEmail($ownerEmail)
    {
        $this->ownerEmail = $ownerEmail;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



}

