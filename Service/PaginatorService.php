<?php
namespace Kit\PaginatorBundle\Service;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\RequestStack;

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

    function paginate($query, $page, $pagesize, $connection = null)
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($connection instanceof Connection) {
            $this->connection = $connection;
        }
        $offset = ($page - 1) * $pagesize;
        $countQuery = preg_replace("/SELECT(.*)FROM/i", 'SELECT count(*) as total FROM', $query);
        $total = $this->connection->executeQuery($countQuery)->fetchColumn(0);
        $pages = intval(ceil($total / $pagesize));
        $query .= ' LIMIT ' . $offset . ',' . $pagesize;
        $list = $this->connection->executeQuery($query)->fetchAll();
        $pageInRange = [];
        if ($page < $pages) {
            for ($i = 0; $i < 8; $i ++) {
                if ($page + $i > $pages)
                    break;
                array_push($pageInRange, $page + $i);
            }
        } else {
            for ($i = 0; $i < 8; $i ++) {
                if ($page - $i < 1)
                    break;
                array_unshift($pageInRange, $page - $i);
            }
        }
        $pageData = [
            'items' => $list,
            'pageParameterName' => 'page',
            "current" => $page,
            "numItemsPerPage" => $pagesize,
            "pageCount" => $pages,
            "totalCount" => $total,
            "pageRange" => count($pageInRange),
            "pagesInRange" => $pageInRange,
            "startPage" => min($pageInRange),
            "endPage" => max($pageInRange),
            "currentItemCount" => count($list),
            "route" => $request->get('_route'),
            "query" => $request->query->all()
        ];
        if ($page - 1 > 0) {
            $pageData['previous'] = $page - 1;
        }
        if ($page + 1 < $pages) {
            $pageData['next'] = $page + 1;
        }
        return $pageData;
    }
}