<?php
use Pagekit\Application as App;

return [

	'name' => 'bixie/breadcrumbs',

	'type' => 'extension',

	'main' => 'Bixie\\Breadcrumbs\\BreadcrumbsModule',

	'autoload' => [

		'Bixie\\Breadcrumbs\\' => 'src'

	],

	'widgets' => [

		'widgets/breadcrumbs.php'

	],

	'resources' => [

		'bixie/breadcrumbs:' => ''

	],

	'config' => [],

	'events' => [

		'site' => function ($event, $app) {
			if ($app->isAdmin()) {
				return;
			}
			/** @var \Pagekit\Site\Model\Node $node */
			$node = App::node();
			if ($node->id) {
				/** @var \Bixie\Breadcrumbs\BreadcrumbsModule $breadcrumbs */
				$breadcrumbs = $app->module('bixie/breadcrumbs');
				$frontpage = $app->config('system/site')->get('frontpage');

				$node->set('isFrontpage', $frontpage == $node->id);
				$frontpageSet = $node->get('isFrontpage');

				$nodes = [$node];
				while ($parent_id = $node->parent_id) {

					if ($node = $node->find($parent_id, true)) {
						$node->set('isFrontpage', $frontpage == $node->id);
						$frontpageSet = $frontpageSet ? : $node->get('isFrontpage');
						$nodes[] = $node;
					}

				}

				if (!$frontpageSet) {
					$breadcrumbs->addNode($node->find($frontpage, true));
				}

				foreach (array_reverse($nodes) as $node) {
					$breadcrumbs->addNode($node);
				}
			}

		}

	]

];
