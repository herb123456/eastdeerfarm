<?php

namespace Herb\FrontendBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Herb\FrontendBundle\Model\productType;
use Herb\FrontendBundle\Model\productTypePeer;
use Herb\FrontendBundle\Model\productTypeQuery;
use Herb\FrontendBundle\Model\products;

/**
 * @method productTypeQuery orderByptId($order = Criteria::ASC) Order by the pt_id column
 * @method productTypeQuery orderByptName($order = Criteria::ASC) Order by the pt_name column
 * @method productTypeQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method productTypeQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method productTypeQuery groupByptId() Group by the pt_id column
 * @method productTypeQuery groupByptName() Group by the pt_name column
 * @method productTypeQuery groupByCreatedAt() Group by the created_at column
 * @method productTypeQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method productTypeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method productTypeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method productTypeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method productTypeQuery leftJoinproducts($relationAlias = null) Adds a LEFT JOIN clause to the query using the products relation
 * @method productTypeQuery rightJoinproducts($relationAlias = null) Adds a RIGHT JOIN clause to the query using the products relation
 * @method productTypeQuery innerJoinproducts($relationAlias = null) Adds a INNER JOIN clause to the query using the products relation
 *
 * @method productType findOne(PropelPDO $con = null) Return the first productType matching the query
 * @method productType findOneOrCreate(PropelPDO $con = null) Return the first productType matching the query, or a new productType object populated from the query conditions when no match is found
 *
 * @method productType findOneByptName(string $pt_name) Return the first productType filtered by the pt_name column
 * @method productType findOneByCreatedAt(string $created_at) Return the first productType filtered by the created_at column
 * @method productType findOneByUpdatedAt(string $updated_at) Return the first productType filtered by the updated_at column
 *
 * @method array findByptId(int $pt_id) Return productType objects filtered by the pt_id column
 * @method array findByptName(string $pt_name) Return productType objects filtered by the pt_name column
 * @method array findByCreatedAt(string $created_at) Return productType objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return productType objects filtered by the updated_at column
 */
abstract class BaseproductTypeQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseproductTypeQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'Herb\\FrontendBundle\\Model\\productType', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new productTypeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     productTypeQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return productTypeQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof productTypeQuery) {
            return $criteria;
        }
        $query = new productTypeQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   productType|productType[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = productTypePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(productTypePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return   productType A model object, or null if the key is not found
     * @throws   PropelException
     */
     public function findOneByptId($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return   productType A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `PT_ID`, `PT_NAME`, `CREATED_AT`, `UPDATED_AT` FROM `edf_productType` WHERE `PT_ID` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new productType();
            $obj->hydrate($row);
            productTypePeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return productType|productType[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|productType[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return productTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(productTypePeer::PT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return productTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(productTypePeer::PT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the pt_id column
     *
     * Example usage:
     * <code>
     * $query->filterByptId(1234); // WHERE pt_id = 1234
     * $query->filterByptId(array(12, 34)); // WHERE pt_id IN (12, 34)
     * $query->filterByptId(array('min' => 12)); // WHERE pt_id > 12
     * </code>
     *
     * @param     mixed $ptId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return productTypeQuery The current query, for fluid interface
     */
    public function filterByptId($ptId = null, $comparison = null)
    {
        if (is_array($ptId) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(productTypePeer::PT_ID, $ptId, $comparison);
    }

    /**
     * Filter the query on the pt_name column
     *
     * Example usage:
     * <code>
     * $query->filterByptName('fooValue');   // WHERE pt_name = 'fooValue'
     * $query->filterByptName('%fooValue%'); // WHERE pt_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ptName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return productTypeQuery The current query, for fluid interface
     */
    public function filterByptName($ptName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ptName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ptName)) {
                $ptName = str_replace('*', '%', $ptName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(productTypePeer::PT_NAME, $ptName, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return productTypeQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(productTypePeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(productTypePeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(productTypePeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return productTypeQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(productTypePeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(productTypePeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(productTypePeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related products object
     *
     * @param   products|PropelObjectCollection $products  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   productTypeQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByproducts($products, $comparison = null)
    {
        if ($products instanceof products) {
            return $this
                ->addUsingAlias(productTypePeer::PT_ID, $products->getprodCatgory(), $comparison);
        } elseif ($products instanceof PropelObjectCollection) {
            return $this
                ->useproductsQuery()
                ->filterByPrimaryKeys($products->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByproducts() only accepts arguments of type products or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the products relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return productTypeQuery The current query, for fluid interface
     */
    public function joinproducts($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('products');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'products');
        }

        return $this;
    }

    /**
     * Use the products relation products object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Herb\FrontendBundle\Model\productsQuery A secondary query class using the current class as primary query
     */
    public function useproductsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinproducts($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'products', '\Herb\FrontendBundle\Model\productsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   productType $productType Object to remove from the list of results
     *
     * @return productTypeQuery The current query, for fluid interface
     */
    public function prune($productType = null)
    {
        if ($productType) {
            $this->addUsingAlias(productTypePeer::PT_ID, $productType->getptId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     productTypeQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(productTypePeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     productTypeQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(productTypePeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     productTypeQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(productTypePeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     productTypeQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(productTypePeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     productTypeQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(productTypePeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     productTypeQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(productTypePeer::CREATED_AT);
    }
}
