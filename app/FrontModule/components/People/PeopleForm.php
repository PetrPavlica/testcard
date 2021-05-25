<?php

use App\Model\PeopleModel;
use Nette\Utils\Image;
use Nette\Security\Passwords;
class PeopleForm extends Nette\Application\UI\Control
{
    private $peopleData;
    
    private $factory;
    
    private $dir;
    private $passwords;        
    public $onPeopleSave;
    
    private $id=0;
    
    public $pozition = array(1=>'Zaměstnanec',
                   2=>'Účetní',
                   3=>'Admin');
    
    public function __construct(Nette\Security\Passwords $passwords,App\Model\PeopleModel $peopleData,\App\Forms\FormFactory $factory,$dir)
    {
        $this->passwords = $passwords;
        $this->peopleData = $peopleData;
        $this->factory = $factory;
        $this->dir = $dir;
    }
    
    public function handleedit($id){
        $data_default = $this->peopleData->peopleById($id);
        $this['peopleForm']->setDefaults($data_default);
        $this->id = $id;
    }
    
    public function createComponentPeopleForm() 

    {
        $form = $this->factory->create();
        
        $form->addText('name','Jméno:')
                        ->setRequired('Zadejte jméno');
                
        $form->addSelect('pozition','Pozice:',$this->pozition)
                        ->setRequired('Zadejte pozici');
        
        $form->addText('phone','Telefon:')
                        ->setRequired('Zadejte telefon');
        
        $form->addText('email','Email:')
                        ->setRequired('Zadejte email');
               
        $form->addHidden('id',$this->id);
        
        $form->addSubmit('send', 'Uložit')
        ->setAttribute('class', 'btn btn-info btn-sm');   

       
        $form->onSuccess[] = [$this, 'processForm'];
        return $form;
    }

    public function processForm($form)
    {
        bdump('jelo');
        $user_data = array('email'=>$form['email']->getValue(),
                           'role'=>$form['pozition']->getValue());
      
        $saveData = $this->peopleData->addPeople($form->getValues());                   
        $file = $form['photo']->getValue();
        if(!$file){
        $count = $this->peopleData->countName($form['name']->getValue());
        $file_ext=strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
        $file_name = $form['name']->getValue().$count.$file_ext;
        $data = array('name'=>$form['name']->getValue(),
                      'pozition'=>$form['pozition']->getValue(),
                      'phone'=>$form['phone']->getValue(),
                      'email'=>$form['email']->getValue(),
                      'photo'=>$file_name);
        $path = $this->dir.'/images/origin/'.$file_name;
        $form['photo']->getValue()->move($path);
        
        $image_s = Image::fromFile($path);
        $image_s->resize(152,152);
        $path = $this->dir.'/img/152x152/'.$file_name;
        $image_s->save($path);
        }else{
        $data = array('name'=>$form['name']->getValue(),
                      'pozition'=>$form['pozition']->getValue(),
                      'phone'=>$form['phone']->getValue(),
                      'email'=>$form['email']->getValue(),
                      'photo'=>'NONE');
            
        }
        if($form['id']->getValue() == 0){
            $save = $this->peopleData->addPeople($data);
        }
        else{
            $save = $this->peopleData->updatePeople($form['id']->getValue(),$data);
        }
        $this->onPeopleSave($this, $saveData);

    }
    
    public function render(){
       $this->template->render(__DIR__ .'/peopleform.latte');
       //$this->template->render();
    }
}

/** rozhrannĂ­ pro generovanou tovĂˇrniÄŤku */
interface IPeopleFormFactory
{
    /** @return \PeopleForm */
    function create($dir);
}
