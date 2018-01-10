<?php
namespace Kit\PaginatorBundle\Twig;

class PaginationExtension extends \Twig_Extension
{
    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('kit_pagination_render', array($this, 'render'), array('is_safe' => array('html'), 'needs_environment' => true)),
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
    public function render(\Twig_Environment $env, $pagination, $template = null, array $queryParams = array(), array $viewParams = array())
    {
        $pagination['query'] = array_merge($pagination['query'], $queryParams);
        return $env->render( $template, array_merge($pagination, $viewParams));
    }
}