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
use Herb\FrontendBundle\Model\book;
use Herb\FrontendBundle\Model\bookPeer;
use Herb\FrontendBundle\Model\bookQuery;

/**
 * @method bookQuery orderBybookId($order = Criteria::ASC) Order by the book_id column
 * @method bookQuery orderBybookName($order = Criteria::ASC) Order by the book_name column
 * @method bookQuery orderBybookEmail($order = Criteria::ASC) Order by the book_email column
 * @method bookQuery orderBybookContent($order = Criteria::ASC) Order by the book_content column
 * @method bookQuery orderBybookAnswer($order = Criteria::ASC) Order by the book_answer column
 * @method bookQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method bookQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method bookQuery groupBybookId() Group by the book_id column
 * @method bookQuery groupBybookName() Group by the book_name column
 * @method bookQuery groupBybookEmail() Group by the book_email column
 * @method bookQuery groupBybookContent() Group by the book_content column
 * @method bookQuery groupBybookAnswer() Group by the book_answer column
 * @method bookQuery groupByCreatedAt() Group by the created_at column
 * @method bookQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method bookQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method bookQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method bookQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method book findOne(PropelPDO $con = null) Return the first book matching the query
 * @method book findOneOrCreate(PropelPDO $con = null) Return the first book matching the query, or a new book object populated from the query conditions when no match is found
 *
 * @method book findOneBybookName(string $book_name) Return the first book filtered by the book_name column
 * @method book findOneBybookEmail(string $book_email) Return the first book filtered by the book_email column
 * @method book findOneBybookContent(string $book_content) Return the first book filtered by the book_content column
 * @method book findOneBybookAnswer(string $book_answer) Return the first book filtered by the book_answer column
 * @method book findOneByCreatedAt(string $created_at) Return the first book filtered by the created_at column
 * @method book findOneByUpdatedAt(string $updated_at) Return the first book filtered by the updated_at column
 *
 * @method array findBybookId(int $book_id) Return book objects filtered by the book_id column
 * @method array findBybookName(string $book_name) Return book objects filtered by the book_name column
 * @method array findBybookEmail(string $book_email) Return book objects filtered by the book_email column
 * @method array findBybookContent(string $book_content) Return book objects filtered by the book_content column
 * @method array findBybookAnswer(string $book_answer) Return book objects filtered by the book_answer column
 * @method array findByCreatedAt(string $created_at) Return book objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return book objects filtered by the updated_at column
 */
abstract class BasebookQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BasebookQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'Herb\\FrontendBundle\\Model\\book', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new bookQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     bookQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return bookQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof bookQuery) {
            return $criteria;
        }
        $query = new bookQuery();
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
     * @return   book|book[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = bookPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(bookPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return   book A model object, or null if the key is not found
     * @throws   PropelException
     */
     public function findOneBybookId($key, $con = null)
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
     * @return   book A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `BOOK_ID`, `BOOK_NAME`, `BOOK_EMAIL`, `BOOK_CONTENT`, `BOOK_ANSWER`, `CREATED_AT`, `UPDATED_AT` FROM `edf_book` WHERE `BOOK_ID` = :p0';
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
            $obj = new book();
            $obj->hydrate($row);
            bookPeer::addInstanceToPool($obj, (string) $key);
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
     * @return book|book[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|book[]|mixed the list of results, formatted by the current formatter
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
     * @return bookQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(bookPeer::BOOK_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return bookQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(bookPeer::BOOK_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the book_id column
     *
     * Example usage:
     * <code>
     * $query->filterBybookId(1234); // WHERE book_id = 1234
     * $query->filterBybookId(array(12, 34)); // WHERE book_id IN (12, 34)
     * $query->filterBybookId(array('min' => 12)); // WHERE book_id > 12
     * </code>
     *
     * @param     mixed $bookId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return bookQuery The current query, for fluid interface
     */
    public function filterBybookId($bookId = null, $comparison = null)
    {
        if (is_array($bookId) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(bookPeer::BOOK_ID, $bookId, $comparison);
    }

    /**
     * Filter the query on the book_name column
     *
     * Example usage:
     * <code>
     * $query->filterBybookName('fooValue');   // WHERE book_name = 'fooValue'
     * $query->filterBybookName('%fooValue%'); // WHERE book_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bookName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return bookQuery The current query, for fluid interface
     */
    public function filterBybookName($bookName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bookName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bookName)) {
                $bookName = str_replace('*', '%', $bookName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(bookPeer::BOOK_NAME, $bookName, $comparison);
    }

    /**
     * Filter the query on the book_email column
     *
     * Example usage:
     * <code>
     * $query->filterBybookEmail('fooValue');   // WHERE book_email = 'fooValue'
     * $query->filterBybookEmail('%fooValue%'); // WHERE book_email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bookEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return bookQuery The current query, for fluid interface
     */
    public function filterBybookEmail($bookEmail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bookEmail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bookEmail)) {
                $bookEmail = str_replace('*', '%', $bookEmail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(bookPeer::BOOK_EMAIL, $bookEmail, $comparison);
    }

    /**
     * Filter the query on the book_content column
     *
     * Example usage:
     * <code>
     * $query->filterBybookContent('fooValue');   // WHERE book_content = 'fooValue'
     * $query->filterBybookContent('%fooValue%'); // WHERE book_content LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bookContent The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return bookQuery The current query, for fluid interface
     */
    public function filterBybookContent($bookContent = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bookContent)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bookContent)) {
                $bookContent = str_replace('*', '%', $bookContent);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(bookPeer::BOOK_CONTENT, $bookContent, $comparison);
    }

    /**
     * Filter the query on the book_answer column
     *
     * Example usage:
     * <code>
     * $query->filterBybookAnswer('fooValue');   // WHERE book_answer = 'fooValue'
     * $query->filterBybookAnswer('%fooValue%'); // WHERE book_answer LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bookAnswer The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return bookQuery The current query, for fluid interface
     */
    public function filterBybookAnswer($bookAnswer = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bookAnswer)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bookAnswer)) {
                $bookAnswer = str_replace('*', '%', $bookAnswer);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(bookPeer::BOOK_ANSWER, $bookAnswer, $comparison);
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
     * @return bookQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(bookPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(bookPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(bookPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return bookQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(bookPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(bookPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(bookPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   book $book Object to remove from the list of results
     *
     * @return bookQuery The current query, for fluid interface
     */
    public function prune($book = null)
    {
        if ($book) {
            $this->addUsingAlias(bookPeer::BOOK_ID, $book->getbookId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     bookQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(bookPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     bookQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(bookPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     bookQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(bookPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     bookQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(bookPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     bookQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(bookPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     bookQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(bookPeer::CREATED_AT);
    }
}
