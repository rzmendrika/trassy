<?php

use Illuminate\Database\Seeder;

class AccSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\Acc\Acc::class, 30)->create()->each( 
        	function ($acc)
	        {
	            $acc->rooms()->saveMany(
	            	factory(App\Model\Acc\Room::class, rand(2, 6))->make()
	            );

                $types   = [1, 2, 3, 4, 5, 6, 7, 8, 9];
                $choosen = array_intersect_key( $types, array_flip( array_rand( $types, rand(2, 5) ) ) );
                $acc->types()->sync( $choosen );
	        }
	    );
    }
}
