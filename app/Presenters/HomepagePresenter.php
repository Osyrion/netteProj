<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use App\Model\ModelRepository;
use Nette\Security\Passwords;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
	private ModelRepository $modelRepository;

	/** @var Passwords */
    private $passwords;

	public function __construct(ModelRepository $modelRepository, Nette\Database\Context $passwords)
	{
		$this->modelRepository = $modelRepository;
		$this->passwords = $passwords;
	}

	public function renderDefault() {
		$this->template->a = $this->modelRepository->getAllUsers();
	}

    protected function createComponentRegistrationForm(): Form
	{
        $roles = ['admin' => 'Admin', 'user' => 'User'];

		$form = new Form;
        $form->addEmail('email', 'Email')
			 ->setRequired('Please fill your email.')
			 ->setHtmlAttribute('id', 'email')
			 ->setHtmlAttribute('class', 'form-control');
		$form->addText('username', 'Jméno')
			 ->setRequired('Please fill your username.')
			 ->setHtmlAttribute('id', 'username')
			 ->setHtmlAttribute('class', 'form-control');
        $form->addSelect('role', 'Role', $roles)
			 ->setHtmlAttribute('id', 'role')
			 ->setHtmlAttribute('class', 'form-select')
             ->setDefaultValue('user');
		$form->addPassword('password', 'Heslo')
			 ->setRequired('Please fill your password.')
			 ->setHtmlAttribute('id', 'password')
			 ->setHtmlAttribute('class', 'form-control');
		$form->addSubmit('send', 'Register')
			 ->setHtmlAttribute('class', 'btn btn-primary')
			 ->onClick[] = [$this, 'formSucceeded'];
		return $form;
	}

	public function formSucceeded(Nette\Forms\Controls\SubmitButton $button): void
	{
		$values = $button->getForm()->getValues();

		$pass = new Passwords(PASSWORD_BCRYPT, ['cost' => 12]);
        $values->password =  $pass->hash($values->password);
		
		$duplicate = $this->modelRepository->isDuplicate($values->email);

		// if not duplicate
		if ($duplicate) {
			$this->modelRepository->insertUser($values->email, $values->username, $values->password, $values->role);
			$this->flashMessage('You are registered successfully!', 'alert alert-success');
		}
		// if duplicate
		else {
			$this->flashMessage('This email is already registered!', 'alert alert-danger');
		}
	
		$this->redirect('Homepage:');
	}
}
