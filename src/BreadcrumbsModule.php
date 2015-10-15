<?php

namespace Bixie\Breadcrumbs;

use Pagekit\Application as App;
use Pagekit\Module\Module;
use Pagekit\Site\Model\Node;

class BreadcrumbsModule extends Module
{
	/**
	 * @var BreadcrumbsManager
	 */
	protected $breadcrumbs;

	/**
	 * {@inheritdoc}
	 */
	public function main(App $app)
	{

		$this->breadcrumbs = new BreadcrumbsManager($app);

		$app->extend('view', function ($view) {
			return $view->addGlobal('breadcrumbs', $this);
		});

	}

	/**
	 * Add a path to the breadcrumbs
	 *
	 * @return string
	 */
	public function addUrl($url, $title)
	{
		$this->breadcrumbs->add(compact('url', 'title'));
	}

	/**
	 * Add a path to the breadcrumbs
	 * @param Node $node
	 * @return string
	 */
	public function addNode(Node $node)
	{
		$this->breadcrumbs->add([
			'title' => $node->title,
			'url' => $node->getUrl(),
			'data' => $node->data
		]);
	}

	public function getBreadcrumbs () {
		return $this->breadcrumbs->getIterator();
	}

}
