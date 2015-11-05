<?php

class CRM_Campaigntab_Page_Tab extends CRM_Core_Page {

  public $_contactId = NULL;

  public function preProcess() {

    $this->_contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);
    $this->assign('contactId', $this->_contactId);

    $personalCampaigns = CRM_Campaigntab_BAO_Campaigntab::getCampaigPages($this->_contactId);

    $this->assign('rows', $personalCampaigns);

  }

  public function run() {
    
    $this->preProcess();

    return parent::run();
  }

}
