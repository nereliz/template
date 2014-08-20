<?php 
//module/SanAuth/src/SanAuth/Model/User.php
namespace Auth\Model;

use Zend\Form\Annotation;
  
/**
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("User")
 */
class User
{
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control"})
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Username:"})
     */
    public $username;

    /**
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Attributes({"class":"form-control"})
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Validator({"name":"StringLength", "options": {"min":6}})
     * @Annotation\Options({"label":"Password:"})
     */
    public $password;

    /**
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Options({"label":"Remember Me"})
     */
    public $rememberme;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Submit","class":"btn btn-primary"})
     */
    public $submit;
}