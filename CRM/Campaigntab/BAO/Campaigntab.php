<?php

class CRM_Campaigntab_BAO_Campaigntab extends CRM_PCP_BAO_PCP {

	public function __construct() 
	{
	    parent::__construct();
	}

	public static function getCount($cid)
	{
		
		$query = "
	     SELECT count(*)
	     FROM civicrm_pcp pcp
	     WHERE pcp.contact_id = %1";

	    $params = array(1 => array($cid, 'Integer'));
	    $result = CRM_Core_DAO::singleValueQuery($query, $params);
	    return $result;

	}

	public static function getTotalContributions($pcpId) {
		    $query = "
		SELECT COUNT(*)
		FROM civicrm_pcp pcp
		LEFT JOIN civicrm_contribution_soft cs ON ( pcp.id = cs.pcp_id )
		LEFT JOIN civicrm_contribution cc ON ( cs.contribution_id = cc.id)
		WHERE pcp.id = %1 AND cc.contribution_status_id =1 AND cc.is_test = 0";

    	$params = array(1 => array($pcpId, 'Integer'));
    	return CRM_Core_DAO::singleValueQuery($query, $params);
  	}



	public static function getCampaigPages($contactId)
	{
		$links = self::pcpLinks();

	    $query = "
			SELECT * FROM civicrm_pcp pcp
			WHERE pcp.is_active = 1
			  AND pcp.contact_id = %1
			ORDER BY page_type, page_id";

	    $params = array(1 => array($contactId, 'Integer'));
	    
	    $pcpInfoDao = CRM_Core_DAO::executeQuery($query, $params);
	    $pcpInfo = array();

	    $event = CRM_Event_PseudoConstant::event(NULL, FALSE, "( is_template IS NULL OR is_template != 1 )");
	    $contribute = CRM_Contribute_PseudoConstant::contributionPage();
	    $pcpStatus = CRM_Contribute_PseudoConstant::pcpStatus();
	    $approved = CRM_Utils_Array::key('Approved', $pcpStatus);

	    while ($pcpInfoDao->fetch()) {

	      $component = $pcpInfoDao->page_type;
	      $pageTitle = CRM_Utils_Array::value($pcpInfoDao->page_id, $$component);
	      $totalAmount = CRM_PCP_BAO_PCP::thermoMeter($pcpInfoDao->id);
	      $total_count = CRM_Campaigntab_BAO_Campaigntab::getTotalContributions($pcpInfoDao->id);
	      
	      $pcpInfo[] = array(
	        'pageTitle'        => $pageTitle,
	        'pcpId'  	       => $pcpInfoDao->id,
	        'pcpTitle'         => $pcpInfoDao->title,
	        'pcpAmount'        => $pcpInfoDao->goal_amount,
	        'pcpReached'       => number_format($totalAmount, 2),
	        'pcpContribations' => $total_count,
	        'pcpStatus'  	   => $pcpStatus[$pcpInfoDao->status_id],
	      );
	      
	    }

	    return $pcpInfo;
	}

}