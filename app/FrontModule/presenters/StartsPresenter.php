<?php
declare(strict_types=1);

namespace FrontModule;

use Nette;


final class StartsPresenter extends Nette\Application\UI\Presenter
{
  
    /** @var \ISignFormFactory @inject */
	public $signFormFactory;

      
    public function beforeRender() {
        $this->setLayout('layoutFront');
    }
        
	protected function createComponentSignForm()
	{
		$control = $this->signFormFactory->create();
		$control->onSignSave[] = function () {
                    if($this->user->getIdentity()){
                         $this->redirect('People:people');                    }
                    else{
                        $this->flashMessage('Chybné jméno nebo heslo');
                    }
		};

		return $control;
	}
    
    function renderDefault():void{
        
    }
    
}


