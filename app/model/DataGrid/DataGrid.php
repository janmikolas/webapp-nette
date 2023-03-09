<?php declare(strict_types = 1);

namespace App\Model\DataGrid;

use Nette\Utils\Paginator;
use App\Model\Database\EntityManager;

final class DataGrid
{
	// Properties for pagination and filtering
	private int $pageCurrent = 1;
	private int $pageMax = 1;
	private int $pageRequired = 1;
	private array $limitOptions = [10, 20, 30];
	private int $limit = 30;
	private string $orderbyName = 'id';
	private string $orderbyAscDesc = 'ASC';
	private int $itemCountTotal = 0;
	private array $repositoryData;

	public function __construct(string $entityName, array $parameters, EntityManager $em)
	{
		$repository = $em->getRepository($entityName);

		// Set the sorting order and limit based on the input parameters
		if(isset($parameters['name']) && $parameters['name'] === 'name') {
			$this->orderbyName = 'name';
		} else {
			$this->orderbyName = 'id';
		}

		if(isset($parameters['order']) && ($parameters['order'] === 'DESC' || $parameters['order'] === 'desc')) {
			$this->orderbyAscDesc = 'DESC';
		} else {
			$this->orderbyAscDesc = 'ASC';
		}

		if(isset($parameters['limit']) && in_array($parameters['limit'], $this->limitOptions)) {
			$this->limit = (int)$parameters['limit'];
		} else {
			$this->limit = 30;
		}

		if(isset($parameters['page']) && $parameters['page'] > 0) {
			$this->pageRequired = (int)$parameters['page'];
		} else {
			$this->pageRequired = 1;
		}

		// Count the total number of items in the repository
		$this->itemCountTotal = $repository->count([]);
		// Create a paginator object to handle pagination
		$paginator = new Paginator;
		$paginator->setPage($this->pageRequired);
		$paginator->setItemsPerPage($this->limit);
		$paginator->setItemCount($this->itemCountTotal);

		// Update the current and maximum page numbers based on the paginator
		$this->pageCurrent = $paginator->getPage();
		$this->pageMax = $paginator->getPageCount();
       
		/* Uncomment the following code if you want to prevent the display of the last possible page
		if($this->pageRequired !== $this->pageCurrent) {
			return;
		}
		*/

		// Fetch the data from the repository based on the sorting order and limit
		$orderby = [$this->orderbyName => $this->orderbyAscDesc];
		$this->repositoryData = $repository->findBy([], $orderby, $paginator->getLength(), $paginator->getOffset());
	}

	// Return the fetched data
	public function getData(): array
	{
		return $this->repositoryData;
	}

	// Return the filter and the pagination information
	public function getPaginator(): object
	{
		return (object)[
			'required' => $this->pageRequired,
			'current' => $this->pageCurrent,
			'max' => $this->pageMax,
			'name' => $this->orderbyName,
			'order' => $this->orderbyAscDesc,
			'limit' => $this->limit,
			'limitOptions' => $this->limitOptions,
			'itemCountTotal' => $this->itemCountTotal,
		];
	}

}
			