<?php 
namespace Profile\Model;

use Zend\Form\Annotation;
  
/**
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("Profile")
 */
class Profile
{
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control"})
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"Username:"})
     */
    public $us_username;

    /**
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Attributes({"class":"form-control"})
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options": {"min":6}})
     * @Annotation\Options({"label":"Password:"})
     */
    public $conf_password;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"name":"submit_data","value":"Submit","class":"btn btn-primary", "id":"submit_profile_data"})
     */
    public $submit;
}