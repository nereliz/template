<?php 

namespace Admin\Model;
use Zend\Form\Annotation;
  
/**
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("Tenant")
 */
class Tenant
{
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"name"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Name{/t}:"})
     */
    public $teName;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"code"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Code{/t}:"})
     */
    public $teCode;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"alertemail"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"EmailAddress"})
     * @Annotation\Options({"label":"{t}Alert Email{/t}:"})
     */
    public $teAlertemail;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Attributes({"class":"form-control chosen", "id":"timezone"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Options({"label":"{t}Time Zone{/t}:"})
     */
    public $teTimezone;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Attributes({"class":"form-control chosen", "id":"clientrate"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Options({"label":"{t}Call Rate{/t}:"})
     */
    public $clId;

    /**
      * @Annotation\Type("Zend\Form\Element\Radio")
      * @Annotation\Options({"label": "{t}Payment Type{/t}:", "value_options":{"Prepaid":"{t}Prepaid{/t}", "Post Paid":"{t}Post Paid{/t}"}})
      * @Annotation\Attributes({"value":"Prepaid", "class":"radio-inline"})
      */
    public $tePaymentType;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Select")
     * @Annotation\Attributes({"class":"form-control chosen", "id":"routingprofile"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Options({"label":"{t}Routing Profile{/t}:"})
     */
    public $rpId;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"billingcode"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Billing Code{/t}:"})
     */
    public $teBillingcode;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"pklotstart", "value":"700"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Parking lot start number{/t}:"})
     */
    public $pkStart;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"pklotend", "value":"720"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Parking lot end number{/t}:"})
     */
    public $pkEnd;
    
    /**
      * @Annotation\Type("Zend\Form\Element\Radio")
      * @Annotation\Options({"label": "{t}Status{/t}:", "value_options":{"":"{t}Enabled{/t}", "on":"{t}Disabled{/t}"}})
      * @Annotation\AllowEmpty({"allow_empty":"true" })
      * @Annotation\Attributes({"value":"", "class":"radio-inline"})
      */
    public $teDisabled;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Attributes({"class":"form-control with-popover", "id":"allowedip", "rows":"5", "data-trigger":"focus", "data-content":"{t}Specify the comma seperated values list of networks or IP addresses from which the extensions are allowed to connect. Be warned you may need to unregister the extensions for the tenant to have the filter to take effect.{/t}", "title":"{t}Restrict to IP Addresses{/t}", "data-placement":"left"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Options({"label":"{t}Allowed Ip{/t}:"})
     */
    public $teAllowedip;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"name":"submit_data","value":"{t}Submit{/t}","class":"btn btn-primary", "id":"submit_tenant_data"})
     */
    public $submit;
}