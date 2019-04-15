<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnPolicy extends Model
{
   public function facet()
    {
        return $this->belongsToMany('App\Facet');
    }
  
    public static function getReturnPolicy($variant_odoo_id) {
    	//$var = [];
    	$var = Variant::where('odoo_id', $variant_odoo_id)->first();

    	$cat_type=$var->getCategoryType();
    	$sub_type=$var->getSubType();
    	$facet = \DB::table('facets')->where('facet_value',$cat_type)->first();
    	$facet_id = $facet->id;
    	$return = \DB::table('facet_returnpolicies')->where('facet_id',$facet_id)->first(); 
			if($return)
    		{
				//dd($return);
    			$ret = $return->returnpolicies_id ;
    			$return_type = \DB::table('return_policies')->where('id',$ret)->first();
    			$return_policy = $return_type->title;    	
    			return $return_policy;
    		}
    	else    		
    	{
    			$facet = \DB::table('facets')->where('facet_value',$sub_type)->first();
    			$facet_id = $facet->id;
    			$return = \DB::table('facet_returnpolicies')->where('facet_id',$facet_id)->first(); 
    			if($return)
    				{
    					$ret = $return->returnpolicies_id ;
    					$return_type = \DB::table('return_policies')->where('id',$ret)->first();    	
    					$return_policy = $return_type->title;    	
    					return $return_policy;
    				}

    		else
    		{
    			$return_policy = 'Other' ;  	
    			return $return_policy;
    		}


    	}
    		
    }
    	
}


    



