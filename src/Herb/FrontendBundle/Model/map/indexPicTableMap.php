<?php

namespace Herb\FrontendBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'edf_indexpic' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Herb.FrontendBundle.Model.map
 */
class indexPicTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Herb.FrontendBundle.Model.map.indexPicTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('edf_indexpic');
        $this->setPhpName('indexPic');
        $this->setClassname('Herb\\FrontendBundle\\Model\\indexPic');
        $this->setPackage('src.Herb.FrontendBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('IP_ID', 'ipId', 'INTEGER', true, 5, null);
        $this->addColumn('IP_FILENAME', 'ipFilename', 'VARCHAR', true, 100, null);
        $this->addColumn('IP_DESCRIPTION', 'ipDescription', 'LONGVARCHAR', false, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()

} // indexPicTableMap
