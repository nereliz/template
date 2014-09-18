<?php 


namespace Admin\Model;

use Zend\Form\Annotation;
  
/**
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("TenantSettings")
 */
class TenantSettings
{
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label":"{t}Channel Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_channels;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxchannels"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Channels{/t}:"})
     */
    public $teMaxchannels;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Extensions Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_extensions;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxextensions"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Extensions{/t}:"})
     */
    public $teMaxextensions;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}IVR Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_ivrs;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxivrs"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of IVRs{/t}:"})
     */
    public $teMaxivrs;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Hunt Group Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_hunts;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxhunts"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Hunt Groups{/t}:"})
     */
    public $teMaxhunts;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Conference Room Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_conferences;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxconferences"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Conference Rooms{/t}:"})
     */
    public $teMaxconferences;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Queues Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_queues;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxqueues"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Queues{/t}:"})
     */
    public $teMaxqueues;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}DISA Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_disas;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxdisas"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of DISAs{/t}:"})
     */
    public $teMaxdisas;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Voicemail Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_voicemails;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxvoicemails"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Voicemails{/t}:"})
     */
    public $teMaxvoicemails;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Call Campaigns Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_campaigns;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxcampaigns"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Call Campaigns{/t}:"})
     */
    public $teMaxcampaigns;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}DID Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_dids;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxdids"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of DIDs{/t}:"})
     */
    public $teMaxdids;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Mediafiles Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_mediafiles;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxmediafiles"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Mediafiles{/t}:"})
     */
    public $teMaxmediafiles;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Condition Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_conditions;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxconditions"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Conditions{/t}:"})
     */
    public $teMaxconditions;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Paging & Intercoms Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_pagings;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxpagings"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Paging & Intercoms Limitation{/t}:"})
     */
    public $teMaxpagings;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Flows Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_flows;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxflows"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Flows{/t}:"})
     */
    public $teMaxflows;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Custom Destination Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_customs;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxcustoms"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Customs{/t}:"})
     */
    public $teMaxcustoms;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Feature Code Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_features;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxfeatures"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Feature Codes{/t}:"})
     */
    public $teMaxfeatures;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Short Number Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_shortnumbers;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxshortnumbers"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Short Numbers{/t}:"})
     */
    public $teMaxshortnumbers;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}CallerID Black List Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_calleridblacklist;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxcalleridblacklist"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of CallerID Black List{/t}:"})
     */
    public $teMaxcalleridblacklist;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}AGI Script Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_agiscripts;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxagiscripts"})
     * @Annotation\AllowEmpty({"allow_empty":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of AGI Scripts{/t}:"})
     */
    public $teMaxagiscripts;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Conduit Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_conduits;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxconduits"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Conduits{/t}:"})
     */
    public $teMaxconduits;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Phone Book Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_phonebooks;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxphonebooks"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Phone Books{/t}:"})
     */
    public $teMaxphonebooks;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({"label": "{t}Provisioning Limitation{/t}:", "value_options":{"true":"{t}Limited to{/t}", "false":"{t}Unlimited{/t}"}})
     * @Annotation\Attributes({"value":"false"})
     */
    public $limited_provisioning;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"class":"form-control", "id":"maxprovisioning"})
     * @Annotation\AllowEmpty({"allow_empty":"true"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"{t}Number of Provisioning{/t}:"})
     */
    public $teMaxprovisioning;
    
    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"name":"submit_data","value":"{t}Submit{/t}","class":"btn btn-primary", "id":"submit_tenant_settings"})
     */
    public $submit;
}