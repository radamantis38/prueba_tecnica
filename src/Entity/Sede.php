<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SedeRepository")
 */
class Sede
{
/**
 * @ORM\Id()
 * @ORM\GeneratedValue()
 * @ORM\Column(type="integer")
 */
private $id;

/**
 * @ORM\Column(type="string", length=40)
 */
private $nombre;

/**
 * @ORM\OneToMany(targetEntity="App\Entity\Proceso", mappedBy="sede")
 */
private $procesos;

public function __construct()
{
$this->procesos = new ArrayCollection();
}

/**
 * @return Collection|Proceso[]
 */
public function getProcesos(): Collection
{
return $this->procesos;
}

public function getId(): ?int
{
return $this->id;
}

public function getNombre(): ?string
{
return $this->nombre;
}

public function setNombre(string $nombre): self
{
$this->nombre = $nombre;

return $this;
}

public function __toString()
{
return $this->getNombre();
}
}
