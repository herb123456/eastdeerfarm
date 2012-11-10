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
use Herb\FrontendBundle\Model\farmVideo;
use Herb\FrontendBundle\Model\farmVideoPeer;
use Herb\FrontendBundle\Model\farmVideoQuery;

/**
 * @method farmVideoQuery orderByfvId($order = Criteria::ASC) Order by the fv_id column
 * @method farmVideoQuery orderByfvCode($order = Criteria::ASC) Order by the fv_code column
 * @method farmVideoQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method farmVideoQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method farmVideoQuery groupByfvId() Group by the fv_id column
 * @method farmVideoQuery groupByfvCode() Group by the fv_code column
 * @method farmVideoQuery groupByCreatedAt() Group by the created_at column
 * @method farmVideoQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method farmVideoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method farmVideoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method farmVideoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method farmVideo findOne(PropelPDO $con = null) Return the first farmVideo matching the query
 * @method farmVideo findOneOrCreate(PropelPDO $con = null) Return the first farmVideo matching the query, or a new farmVideo object populated from the query conditions when no match is found
 *
 * @method farmVideo findOneByfvCode(string $fv_code) Return the first farmVideo filtered by the fv_code column
 * @method farmVideo findOneByCreatedAt(string $created_at) Return the first farmVideo filtered by the created_at column
 * @method farmVideo findOneByUpdatedAt(string $updated_at) Return the first farmVideo filtered by the updated_at column
 *
 * @method array findByfvId(int $fv_id) Return farmVideo objects filtered by the fv_id column
 * @method array findByfvCode(string $fv_code) Return farmVideo objects filtered by the fv_code column
 * @method array findByCreatedAt(string $created_at) Return farmVideo objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return farmVideo objects filtered by the updated_at column
 */
abstract class BasefarmVideoQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BasefarmVideoQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'Herb\\FrontendBundle\\Model\\farmVideo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new farmVideoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     farmVideoQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return farmVideoQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof farmVideoQuery) {
            return $criteria;
        }
        $query = new farmVideoQuery();
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
     * @return   farmVideo|farmVideo[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = farmVideoPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(farmVideoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return   farmVideo A model object, or null if the key is not found
     * @throws   PropelException
     */
     public function findOneByfvId($key, $con = null)
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
     * @return   farmVideo A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `FV_ID`, `FV_CODE`, `CREATED_AT`, `UPDATED_AT` FROM `edf_farmvideo` WHERE `FV_ID` = :p0';
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
            $obj = new farmVideo();
            $obj->hydrate($row);
            farmVideoPeer::addInstanceToPool($obj, (string) $key);
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
     * @return farmVideo|farmVideo[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|farmVideo[]|mixed the list of results, formatted by the current formatter
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
     * @return farmVideoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(farmVideoPeer::FV_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return farmVideoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(farmVideoPeer::FV_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the fv_id column
     *
     * Example usage:
     * <code>
     * $query->filterByfvId(1234); // WHERE fv_id = 1234
     * $query->filterByfvId(array(12, 34)); // WHERE fv_id IN (12, 34)
     * $query->filterByfvId(array('min' => 12)); // WHERE fv_id > 12
     * </code>
     *
     * @param     mixed $fvId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return farmVideoQuery The current query, for fluid interface
     */
    public function filterByfvId($fvId = null, $comparison = null)
    {
        if (is_array($fvId) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(farmVideoPeer::FV_ID, $fvId, $comparison);
    }

    /**
     * Filter the query on the fv_code column
     *
     * Example usage:
     * <code>
     * $query->filterByfvCode('fooValue');   // WHERE fv_code = 'fooValue'
     * $query->filterByfvCode('%fooValue%'); // WHERE fv_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fvCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return farmVideoQuery The current query, for fluid interface
     */
    public function filterByfvCode($fvCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fvCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fvCode)) {
                $fvCode = str_replace('*', '%', $fvCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(farmVideoPeer::FV_CODE, $fvCode, $comparison);
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
     * @return farmVideoQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(farmVideoPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(farmVideoPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(farmVideoPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return farmVideoQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(farmVideoPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(farmVideoPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(farmVideoPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   farmVideo $farmVideo Object to remove from the list of results
     *
     * @return farmVideoQuery The current query, for fluid interface
     */
    public function prune($farmVideo = null)
    {
        if ($farmVideo) {
            $this->addUsingAlias(farmVideoPeer::FV_ID, $farmVideo->getfvId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     farmVideoQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(farmVideoPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     farmVideoQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(farmVideoPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     farmVideoQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(farmVideoPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     farmVideoQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(farmVideoPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     farmVideoQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(farmVideoPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     farmVideoQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(farmVideoPeer::CREATED_AT);
    }
}
