<?php declare(strict_types = 1);

namespace Database\Fixtures;

use App\Model\Database\Entity\User;
use App\Model\Security\Passwords;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends AbstractFixture
{

	public function getOrder(): int
	{
		return 1;
	}

	public function load(ObjectManager $manager): void
	{
		foreach ($this->getUsers() as $user) {
			$entity = new User(
				$user['name'],
				$user['surname'],
				$user['email'],
				$user['username'],
				$this->container->getByType(Passwords::class)->hash('test')
			);
			$entity->activate();
			$entity->setRole($user['role']);

			$manager->persist($entity);
		}
		$manager->flush();
	}

	/**
	 * @return mixed[]
	 */
	protected function getUsers(): iterable
	{
		yield ['email' => 'test@test.cz', 'name' => 'Test', 'surname' => 'Admin', 'username' => 'test@test.cz', 'role' => User::ROLE_ADMIN];
	}

}
