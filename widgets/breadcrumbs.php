<?php


return [

    'name' => 'bixie/widget-breadcrumbs',

    'label' => 'Breadcrumbs',

	'events' => [

		'view.scripts' => function ($event, $scripts) use ($app) {
			$scripts->register('widget-breadcrumbs', 'bixie/breadcrumbs:app/bundle/widget-breadcrumbs.js', ['~widgets']);
		}

	],

    'render' => function ($widget) use ($app) {


		return $app['view']('bixie/breadcrumbs/widget-breadcrumbs.php');
    }

];
