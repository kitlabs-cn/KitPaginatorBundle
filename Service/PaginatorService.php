<?php
namespace Kit\PaginatorBundle\Service;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\RequestStack;
use Knp\Component\Pager\Pagination\SlidingPagination;

class PaginatorService
{

    /**
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $connection = null;
    /**
     * 
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    public function __construct(Connection $connection, RequestStack $requestStack)
    {
        $this->connection = $connection;
        $this->requestStack = $requestStack;
    }

    function paginate($query, $page, $pagesize, $connection = null, $total = null)
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($connection instanceof Connection) {
            $this->connection = $connection;
        }
        $offset = ($page - 1) * $pagesize;
        if(is_null($total) || $total < 1){
            $countQuery = preg_replace("/SELECT(.*)FROM/i", 'SELECT count(*) as total FROM', $query);
            $total = $this->connection->executeQuery($countQuery)->fetchColumn(0);
        }
        $query .= ' LIMIT ' . $offset . ',' . $pagesize;
        $list = $this->connection->executeQuery($query)->fetchAll();
        $slidingPagination = new SlidingPagination($request->query->all());
        $slidingPagination->setCurrentPageNumber($page);
        $slidingPagination->setItemNumberPerPage($pagesize);
        $slidingPagination->setItems($list);
        $slidingPagination->setTotalItemCount($total);
        $slidingPagination->setPageRange(10);
        $slidingPagination->setPaginatorOptions([
            "pageParameterName" => "page",
            "sortFieldParameterName" => "sort",
            "sortDirectionParameterName" => "direction",
            "filterFieldParameterName" => "filterField",
            "filterValueParameterName" => "filterValue",
            "distinct" => true
        ]);
        $slidingPagination->setCustomParameters([]);
        return $slidingPagination;
    }
}