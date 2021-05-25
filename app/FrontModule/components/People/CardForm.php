<?php

use App\Model\PeopleModel;
use Nette\Utils\Image;
use Nette\Security\Passwords;
class CardForm extends Nette\Application\UI\Control
{
    private $peopleData;
    
    private $factory;
     
    public $onPeopleSave;
    
    private $people_id=0;
    
    /** @var string $wwwDir */
	protected $wwwDir;
        
    public $pozition = array(1=>'Zaměstnanec',
                   2=>'Účetní',
                   3=>'Admin');
    
    public function __construct(App\Model\PeopleModel $peopleData,\App\Forms\FormFactory $factory,$people_id,$wwwDir = null)
    {
        
        $this->peopleData = $peopleData;
        $this->factory = $factory;
        $this->people_id = $people_id;
        $this->wwwDir = $wwwDir;
    }
    
    public function handlecreate($id){
        $this->people_id = $id;
    }
    
    public function createComponentCardForm() 

    {
        $form = $this->factory->create();
        
        $form->addText('num','Číslo:')
                        ->setRequired('Zadejte číslo')
                        ->setDefaultValue(1);
                
               
        $form->addSubmit('send', 'Uložit')
        ->setAttribute('class', 'btn btn-info btn-sm');   

       
        $form->onSuccess[] = [$this, 'processForm'];
        return $form;
    }

    public function processForm($form)
    {
        
        $this->onPeopleSave($this, $saveData);

    }
    
    public function render(){
        bdump($this->wwwDir);
       $this->template->render(__DIR__ .'/cardform.latte');
       
       //$this->template->render();
    }
}

/** rozhrannĂ­ pro generovanou tovĂˇrniÄŤku */
interface ICardFormFactory
{
    /** @return \CardForm */
    function create($people_id);
}
