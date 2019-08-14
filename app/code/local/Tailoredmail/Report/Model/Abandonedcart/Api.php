<?php
class Tailoredmail_Report_Model_Abandonedcart_Api extends Mage_Api_Model_Resource_Abstract
{
    public function getabandonedcarts($arg)
    {
	
		$collection = Mage::getResourceModel('reports/quote_collection');
		$collection->prepareForAbandonedReport(); 
		$output = $collection->load()->toArray();

		return json_encode($output);
   
    }
}
