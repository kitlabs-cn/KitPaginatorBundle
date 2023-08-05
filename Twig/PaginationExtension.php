<?php
namespace Kit\PaginatorBundle\Twig;

class PaginationExtension implements \Twig\Extension\ExtensionInterface
{
	/**
	 * Returns the token parser instances to add to the existing list.
	 *
	 * @return \Twig\TokenParser\TokenParserInterface[]
	 */
	public function getTokenParsers(){}
	
	/**
	 * Returns the node visitor instances to add to the existing list.
	 *
	 * @return \Twig\NodeVisitor\NodeVisitorInterface[]
	 */
	public function getNodeVisitors(){}
	
	/**
	 * Returns a list of filters to add to the existing list.
	 *
	 * @return \Twig\TwigFilter[]
	 */
	public function getFilters(){}
	
	/**
	 * Returns a list of tests to add to the existing list.
	 *
	 * @return \Twig\TwigTest[]
	 */
	public function getTests(){}
	
	/**
	 * Returns a list of operators to add to the existing list.
	 *
	 * @return array<array> First array of unary operators, second array of binary operators
	 */
	public function getOperators(){}
	/**
	 * {@inheritDoc}
	 */
	public function getFunctions()
	{
		return array(
				new \Twig\TwigFunction('kit_pagination_render', array($this, 'render'), array('is_safe' => array('html'), 'needs_environment' => true)),
		);
	}
	
	/**
	 * Renders the pagination template
	 *
	 * @param \Twig_Environment $env
	 * @param SlidingPagination $pagination
	 * @param string            $template
	 * @param array             $queryParams
	 * @param array             $viewParams
	 *
	 * @return string
	 */
	public function render(\Twig\Environment $env, $pagination, $template = null, array $queryParams = array(), array $viewParams = array())
	{
		$pagination['query'] = array_merge($pagination['query'], $queryParams);
		return $env->render( $template, array_merge($pagination, $viewParams));
	}
}
