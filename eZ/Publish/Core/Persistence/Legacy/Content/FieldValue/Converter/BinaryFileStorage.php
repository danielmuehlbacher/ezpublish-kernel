<?php
/**
 * File containing the BinaryFileStorage class
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter;
use eZ\Publish\SPI\FieldType\FieldStorage,
    eZ\Publish\SPI\Persistence\Content\Field;

/**
 * Description of BinaryFileStorage
 */
class BinaryFileStorage implements FieldStorage
{
    /**
     * Allows custom field types to store data in an external source (e.g. another DB table).
     *
     * Stores value for $field in an external data source.
     * The whole {@link eZ\Publish\SPI\Persistence\Content\Field} ValueObject is passed and its value
     * is accessible through the {@link eZ\Publish\SPI\Persistence\Content\FieldValue} 'value' property.
     * This value holds the data filled by the user as a {@link eZ\Publish\Core\Repository\FieldType\Value} based object,
     * according to the field type (e.g. for TextLine, it will be a {@link eZ\Publish\Core\Repository\FieldType\TextLine\Value} object).
     *
     * $field->id = unique ID from the attribute tables (needs to be generated by
     * database back end on create, before the external data source may be
     * called from storing).
     *
     * The context array provides some context for the field handler about the
     * currently used storage engine.
     * The array should at least define 2 keys :
     *   - identifier (connection identifier)
     *   - connection (the connection handler)
     * For example, using Legacy storage engine, $context will be:
     *   - identifier = 'LegacyStorage'
     *   - connection = {@link \eZ\Publish\Core\Persistence\Legacy\EzcDbHandler} object handler (for DB connection),
     *                  to be used accordingly to
     * The context array provides some context for the field handler about the
     * currently used storage engine.
     * The array should at least define 2 keys :
     *   - identifier (connection identifier)
     *   - connection (the connection handler)
     * For example, using Legacy storage engine, $context will be:
     *   - identifier = 'LegacyStorage'
     *   - connection = {@link \eZ\Publish\Core\Persistence\Legacy\EzcDbHandler} object handler (for DB connection),
     *                  to be used accordingly to
     *                  {@link http://incubator.apache.org/zetacomponents/documentation/trunk/Database/tutorial.html ezcDatabase} usage
     *
     * @param \eZ\Publish\SPI\Persistence\Content\Field $field
     * @param array $context
     * @return void
     * @todo Check if it's insert or update query
     */
    public function storeFieldData( Field $field, array $context )
    {
        $dbHandler = $context['connection'];
        $file = $field->value->data->file;

        $q = $dbHandler->createInsertQuery();
        $q->insertInto(
            $dbHandler->quoteTable( 'ezbinaryfile' )
        )->set(
            $dbHandler->quoteColumn( 'contentobject_attribute_id' ),
            $q->bindValue( $field->id, null, \PDO::PARAM_INT )
        )->set(
            // @todo: How to handle download_count ?
            $dbHandler->quoteColumn( 'download_count' ),
            $q->bindValue( 0, null, \PDO::PARAM_INT )
        )->set(
            $dbHandler->quoteColumn( 'filename' ),
            $q->bindValue( basename( $file->path ) )
        )->set(
            $dbHandler->quoteColumn( 'mime_type' ),
            $q->bindValue( $file->mimeType )
        )->set(
            $dbHandler->quoteColumn( 'original_filename' ),
            $q->bindValue( $field->value->data->originalFilename )
        )->set(
            $dbHandler->quoteColumn( 'version' ),
            $q->bindValue( $field->versionNo, null, \PDO::PARAM_INT )
        );

        $q->prepare()->execute();

        return false;
    }

    /**
     * Populates $field value property based on the external data.
     * $field->value is a {@link eZ\Publish\SPI\Persistence\Content\FieldValue} object.
     * This value holds the data as a {@link eZ\Publish\Core\Repository\FieldType\Value} based object,
     * according to the field type (e.g. for TextLine, it will be a {@link eZ\Publish\Core\Repository\FieldType\TextLine\Value} object).
     *
     * @param \eZ\Publish\SPI\Persistence\Content\Field $field
     * @param array $context
     * @return void
     */
    public function getFieldData( Field $field, array $context )
    {

    }

    /**
     * @param array $fieldId
     * @param array $context
     * @return bool
     */
    public function deleteFieldData( array $fieldId, array $context )
    {

    }

    /**
     * Checks if field type has external data to deal with
     *
     * @return bool
     */
    public function hasFieldData()
    {
        return true;
    }

    /**
     * @param \eZ\Publish\SPI\Persistence\Content\Field $field
     * @param array $context
     */
    public function copyFieldData( Field $field, array $context )
    {

    }

    /**
     * @param \eZ\Publish\SPI\Persistence\Content\Field $field
     * @param array $context
     */
    public function getIndexData( Field $field, array $context )
    {

    }
}
