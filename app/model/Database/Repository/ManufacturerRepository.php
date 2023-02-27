<?php declare(strict_types = 1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\Manufacturer;

/**
 * @method Manufacturer|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method Manufacturer|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method Manufacturer[] findAll()
 * @method Manufacturer[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<Manufacturer>
 */
class ManufacturerRepository extends AbstractRepository
{

	public function findOneByName(string $name): ?Manufacturer
	{
		return $this->findOneBy(['name' => $name]);
	}

}
