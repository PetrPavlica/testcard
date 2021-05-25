<?php
declare(strict_types=1);

namespace AdminModule;

use Nette;


final class StartPresenter extends Nette\Application\UI\Presenter
{
  
    /** @var \ISignFormFactory @inject */
	public $signFormFactory;

      
    public function beforeRender() {
        $this->setLayout('layoutAdmin');
    }
        
	protected function createComponentSignForm()
	{
		$control = $this->signFormFactory->create();
		$control->onSignSave[] = function () {
                    if($this->user->getIdentity()){
                         $this->redirect('Users:default');                    }
                    else{
                        $this->flashMessage('Chybné jméno nebo heslo');
                    }
		};

		return $control;
	}
    
    function renderDefault():void{
        
    }
    
}


