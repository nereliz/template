<?php 
namespace Admin\Model;

use Zend\Form\Annotation;
  
/**
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("User")
 */
class User
{
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"username"})
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"Username:"})
     */
    public $us_username;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"password"})
     * @Annotation\AllowEmpty({"allow_empty":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options": {"min":6}})
     * @Annotation\Options({"label":"Password:"})
     */
    public $us_password;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Attributes({"class":"form-control", "id":"profile"})
     * @Annotation\Required({"required":"true" })
     * @Annotation\Options({"label":"User Profile:"})
     */
    public $up_id;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Attributes({"class":"form-control", "id":"tenants", "multiple":"multiple"})
     * @Annotation\AllowEmpty({"allow_empty":"true" })
     * @Annotation\Options({"label":"Tenants:"})
     */
    public $te_ids;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Attributes({"class":"form-control", "id":"routing_profiles", "multiple":"multiple"})
     * @Annotation\AllowEmpty({"allow_empty":"true" })
     * @Annotation\Options({"label":"Routing Profiles:"})
     */
    public $rp_ids;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"name":"submit_data","value":"Submit","class":"btn btn-primary", "id":"submit_profile_data"})
     */
    public $submit;
}