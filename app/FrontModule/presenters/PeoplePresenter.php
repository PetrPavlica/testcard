<?php
namespace FrontModule;

class PeoplePresenter extends BasePresenter{
    
    /** @var \IPeopleFactory @inject */
    public $peopleControl;
    
    /** @var \ICardFormFactory @inject */
    public $cardFormControl;

    /** @var \IPeopleFormFactory @inject */
    public $peopleFormControl;
    
    /** @var \App\Model\PeopleModel @inject */
     public $peopleData;
    
    protected function createComponentPeople(): \PeopleComponent {
        
        $component = $this->peopleControl->create();
        return $component;
    }
    
    protected function createComponentContact(): \ContactComponent {
        
        $component = $this->contactControl->create();
        return $component;
    }
    
    protected function createComponentPeopleForm(): \PeopleForm {
        
        $component = $this->peopleFormControl->create($this->getParameter('wwwDir'));
        return $component;
    }
    
    protected function createComponentCardForm(): \CardForm {
        
        $component = $this->cardFormControl->create($this->getParameter('wwwDir'),$this->getParameter('people_id'));
        return $component;
    }
    
    public function renderPeople():void{
        
        
    }
    
    public function renderCards($people_id):void{
        $people_data = $this->peopleData->peopleById($people_id);
        $this->template->people_data = $people_data;
    }
}
