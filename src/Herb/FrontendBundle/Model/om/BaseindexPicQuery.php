<?php

namespace Herb\FrontendBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Herb\FrontendBundle\Model\indexPic;
use Herb\FrontendBundle\Model\indexPicPeer;
use Herb\FrontendBundle\Model\indexPicQuery;

/**
 * @method indexPicQuery orderByipId($order = Criteria::ASC) Order by the ip_id column
 * @method indexPicQuery orderByipFilename($order = Criteria::ASC) Order by the ip_filename column
 * @method indexPicQuery orderByipDescription($order = Criteria::ASC) Order by the ip_description column
 * @method indexPicQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method indexPicQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method indexPicQuery groupByipId() Group by the ip_id column
 * @method indexPicQuery groupByipFilename() Group by the ip_filename column
 * @method indexPicQuery groupByipDescription() Group by the ip_description column
 * @method indexPicQuery groupByCreatedAt() Group by the created_at column
 * @method indexPicQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method indexPicQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method indexPicQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method indexPicQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method indexPic findOne(PropelPDO $con = null) Return the first indexPic matching the query
 * @method indexPic findOneOrCreate(PropelPDO $con = null) Return the first indexPic matching the query, or a new indexPic object populated from the query conditions when no match is found
 *
 * @method indexPic findOneByipFilename(string $ip_filename) Return the first indexPic filtered by the ip_filename column
 * @method indexPic findOneByipDescription(string $ip_description) Return the first indexPic filtered by the ip_description column
 * @method indexPic findOneByCreatedAt(string $created_at) Return the first indexPic filtered by the created_at column
 * @method indexPic findOneByUpdatedAt(string $updated_at) Return the first indexPic filtered by the updated_at column
 *
 * @method array findByipId(int $ip_id) Return indexPic objects filtered by the ip_id column
 * @method array findByipFilename(string $ip_filename) Return indexPic objects filtered by the ip_filename column
 * @method array findByipDescription(string $ip_description) Return indexPic objects filtered by the ip_description column
 * @method array findByCreatedAt(string $created_at) Return indexPic objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return indexPic objects filtered by the updated_at column
 */
abstract class BaseindexPicQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseindexPicQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'Herb\\FrontendBundle\\Model\\indexPic', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new indexPicQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     indexPicQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return indexPicQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof indexPicQuery) {
            return $criteria;
        }
        $query = new indexPicQuery();
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
     * @return   indexPic|indexPic[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = indexPicPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(indexPicPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return   indexPic A model object, or null if the key is not found
     * @throws   PropelException
     */
     public function findOneByipId($key, $con = null)
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
     * @return   indexPic A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `IP_ID`, `IP_FILENAME`, `IP_DESCRIPTION`, `CREATED_AT`, `UPDATED_AT` FROM `edf_indexpic` WHERE `IP_ID` = :p0';
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
            $obj = new indexPic();
            $obj->hydrate($row);
            indexPicPeer::addInstanceToPool($obj, (string) $key);
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
     * @return indexPic|indexPic[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|indexPic[]|mixed the list of results, formatted by the current formatter
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
     * @return indexPicQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(indexPicPeer::IP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return indexPicQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(indexPicPeer::IP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the ip_id column
     *
     * Example usage:
     * <code>
     * $query->filterByipId(1234); // WHERE ip_id = 1234
     * $query->filterByipId(array(12, 34)); // WHERE ip_id IN (12, 34)
     * $query->filterByipId(array('min' => 12)); // WHERE ip_id > 12
     * </code>
     *
     * @param     mixed $ipId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return indexPicQuery The current query, for fluid interface
     */
    public function filterByipId($ipId = null, $comparison = null)
    {
        if (is_array($ipId) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(indexPicPeer::IP_ID, $ipId, $comparison);
    }

    /**
     * Filter the query on the ip_filename column
     *
     * Example usage:
     * <code>
     * $query->filterByipFilename('fooValue');   // WHERE ip_filename = 'fooValue'
     * $query->filterByipFilename('%fooValue%'); // WHERE ip_filename LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ipFilename The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return indexPicQuery The current query, for fluid interface
     */
    public function filterByipFilename($ipFilename = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ipFilename)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ipFilename)) {
                $ipFilename = str_replace('*', '%', $ipFilename);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(indexPicPeer::IP_FILENAME, $ipFilename, $comparison);
    }

    /**
     * Filter the query on the ip_description column
     *
     * Example usage:
     * <code>
     * $query->filterByipDescription('fooValue');   // WHERE ip_description = 'fooValue'
     * $query->filterByipDescription('%fooValue%'); // WHERE ip_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ipDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return indexPicQuery The current query, for fluid interface
     */
    public function filterByipDescription($ipDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ipDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ipDescription)) {
                $ipDescription = str_replace('*', '%', $ipDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(indexPicPeer::IP_DESCRIPTION, $ipDescription, $comparison);
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
     * @return indexPicQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(indexPicPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(indexPicPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(indexPicPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return indexPicQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(indexPicPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(indexPicPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(indexPicPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   indexPic $indexPic Object to remove from the list of results
     *
     * @return indexPicQuery The current query, for fluid interface
     */
    public function prune($indexPic = null)
    {
        if ($indexPic) {
            $this->addUsingAlias(indexPicPeer::IP_ID, $indexPic->getipId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     indexPicQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(indexPicPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     indexPicQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(indexPicPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     indexPicQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(indexPicPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     indexPicQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(indexPicPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     indexPicQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(indexPicPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     indexPicQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(indexPicPeer::CREATED_AT);
    }
}
