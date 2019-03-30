<?php

namespace App\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ProcesoRepository")
 * @UniqueEntity(
 *     fields={"numero"},
 *     errorPath="numero",
 *     message="El número de proceso ya existe."
 * )
 */
class Proceso
{
/**
 * @ORM\Id()
 * @ORM\GeneratedValue()
 * @ORM\Column(type="integer")
 */
private $id;

/**
 * @ORM\Column(type="string", length=8, unique=true)
 */
private $numero;

/**
 * @ORM\Column(type="float", nullable=true)
 */
private $presupuesto;

/**
 * @ORM\Column(type="string", length=200)
 */
private $descripcion;

/**
 * @var \DateTime $creacion
 *
 * @Gedmo\Timestampable(on="create")
 * @ORM\Column(type="datetime")
 */
private $creacion;

/**
 * @ORM\ManyToOne(targetEntity="App\Entity\Sede", inversedBy="procesos")
 */
private $sede;

public function getSede(): ?Sede
{
return $this->sede;
}

public function setSede(?Sede $sede): self
{
$this->sede = $sede;

return $this;
}

public function getId(): ?int
{
return $this->id;
}

public function getNumero(): ?string
{
return $this->numero;
}

public function setNumero(string $numero): self
{
$this->numero = $numero;

return $this;
}

public function getPresupuesto(): ?float
{
return $this->presupuesto;
}

public function getPresupuestodolar(): ?float
{
return  round(($this->presupuesto)/3000, 2);
}

public function setPresupuesto(?float $presupuesto): self
{
$this->presupuesto = $presupuesto;

return $this;
}

public function getDescripcion(): ?string
{
return $this->descripcion;
}

public function setDescripcion(string $descripcion): self
{
$this->descripcion = $descripcion;

return $this;
}

public function getCreacion()
{
return $this->creacion;
}

public function __toString()
{
return $this->getNumero();
}
}
