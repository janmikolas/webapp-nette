<?php declare(strict_types = 1);

namespace App\Modules\Admin\Manufacturer;

use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Form\BaseForm;
use App\UI\Form\FormFactory;
use App\Model\DataGrid\DataGrid;
use App\Model\Database\EntityManager;
use App\Model\Database\Entity\Manufacturer;

final class ManufacturerPresenter extends BaseAdminPresenter
{

	/** @var EntityManager @inject */
	public EntityManager $em;

	/** @var FormFactory @inject */
	public $formFactory;

	/**
	 * Private property that holds the Manufacturer data.
	 * It is nullable, meaning it can be assigned a null value.
	 *
	 * @var Manufacturer|null
	 */
	private ?Manufacturer $manufacturerData = null;


	public function beforeRender(): void
	{
		$this->redrawControl('title');
		$this->redrawControl('manufacturerlist');
		$this->redrawControl('pagination');
		$this->redrawControl('flashes');
		$this->redrawControl('modal');
	}

	public function renderDefault(array $parameters): void
	{
		$datagrid = new DataGrid(Manufacturer::class, $parameters, $this->em);
		$this->template->manufacturers = $datagrid->getData();
		$this->template->paginator = $datagrid->getPaginator();
	}

	protected function createComponentManufacturerCreateForm(): BaseForm
	{
		$form = $this->formFactory->forBackend();
		$form->addText('name', 'Name')
			->setRequired(true);
		$form->addSubmit('submit');

		$form->onValidate[] = [$this, 'validateManufacturerCreateForm'];
		$form->onSuccess[] = [$this, 'successManufacturerCreateForm'];
		$form->onRender[] = [$form, 'makeBootstrap4'];

		return $form;
	}

	public function validateManufacturerCreateForm(BaseForm $form): void
	{
		if($form->isValid() === false) {
			$form->addError('Error: Manufacturer name is empty. Please enter name of manufacturer');

			return;
		}

		$name = trim($form->values->name);
		if($name === '') {
			$form->addError('Error: Manufacturer name is empty. Please enter name of manufacturer');

			return;
		}

		$manufacturer = $this->em->getManufacturerRepository()->findOneByName($name);
		if ($manufacturer !== null) {
			$form->addError('Error: Manufacturer already exists');

			return;
		}
	}

	public function successManufacturerCreateForm(BaseForm $form): void
	{
		try {
			$entity = new Manufacturer(
				$form->values->name,
			);
			$this->em->persist($entity);
			$this->em->flush();
		} catch (\Exception $e) {
			$form->addError('Error: Failed to create manufacturer');

			return;
		}

		$this->flashSuccess('Manufacturer has been added');

		$this->redirect('Manufacturer:default');
	}

	protected function createComponentManufacturerEditForm(): BaseForm
	{
		$form = $this->formFactory->forBackend();
		$form->addText('name', 'Name')
			->setDefaultValue($this->manufacturerData->getName())
			->setRequired(true);
		$form->addSubmit('submit');

		$form->onValidate[] = [$this, 'validateManufacturerEditForm'];
		$form->onSuccess[] = [$this, 'successManufacturerEditForm'];
		$form->onRender[] = [$form, 'makeBootstrap4'];

		return $form;
	}

	public function validateManufacturerEditForm(BaseForm $form): void
	{
		if($form->isValid() === false) {
			$form->addError('Error: Manufacturer name is empty. Please enter name of manufacturer');

			return;
		}

		$name = trim($form->values->name);
		if($name === '') {
			$form->addError('Error: Manufacturer name is empty. Please enter name of manufacturer');

			return;
		}

		$manufacturer = $this->em->getManufacturerRepository()->findOneByName($name);
		if ($manufacturer !== null) {
			if($manufacturer->getId() === $this->manufacturerData->getId()) {
				$form->addError('Error: Same name');
			} else {
				$form->addError('Error: Manufacturer already exists');
			}	

			return;
		}
	}

	public function successManufacturerEditForm(BaseForm $form): void
	{
		try {
			$this->manufacturerData->setName($form->values->name);
			$this->em->persist($this->manufacturerData);
			$this->em->flush();
		} catch (\Exception $e) {
			$form->addError('Error: Failed to edit manufacturer');

			return;
		}

		$this->flashSuccess('Manufacturer has been edited');

		if ($this->isAjax()) {
			$this->redirect('Manufacturer:default');
		} else {
			$this->redirect('this');
		}
	}

	public function actionCreateManufacturer(): void
	{
		if ($this->isAjax()) {
			$this->payload->modalActive = true;
			$this['manufacturerCreateForm']->getElementPrototype()->class[] = 'ajax';
			$this->redrawControl();
		}
	}

	public function actionEditManufacturer(int $id): void
	{
		$manufacturer = $this->em->getManufacturerRepository()->find($id);
		if ($manufacturer === null) {
			$this->flashError('Error: Manufacturer not found');
			$this->redirect('Manufacturer:default');
		}

		$this->manufacturerData = $manufacturer;
		if ($this->isAjax()) {
			$this->payload->modalActive = true;
			$this['manufacturerEditForm']->getElementPrototype()->class[] = 'ajax';
			$this->redrawControl();
		}
	}

	public function actionDeleteManufacturer(int $id): void
	{
		$manufacturer = $this->em->getManufacturerRepository()->find($id);
		if ($manufacturer !== null) {
			try {
				$this->em->remove($manufacturer);
				$this->em->flush();
			} catch (\Exception $e) {
				$this->flashError('Error: Failed to remove manufacturer');
	
				return;
			}
		}

		$this->flashSuccess('Manufacturer has been removed');

		$this->redirect('Manufacturer:default');
	}

}
