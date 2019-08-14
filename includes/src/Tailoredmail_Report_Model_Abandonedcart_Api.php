<?php
class Tailoredmail_Report_Model_Abandonedcart_Api extends Mage_Api_Model_Resource_Abstract
{
    public function getabandonedcarts($arg)
    {
		$collection = Mage::getResourceModel('reports/quote_collection');
		$collection->prepareForAbandonedReport(); 
		$output = $collection->load()->toArray();
		
		$quote= Mage::getModel('sales/quote');
		$quote_coll = $quote->getCollection(); 
		
		$return_data = array();

		foreach($output['items'] as $obj){
			   $quote_id =  $obj['entity_id'];
			   $tmp_quotedata = $quote_coll->getItemById($quote_id)->getItemsCollection()->toArray();
			
			   $count = $count + 1;
			   $return_data[$obj['customer_email']]['email'] = $obj['customer_email'];
			   $return_data[$obj['customer_email']]['cartid'] = $quote_id;
			   $return_data[$obj['customer_email']]['customer_id'] = $obj['customer_id'];
			   $return_data[$obj['customer_email']]['user'] = $obj['customer_prefix'] . " " . $obj['customer_firstname'] . " ". $obj["customer_lastname"];
			   $return_data[$obj['customer_email']]['updated_at'] = $obj['updated_at'];
			   $return_data[$obj['customer_email']]['subtotal'] = $obj['subtotal'];
			
			   foreach ($tmp_quotedata["items"] as $item) { 
					$temp['name'] = $item["name"];
					$temp['quantity'] = $item["qty"];
					$temp['price'] = $item["price"];
					$temp['plu'] = $item["sku"];
					$temp['product_id'] = $item["product_id"];
					if(isset($item["product"])){
						$temp['image'] = $item["product"]["small_image"];
						$temp['thumbnail'] = $item["product"]["thumbnail"];
						$temp['created_at'] = $item["product"]["created_at"];
						$temp['updated_at'] = $item["product"]["updated_at"];
					}
					else{
						$temp['image'] = "";
						$temp['thumbnail'] = "";
					}	
					$return_data[$obj['customer_email']]['cart'][] = $temp;
				}
		 }
		foreach( $return_data as $value){
			$new_return[] = $value;
		}
		return json_encode($new_return);
    }
	
}
