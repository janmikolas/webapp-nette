<?php declare(strict_types = 1);

namespace App\Model\Database;

use App\Model\Database\Entity\User;
use App\Model\Database\Entity\Manufacturer;
use App\Model\Database\Repository\UserRepository;
use App\Model\Database\Repository\ManufacturerRepository;

/**
 * @mixin EntityManager
 */
trait TRepositories
{

	public function getUserRepository(): UserRepository
	{
		return $this->getRepository(User::class);
	}
	
	public function getManufacturerRepository(): ManufacturerRepository
	{
		return $this->getRepository(Manufacturer::class);
	}

}
