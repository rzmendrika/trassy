<?php 

return [

	'restau' => [
		'id' => 1,
		'tarifs' => [
			[
				'name'  => 'Bronze',
				'pictures' => 12,
				'menus' => 10,
				'monthly' => 15000,
				'half_yearly' => 85000,
				'yearly' => 16000,
				'localisations' => 2,
				'events' => 1,
			],
			[
				'name'  => 'Silver',
				'pictures' => 20,
				'menus' => 15,
				'monthly' => 20000,
				'half_yearly' => 110000,
				'yearly' => 200000,
				'localisations' => 5,
				'events' => 3,
			],
			[
				'name'  => 'Gold',
				'pictures' => 30,
				'menus' => 30,
				'monthly' => 25000,
				'half_yearly' => 140000,
				'yearly' => 250000,
				'localisations' => 8,
				'events' => 5,
			],
			[
				'name'  => 'Platine',
				'pictures' => 12,
				'menus' => 10,
				'monthly' => 30000,
				'half_yearly' => 160000,
				'yearly' => 300000,
				'localisations' => 10,
				'events' => 7,
			],
		],
	],

	'acc' => [
		'id' => 2,
		'tarifs' => [
			[
				'name'  => 'Bronze',
				'pictures' => 12,
				'monthly' => 20000,
				'half_yearly' => 110000,
				'yearly' => 200000,
				'annexes' => 0,
				'events' => false,
			],
			[
				'name'  => 'Silver',
				'pictures' => 20,
				'monthly' => 25000,
				'half_yearly' => 135000,
				'yearly' => 250000,
				'annexes' => 2,
				'events' => true,
			],
			[
				'name'  => 'Gold',
				'pictures' => 35,
				'monthly' => 35000,
				'half_yearly' => 200000,
				'yearly' => 350000,
				'annexes' => 5,
				'events' => true,
			],
			[
				'name'  => 'Platine',
				'pictures' => 12,
				'monthly' => 40000,
				'half_yearly' => 230000,
				'yearly' => 400000,
				'annexes' => 10,
				'events' => true,
			]
		]
	],

];


?>

