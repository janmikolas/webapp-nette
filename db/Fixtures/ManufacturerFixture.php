<?php declare(strict_types = 1);

namespace Database\Fixtures;

use App\Model\Database\Entity\Manufacturer;
use App\Model\Security\Passwords;
use Doctrine\Persistence\ObjectManager;

class ManufacturerFixture extends AbstractFixture
{

	public function getOrder(): int
	{
		return 1;
	}

	public function load(ObjectManager $manager): void
	{
		foreach ($this->getManufacturers() as $manufacturer) {
			$entity = new Manufacturer(
				$manufacturer['name'],
			);

			$manager->persist($entity);
		}
		$manager->flush();
	}

	/**
	 * @return mixed[]
	 */
	protected function getManufacturers(): iterable
	{
		yield ['name' => 'Nike'];
		yield ['name' => 'Adidas'];
		yield ['name' => 'Puma'];
		yield ['name' => 'Carraa'];
		yield ['name' => 'Keller'];
		yield ['name' => 'Harrows'];
		yield ['name' => 'Champion'];
		yield ['name' => 'City'];
		yield ['name' => 'Trixie'];
		yield ['name' => 'Start'];
		yield ['name' => 'Andy'];
		yield ['name' => 'Veru'];
		yield ['name' => 'Dominique'];
	}

}
