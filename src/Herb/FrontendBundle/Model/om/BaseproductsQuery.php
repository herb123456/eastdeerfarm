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
use Herb\FrontendBundle\Model\products;
use Herb\FrontendBundle\Model\productsPeer;
use Herb\FrontendBundle\Model\productsQuery;

/**
 * @method productsQuery orderByprodId($order = Criteria::ASC) Order by the prod_id column
 * @method productsQuery orderByprodName($order = Criteria::ASC) Order by the prod_name column
 * @method productsQuery orderByprodPrice($order = Criteria::ASC) Order by the prod_price column
 * @method productsQuery orderByprodUnit($order = Criteria::ASC) Order by the prod_unit column
 * @method productsQuery orderByprodCatgory($order = Criteria::ASC) Order by the prod_catgory column
 * @method productsQuery orderByprodPic($order = Criteria::ASC) Order by the prod_pic column
 * @method productsQuery orderByprodUrl($order = Criteria::ASC) Order by the prod_url column
 * @method productsQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method productsQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method productsQuery groupByprodId() Group by the prod_id column
 * @method productsQuery groupByprodName() Group by the prod_name column
 * @method productsQuery groupByprodPrice() Group by the prod_price column
 * @method productsQuery groupByprodUnit() Group by the prod_unit column
 * @method productsQuery groupByprodCatgory() Group by the prod_catgory column
 * @method productsQuery groupByprodPic() Group by the prod_pic column
 * @method productsQuery groupByprodUrl() Group by the prod_url column
 * @method productsQuery groupByCreatedAt() Group by the created_at column
 * @method productsQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method productsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method productsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method productsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method productsQuery leftJoinproductType($relationAlias = null) Adds a LEFT JOIN clause to the query using the productType relation
 * @method productsQuery rightJoinproductType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the productType relation
 * @method productsQuery innerJoinproductType($relationAlias = null) Adds a INNER JOIN clause to the query using the productType relation
 *
 * @method products findOne(PropelPDO $con = null) Return the first products matching the query
 * @method products findOneOrCreate(PropelPDO $con = null) Return the first products matching the query, or a new products object populated from the query conditions when no match is found
 *
 * @method products findOneByprodName(string $prod_name) Return the first products filtered by the prod_name column
 * @method products findOneByprodPrice(int $prod_price) Return the first products filtered by the prod_price column
 * @method products findOneByprodUnit(string $prod_unit) Return the first products filtered by the prod_unit column
 * @method products findOneByprodCatgory(int $prod_catgory) Return the first products filtered by the prod_catgory column
 * @method products findOneByprodPic(string $prod_pic) Return the first products filtered by the prod_pic column
 * @method products findOneByprodUrl(string $prod_url) Return the first products filtered by the prod_url column
 * @method products findOneByCreatedAt(string $created_at) Return the first products filtered by the created_at column
 * @method products findOneByUpdatedAt(string $updated_at) Return the first products filtered by the updated_at column
 *
 * @method array findByprodId(int $prod_id) Return products objects filtered by the prod_id column
 * @method array findByprodName(string $prod_name) Return products objects filtered by the prod_name column
 * @method array findByprodPrice(int $prod_price) Return products objects filtered by the prod_price column
 * @method array findByprodUnit(string $prod_unit) Return products objects filtered by the prod_unit column
 * @method array findByprodCatgory(int $prod_catgory) Return products objects filtered by the prod_catgory column
 * @method array findByprodPic(string $prod_pic) Return products objects filtered by the prod_pic column
 * @method array findByprodUrl(string $prod_url) Return products objects filtered by the prod_url column
 * @method array findByCreatedAt(string $created_at) Return products objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return products objects filtered by the updated_at column
 */
abstract class BaseproductsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseproductsQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'Herb\\FrontendBundle\\Model\\products', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new productsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     productsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return productsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof productsQuery) {
            return $criteria;
        }
        $query = new productsQuery();
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
     * @return   products|products[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = productsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(productsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return   products A model object, or null if the key is not found
     * @throws   PropelException
     */
     public function findOneByprodId($key, $con = null)
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
     * @return   products A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `PROD_ID`, `PROD_NAME`, `PROD_PRICE`, `PROD_UNIT`, `PROD_CATGORY`, `PROD_PIC`, `PROD_URL`, `CREATED_AT`, `UPDATED_AT` FROM `edf_products` WHERE `PROD_ID` = :p0';
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
            $obj = new products();
            $obj->hydrate($row);
            productsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return products|products[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|products[]|mixed the list of results, formatted by the current formatter
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
     * @return productsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(productsPeer::PROD_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return productsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(productsPeer::PROD_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the prod_id column
     *
     * Example usage:
     * <code>
     * $query->filterByprodId(1234); // WHERE prod_id = 1234
     * $query->filterByprodId(array(12, 34)); // WHERE prod_id IN (12, 34)
     * $query->filterByprodId(array('min' => 12)); // WHERE prod_id > 12
     * </code>
     *
     * @param     mixed $prodId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return productsQuery The current query, for fluid interface
     */
    public function filterByprodId($prodId = null, $comparison = null)
    {
        if (is_array($prodId) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(productsPeer::PROD_ID, $prodId, $comparison);
    }

    /**
     * Filter the query on the prod_name column
     *
     * Example usage:
     * <code>
     * $query->filterByprodName('fooValue');   // WHERE prod_name = 'fooValue'
     * $query->filterByprodName('%fooValue%'); // WHERE prod_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $prodName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return productsQuery The current query, for fluid interface
     */
    public function filterByprodName($prodName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($prodName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $prodName)) {
                $prodName = str_replace('*', '%', $prodName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(productsPeer::PROD_NAME, $prodName, $comparison);
    }

    /**
     * Filter the query on the prod_price column
     *
     * Example usage:
     * <code>
     * $query->filterByprodPrice(1234); // WHERE prod_price = 1234
     * $query->filterByprodPrice(array(12, 34)); // WHERE prod_price IN (12, 34)
     * $query->filterByprodPrice(array('min' => 12)); // WHERE prod_price > 12
     * </code>
     *
     * @param     mixed $prodPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return productsQuery The current query, for fluid interface
     */
    public function filterByprodPrice($prodPrice = null, $comparison = null)
    {
        if (is_array($prodPrice)) {
            $useMinMax = false;
            if (isset($prodPrice['min'])) {
                $this->addUsingAlias(productsPeer::PROD_PRICE, $prodPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prodPrice['max'])) {
                $this->addUsingAlias(productsPeer::PROD_PRICE, $prodPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(productsPeer::PROD_PRICE, $prodPrice, $comparison);
    }

    /**
     * Filter the query on the prod_unit column
     *
     * Example usage:
     * <code>
     * $query->filterByprodUnit('fooValue');   // WHERE prod_unit = 'fooValue'
     * $query->filterByprodUnit('%fooValue%'); // WHERE prod_unit LIKE '%fooValue%'
     * </code>
     *
     * @param     string $prodUnit The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return productsQuery The current query, for fluid interface
     */
    public function filterByprodUnit($prodUnit = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($prodUnit)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $prodUnit)) {
                $prodUnit = str_replace('*', '%', $prodUnit);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(productsPeer::PROD_UNIT, $prodUnit, $comparison);
    }

    /**
     * Filter the query on the prod_catgory column
     *
     * Example usage:
     * <code>
     * $query->filterByprodCatgory(1234); // WHERE prod_catgory = 1234
     * $query->filterByprodCatgory(array(12, 34)); // WHERE prod_catgory IN (12, 34)
     * $query->filterByprodCatgory(array('min' => 12)); // WHERE prod_catgory > 12
     * </code>
     *
     * @see       filterByproductType()
     *
     * @param     mixed $prodCatgory The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return productsQuery The current query, for fluid interface
     */
    public function filterByprodCatgory($prodCatgory = null, $comparison = null)
    {
        if (is_array($prodCatgory)) {
            $useMinMax = false;
            if (isset($prodCatgory['min'])) {
                $this->addUsingAlias(productsPeer::PROD_CATGORY, $prodCatgory['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prodCatgory['max'])) {
                $this->addUsingAlias(productsPeer::PROD_CATGORY, $prodCatgory['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(productsPeer::PROD_CATGORY, $prodCatgory, $comparison);
    }

    /**
     * Filter the query on the prod_pic column
     *
     * Example usage:
     * <code>
     * $query->filterByprodPic('fooValue');   // WHERE prod_pic = 'fooValue'
     * $query->filterByprodPic('%fooValue%'); // WHERE prod_pic LIKE '%fooValue%'
     * </code>
     *
     * @param     string $prodPic The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return productsQuery The current query, for fluid interface
     */
    public function filterByprodPic($prodPic = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($prodPic)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $prodPic)) {
                $prodPic = str_replace('*', '%', $prodPic);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(productsPeer::PROD_PIC, $prodPic, $comparison);
    }

    /**
     * Filter the query on the prod_url column
     *
     * Example usage:
     * <code>
     * $query->filterByprodUrl('fooValue');   // WHERE prod_url = 'fooValue'
     * $query->filterByprodUrl('%fooValue%'); // WHERE prod_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $prodUrl The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return productsQuery The current query, for fluid interface
     */
    public function filterByprodUrl($prodUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($prodUrl)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $prodUrl)) {
                $prodUrl = str_replace('*', '%', $prodUrl);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(productsPeer::PROD_URL, $prodUrl, $comparison);
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
     * @return productsQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(productsPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(productsPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(productsPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return productsQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(productsPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(productsPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(productsPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related productType object
     *
     * @param   productType|PropelObjectCollection $productType The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   productsQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByproductType($productType, $comparison = null)
    {
        if ($productType instanceof productType) {
            return $this
                ->addUsingAlias(productsPeer::PROD_CATGORY, $productType->getptId(), $comparison);
        } elseif ($productType instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(productsPeer::PROD_CATGORY, $productType->toKeyValue('PrimaryKey', 'ptId'), $comparison);
        } else {
            throw new PropelException('filterByproductType() only accepts arguments of type productType or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the productType relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return productsQuery The current query, for fluid interface
     */
    public function joinproductType($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('productType');

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
            $this->addJoinObject($join, 'productType');
        }

        return $this;
    }

    /**
     * Use the productType relation productType object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Herb\FrontendBundle\Model\productTypeQuery A secondary query class using the current class as primary query
     */
    public function useproductTypeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinproductType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'productType', '\Herb\FrontendBundle\Model\productTypeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   products $products Object to remove from the list of results
     *
     * @return productsQuery The current query, for fluid interface
     */
    public function prune($products = null)
    {
        if ($products) {
            $this->addUsingAlias(productsPeer::PROD_ID, $products->getprodId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     productsQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(productsPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     productsQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(productsPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     productsQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(productsPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     productsQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(productsPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     productsQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(productsPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     productsQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(productsPeer::CREATED_AT);
    }
}
