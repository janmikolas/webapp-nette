<?php declare(strict_types = 1);

namespace App\Modules\Admin\Sign;

use App\Model\App;
use App\Model\Exception\Runtime\AuthenticationException;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Form\BaseForm;
use App\UI\Form\FormFactory;
use Nette\Application\UI\ComponentReflection;

final class SignPresenter extends BaseAdminPresenter
{

	/** @var string @persistent */
	public $backlink;

	/** @var FormFactory @inject */
	public $formFactory;

	/**
	 * @param ComponentReflection|mixed $element
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 */
	public function checkRequirements($element): void
	{
	}

	public function beforeRender(): void
	{
		if ($this->isAjax()) {
			$this->flashError('Error: You have been logged out. Failed to send data. Please refresh the page and log in again.');

			$this->redrawControl('flashes');
			$this->redrawControl('modal');
		}
	}

	public function actionIn(): void
	{
		if ($this->user->isLoggedIn()) {
			$this->redirect(App::DESTINATION_AFTER_SIGN_IN);
		}
	}

	public function actionOut(): void
	{
		if ($this->user->isLoggedIn()) {
			$this->user->logout();
			$this->flashSuccess('_front.sign.out.success');
		}

		$this->redirect(App::DESTINATION_AFTER_SIGN_OUT);
	}

	protected function createComponentLoginForm(): BaseForm
	{
		$form = $this->formFactory->forBackend();
		$form->addEmail('email')
			->setRequired(true);
		$form->addPassword('password')
			->setRequired(true);
		$form->addCheckbox('remember')
			->setDefaultValue(true);
		$form->addSubmit('submit');
		$form->onSuccess[] = [$this, 'successLoginForm'];

		return $form;
	}

	public function successLoginForm(BaseForm $form): void
	{
		try {
			$this->user->setExpiration($form->values->remember ? '14 days' : '20 minutes');
			$this->user->login($form->values->email, $form->values->password);
		} catch (AuthenticationException $e) {
			$form->addError('Invalid username or password');

			return;
		}

		$this->redirect(App::DESTINATION_AFTER_SIGN_IN);
	}

}
