<?php 
namespace Profile\Model;

use Zend\Form\Annotation;
  
/**
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("ProfilePassword")
 */
class ProfilePassword
{
    /**
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Attributes({"class":"form-control","autocomplete":"off"})
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options": {"min":6}})
     * @Annotation\Options({"label":"{t}New Password{/t}:"})
     */
    public $us_password;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Attributes({"class":"form-control","autocomplete":"off"})
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options": {"min":6}})
     * @Annotation\Options({"label":"{t}Confirm Password{/t}:"})
     */
    public $ret_password;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Attributes({"class":"form-control","autocomplete":"off"})
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options": {"min":6}})
     * @Annotation\Options({"label":"{t}Current Password{/t}:"})
     */
    public $conf_password;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"name":"submit_pwd","value":"{t}Submit{/t}","class":"btn btn-primary", "id":"submit_change_password"})
     */
    public $submit;
}