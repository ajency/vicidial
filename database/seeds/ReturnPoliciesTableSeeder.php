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
        DB::table('return_policies')->insert(array(
            array(
                'title'        => 'Uniform',
                'display_name' => '3 day Policy',
                'active'       => '1',
                'display'      => '1',
            ),
            array(
                'title'        => 'Undergarments',
                'display_name' => 'No Returns',
                'active'       => '1',
                'display'      => '1',
            ),
            array(
                'title'        => 'Other',
                'display_name' => '7 day Policy',
                'active'       => '1',
                'display'      => '1',
            ),
        ));

        DB::table('expressions')->insert(array(
            array(
                'entity'      => 'days',
                'filter'      => 'less_than',
                'value'       => '[3]',
                'parent_type' => 'App\ReturnPolicy',
                'parent_id'   => DB::table('return_policies')->where('title', 'Uniform')->value('id'),
                'active'      => '1',
            ),
            array(
                'entity'      => 'days',
                'filter'      => 'less_than',
                'value'       => '[0]',
                'parent_type' => 'App\ReturnPolicy',
                'parent_id'   => DB::table('return_policies')->where('title', 'Undergarments')->value('id'),
                'active'      => '1',
            ),
            array(
                'entity'      => 'days',
                'filter'      => 'less_than',
                'value'       => '[7]',
                'parent_type' => 'App\ReturnPolicy',
                'parent_id'   => DB::table('return_policies')->where('title', 'Other')->value('id'),
                'active'      => '1',
            ),
        ));

        DB::table('facet_return_policy')->insert(array(
            array(
                'facet_id'         => DB::table('facets')->where('facet_name', 'product_category_type')->where('facet_value', 'Uniform')->value('id'),
                'return_policy_id' => DB::table('return_policies')->where('title', 'Uniform')->value('id'),
            ),
            array(
                'facet_id'         => DB::table('facets')->where('facet_name', 'product_subtype')->where('facet_value', 'Undergarments')->value('id'),
                'return_policy_id' => DB::table('return_policies')->where('title', 'Undergarments')->value('id'),
            ),
        ));
    }
}
