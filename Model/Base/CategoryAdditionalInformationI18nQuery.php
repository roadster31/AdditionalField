<?php

namespace AdditionalField\Model\Base;

use \Exception;
use \PDO;
use AdditionalField\Model\CategoryAdditionalInformationI18n as ChildCategoryAdditionalInformationI18n;
use AdditionalField\Model\CategoryAdditionalInformationI18nQuery as ChildCategoryAdditionalInformationI18nQuery;
use AdditionalField\Model\Map\CategoryAdditionalInformationI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'category_additional_information_i18n' table.
 *
 *
 *
 * @method     ChildCategoryAdditionalInformationI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCategoryAdditionalInformationI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildCategoryAdditionalInformationI18nQuery orderByInformation($order = Criteria::ASC) Order by the information column
 *
 * @method     ChildCategoryAdditionalInformationI18nQuery groupById() Group by the id column
 * @method     ChildCategoryAdditionalInformationI18nQuery groupByLocale() Group by the locale column
 * @method     ChildCategoryAdditionalInformationI18nQuery groupByInformation() Group by the information column
 *
 * @method     ChildCategoryAdditionalInformationI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCategoryAdditionalInformationI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCategoryAdditionalInformationI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCategoryAdditionalInformationI18nQuery leftJoinCategoryAdditionalInformation($relationAlias = null) Adds a LEFT JOIN clause to the query using the CategoryAdditionalInformation relation
 * @method     ChildCategoryAdditionalInformationI18nQuery rightJoinCategoryAdditionalInformation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CategoryAdditionalInformation relation
 * @method     ChildCategoryAdditionalInformationI18nQuery innerJoinCategoryAdditionalInformation($relationAlias = null) Adds a INNER JOIN clause to the query using the CategoryAdditionalInformation relation
 *
 * @method     ChildCategoryAdditionalInformationI18n findOne(ConnectionInterface $con = null) Return the first ChildCategoryAdditionalInformationI18n matching the query
 * @method     ChildCategoryAdditionalInformationI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCategoryAdditionalInformationI18n matching the query, or a new ChildCategoryAdditionalInformationI18n object populated from the query conditions when no match is found
 *
 * @method     ChildCategoryAdditionalInformationI18n findOneById(int $id) Return the first ChildCategoryAdditionalInformationI18n filtered by the id column
 * @method     ChildCategoryAdditionalInformationI18n findOneByLocale(string $locale) Return the first ChildCategoryAdditionalInformationI18n filtered by the locale column
 * @method     ChildCategoryAdditionalInformationI18n findOneByInformation(string $information) Return the first ChildCategoryAdditionalInformationI18n filtered by the information column
 *
 * @method     array findById(int $id) Return ChildCategoryAdditionalInformationI18n objects filtered by the id column
 * @method     array findByLocale(string $locale) Return ChildCategoryAdditionalInformationI18n objects filtered by the locale column
 * @method     array findByInformation(string $information) Return ChildCategoryAdditionalInformationI18n objects filtered by the information column
 *
 */
abstract class CategoryAdditionalInformationI18nQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \AdditionalField\Model\Base\CategoryAdditionalInformationI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\AdditionalField\\Model\\CategoryAdditionalInformationI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCategoryAdditionalInformationI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCategoryAdditionalInformationI18nQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \AdditionalField\Model\CategoryAdditionalInformationI18nQuery) {
            return $criteria;
        }
        $query = new \AdditionalField\Model\CategoryAdditionalInformationI18nQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $locale] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCategoryAdditionalInformationI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CategoryAdditionalInformationI18nTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CategoryAdditionalInformationI18nTableMap::DATABASE_NAME);
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
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildCategoryAdditionalInformationI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, LOCALE, INFORMATION FROM category_additional_information_i18n WHERE ID = :p0 AND LOCALE = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildCategoryAdditionalInformationI18n();
            $obj->hydrate($row);
            CategoryAdditionalInformationI18nTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildCategoryAdditionalInformationI18n|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildCategoryAdditionalInformationI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CategoryAdditionalInformationI18nTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CategoryAdditionalInformationI18nTableMap::LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCategoryAdditionalInformationI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CategoryAdditionalInformationI18nTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CategoryAdditionalInformationI18nTableMap::LOCALE, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @see       filterByCategoryAdditionalInformation()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCategoryAdditionalInformationI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CategoryAdditionalInformationI18nTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CategoryAdditionalInformationI18nTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CategoryAdditionalInformationI18nTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%'); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCategoryAdditionalInformationI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $locale)) {
                $locale = str_replace('*', '%', $locale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CategoryAdditionalInformationI18nTableMap::LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the information column
     *
     * Example usage:
     * <code>
     * $query->filterByInformation('fooValue');   // WHERE information = 'fooValue'
     * $query->filterByInformation('%fooValue%'); // WHERE information LIKE '%fooValue%'
     * </code>
     *
     * @param     string $information The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCategoryAdditionalInformationI18nQuery The current query, for fluid interface
     */
    public function filterByInformation($information = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($information)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $information)) {
                $information = str_replace('*', '%', $information);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CategoryAdditionalInformationI18nTableMap::INFORMATION, $information, $comparison);
    }

    /**
     * Filter the query by a related \AdditionalField\Model\CategoryAdditionalInformation object
     *
     * @param \AdditionalField\Model\CategoryAdditionalInformation|ObjectCollection $categoryAdditionalInformation The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCategoryAdditionalInformationI18nQuery The current query, for fluid interface
     */
    public function filterByCategoryAdditionalInformation($categoryAdditionalInformation, $comparison = null)
    {
        if ($categoryAdditionalInformation instanceof \AdditionalField\Model\CategoryAdditionalInformation) {
            return $this
                ->addUsingAlias(CategoryAdditionalInformationI18nTableMap::ID, $categoryAdditionalInformation->getId(), $comparison);
        } elseif ($categoryAdditionalInformation instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CategoryAdditionalInformationI18nTableMap::ID, $categoryAdditionalInformation->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCategoryAdditionalInformation() only accepts arguments of type \AdditionalField\Model\CategoryAdditionalInformation or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CategoryAdditionalInformation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildCategoryAdditionalInformationI18nQuery The current query, for fluid interface
     */
    public function joinCategoryAdditionalInformation($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CategoryAdditionalInformation');

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
            $this->addJoinObject($join, 'CategoryAdditionalInformation');
        }

        return $this;
    }

    /**
     * Use the CategoryAdditionalInformation relation CategoryAdditionalInformation object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \AdditionalField\Model\CategoryAdditionalInformationQuery A secondary query class using the current class as primary query
     */
    public function useCategoryAdditionalInformationQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinCategoryAdditionalInformation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CategoryAdditionalInformation', '\AdditionalField\Model\CategoryAdditionalInformationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCategoryAdditionalInformationI18n $categoryAdditionalInformationI18n Object to remove from the list of results
     *
     * @return ChildCategoryAdditionalInformationI18nQuery The current query, for fluid interface
     */
    public function prune($categoryAdditionalInformationI18n = null)
    {
        if ($categoryAdditionalInformationI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CategoryAdditionalInformationI18nTableMap::ID), $categoryAdditionalInformationI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CategoryAdditionalInformationI18nTableMap::LOCALE), $categoryAdditionalInformationI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the category_additional_information_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CategoryAdditionalInformationI18nTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CategoryAdditionalInformationI18nTableMap::clearInstancePool();
            CategoryAdditionalInformationI18nTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCategoryAdditionalInformationI18n or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCategoryAdditionalInformationI18n object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CategoryAdditionalInformationI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CategoryAdditionalInformationI18nTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        CategoryAdditionalInformationI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CategoryAdditionalInformationI18nTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // CategoryAdditionalInformationI18nQuery
