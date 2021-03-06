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
     * Add an url to the breadcrumbs
     * @param $data
     * @return $this
     */
	public function addUrl($data)
	{
		$this->breadcrumbs->add($data);
		return $this;
	}

	/**
	 * Add a path to the breadcrumbs
	 * @param Node $node
	 * @return $this
	 */
	public function addNode(Node $node)
	{
		$this->breadcrumbs->add([
			'title' => $node->title,
			'url' => $node->getUrl(),
			'data' => $node->data
		]);
        return $this;
	}

	/**
	 * @return \ArrayIterator
	 */
	public function getBreadcrumbs () {
		return $this->breadcrumbs->getIterator();
	}

}
