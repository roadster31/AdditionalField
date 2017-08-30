<?php

namespace AdditionalField\Model\Base;

use \Exception;
use \PDO;
use AdditionalField\Model\ProductAdditionalInformation as ChildProductAdditionalInformation;
use AdditionalField\Model\ProductAdditionalInformationI18nQuery as ChildProductAdditionalInformationI18nQuery;
use AdditionalField\Model\ProductAdditionalInformationQuery as ChildProductAdditionalInformationQuery;
use AdditionalField\Model\Map\ProductAdditionalInformationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Thelia\Model\Product;

/**
 * Base class that represents a query for the 'product_additional_information' table.
 *
 *
 *
 * @method     ChildProductAdditionalInformationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildProductAdditionalInformationQuery orderByObjectId($order = Criteria::ASC) Order by the object_id column
 *
 * @method     ChildProductAdditionalInformationQuery groupById() Group by the id column
 * @method     ChildProductAdditionalInformationQuery groupByObjectId() Group by the object_id column
 *
 * @method     ChildProductAdditionalInformationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProductAdditionalInformationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProductAdditionalInformationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProductAdditionalInformationQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildProductAdditionalInformationQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildProductAdditionalInformationQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildProductAdditionalInformationQuery leftJoinProductAdditionalInformationI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductAdditionalInformationI18n relation
 * @method     ChildProductAdditionalInformationQuery rightJoinProductAdditionalInformationI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductAdditionalInformationI18n relation
 * @method     ChildProductAdditionalInformationQuery innerJoinProductAdditionalInformationI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductAdditionalInformationI18n relation
 *
 * @method     ChildProductAdditionalInformation findOne(ConnectionInterface $con = null) Return the first ChildProductAdditionalInformation matching the query
 * @method     ChildProductAdditionalInformation findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProductAdditionalInformation matching the query, or a new ChildProductAdditionalInformation object populated from the query conditions when no match is found
 *
 * @method     ChildProductAdditionalInformation findOneById(int $id) Return the first ChildProductAdditionalInformation filtered by the id column
 * @method     ChildProductAdditionalInformation findOneByObjectId(int $object_id) Return the first ChildProductAdditionalInformation filtered by the object_id column
 *
 * @method     array findById(int $id) Return ChildProductAdditionalInformation objects filtered by the id column
 * @method     array findByObjectId(int $object_id) Return ChildProductAdditionalInformation objects filtered by the object_id column
 *
 */
abstract class ProductAdditionalInformationQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \AdditionalField\Model\Base\ProductAdditionalInformationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\AdditionalField\\Model\\ProductAdditionalInformation', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProductAdditionalInformationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProductAdditionalInformationQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \AdditionalField\Model\ProductAdditionalInformationQuery) {
            return $criteria;
        }
        $query = new \AdditionalField\Model\ProductAdditionalInformationQuery();
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
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildProductAdditionalInformation|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProductAdditionalInformationTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProductAdditionalInformationTableMap::DATABASE_NAME);
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
     * @return   ChildProductAdditionalInformation A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, OBJECT_ID FROM product_additional_information WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildProductAdditionalInformation();
            $obj->hydrate($row);
            ProductAdditionalInformationTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildProductAdditionalInformation|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return ChildProductAdditionalInformationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProductAdditionalInformationTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildProductAdditionalInformationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProductAdditionalInformationTableMap::ID, $keys, Criteria::IN);
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
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductAdditionalInformationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProductAdditionalInformationTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProductAdditionalInformationTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductAdditionalInformationTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the object_id column
     *
     * Example usage:
     * <code>
     * $query->filterByObjectId(1234); // WHERE object_id = 1234
     * $query->filterByObjectId(array(12, 34)); // WHERE object_id IN (12, 34)
     * $query->filterByObjectId(array('min' => 12)); // WHERE object_id > 12
     * </code>
     *
     * @see       filterByProduct()
     *
     * @param     mixed $objectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductAdditionalInformationQuery The current query, for fluid interface
     */
    public function filterByObjectId($objectId = null, $comparison = null)
    {
        if (is_array($objectId)) {
            $useMinMax = false;
            if (isset($objectId['min'])) {
                $this->addUsingAlias(ProductAdditionalInformationTableMap::OBJECT_ID, $objectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($objectId['max'])) {
                $this->addUsingAlias(ProductAdditionalInformationTableMap::OBJECT_ID, $objectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductAdditionalInformationTableMap::OBJECT_ID, $objectId, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Product object
     *
     * @param \Thelia\Model\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductAdditionalInformationQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \Thelia\Model\Product) {
            return $this
                ->addUsingAlias(ProductAdditionalInformationTableMap::OBJECT_ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProductAdditionalInformationTableMap::OBJECT_ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProduct() only accepts arguments of type \Thelia\Model\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Product relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildProductAdditionalInformationQuery The current query, for fluid interface
     */
    public function joinProduct($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Product');

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
            $this->addJoinObject($join, 'Product');
        }

        return $this;
    }

    /**
     * Use the Product relation Product object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\Thelia\Model\ProductQuery');
    }

    /**
     * Filter the query by a related \AdditionalField\Model\ProductAdditionalInformationI18n object
     *
     * @param \AdditionalField\Model\ProductAdditionalInformationI18n|ObjectCollection $productAdditionalInformationI18n  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductAdditionalInformationQuery The current query, for fluid interface
     */
    public function filterByProductAdditionalInformationI18n($productAdditionalInformationI18n, $comparison = null)
    {
        if ($productAdditionalInformationI18n instanceof \AdditionalField\Model\ProductAdditionalInformationI18n) {
            return $this
                ->addUsingAlias(ProductAdditionalInformationTableMap::ID, $productAdditionalInformationI18n->getId(), $comparison);
        } elseif ($productAdditionalInformationI18n instanceof ObjectCollection) {
            return $this
                ->useProductAdditionalInformationI18nQuery()
                ->filterByPrimaryKeys($productAdditionalInformationI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProductAdditionalInformationI18n() only accepts arguments of type \AdditionalField\Model\ProductAdditionalInformationI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductAdditionalInformationI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildProductAdditionalInformationQuery The current query, for fluid interface
     */
    public function joinProductAdditionalInformationI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductAdditionalInformationI18n');

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
            $this->addJoinObject($join, 'ProductAdditionalInformationI18n');
        }

        return $this;
    }

    /**
     * Use the ProductAdditionalInformationI18n relation ProductAdditionalInformationI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \AdditionalField\Model\ProductAdditionalInformationI18nQuery A secondary query class using the current class as primary query
     */
    public function useProductAdditionalInformationI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinProductAdditionalInformationI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductAdditionalInformationI18n', '\AdditionalField\Model\ProductAdditionalInformationI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildProductAdditionalInformation $productAdditionalInformation Object to remove from the list of results
     *
     * @return ChildProductAdditionalInformationQuery The current query, for fluid interface
     */
    public function prune($productAdditionalInformation = null)
    {
        if ($productAdditionalInformation) {
            $this->addUsingAlias(ProductAdditionalInformationTableMap::ID, $productAdditionalInformation->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the product_additional_information table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductAdditionalInformationTableMap::DATABASE_NAME);
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
            ProductAdditionalInformationTableMap::clearInstancePool();
            ProductAdditionalInformationTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildProductAdditionalInformation or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildProductAdditionalInformation object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductAdditionalInformationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProductAdditionalInformationTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        ProductAdditionalInformationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ProductAdditionalInformationTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    // i18n behavior

    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildProductAdditionalInformationQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'ProductAdditionalInformationI18n';

        return $this
            ->joinProductAdditionalInformationI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildProductAdditionalInformationQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'en_US', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('ProductAdditionalInformationI18n');
        $this->with['ProductAdditionalInformationI18n']->setIsWithOneToMany(false);

        return $this;
    }

    /**
     * Use the I18n relation query object
     *
     * @see       useQuery()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildProductAdditionalInformationI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductAdditionalInformationI18n', '\AdditionalField\Model\ProductAdditionalInformationI18nQuery');
    }

} // ProductAdditionalInformationQuery
