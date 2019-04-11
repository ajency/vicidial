<?php

use Illuminate\Database\Seeder;

class ReturnPoliciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	//DB::table('return_policies')->delete();
          DB::table('return_policies')->insert(array(
     array(
       'title' => 'Uniform',
       'active' => '1',
       'display' => '1',
     ),
     array(
       'title' => 'Undergarments',
       'active' => '1',
       'display' => '1',
     ),
     array(
       'title' => 'Other',
       'active' => '1',
       'display' => '1',
     ),
   ));
         // DB::table('expressions')->delete();
          DB::table('expressions')->insert(array(
     array(

       'entity' => 'days' ,
            'filter' => 'less_than',
            'value' => '3',
            'parent_type' => 'App\return_policies',
            'parent_id' => DB::table('return_policies')->where('title', 'Uniform')->value('id'),
            'active' => '1',
     ),
     array(
       'entity' => 'days' ,
            'filter' => 'less_than',
            'value' => '0',
            'parent_type' => 'App\return_policies',
            'parent_id' => DB::table('return_policies')->where('title', 'Undergarments')->value('id'),
            'active' => '1',
     ),
     array(
       'entity' => 'days' ,
            'filter' => 'less_than',
            'value' => '7',
            'parent_type' => 'App\return_policies',
            'parent_id' => DB::table('return_policies')->where('title', 'Other')->value('id'),
            'active' => '1',
     ),
   ));


        DB::table('facet_returnpolicies')->insert(array(
     array(

       
            'facet_id' => DB::table('facets')->where('facet_name', 'product_category_type')->where('facet_value', 'Uniform')->value('id'),
            
            'returnpolicies_id' => DB::table('return_policies')->where('title', 'Uniform')->value('id'),
            
     ),
     array(
       'facet_id' => DB::table('facets')->where('facet_name', 'product_subtype')->where('facet_value', 'Undergarments')->value('id'),
            
            'returnpolicies_id' => DB::table('return_policies')->where('title', 'Undergarments')->value('id'),
     ),
    
   ));   
          
   



    }

}


