<?php
/**
 * File containing the ezp\content\Services\Section class.
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package ezp
 * @subpackage content
 */

namespace ezp\content\Services;

/**
 * Section service, used for section operations
 * @package ezp
 * @subpackage content
 */
use ezp\base\Interfaces\Service, ezp\base\Repository;
class Section implements Service
{
    /**
     * @var \ezp\base\Repository
     */
    protected $repository;

    /**
     * @var \ezp\persistence\Interfaces\RepositoryHandler
     */
    protected $handler;

    /**
     * Setups service with reference to repository object that created it & corresponding handler
     *
     * @param \ezp\base\Repository $repository
     * @param \ezp\persistence\Interfaces\RepositoryHandler $handler
     */
    public function __construct( Repository $repository, \ezp\persistence\Interfaces\RepositoryHandler $handler )
    {
        $this->repository = $repository;
        $this->handler = $handler;
    }

    /**
     * Creates the a new Section in the content repository
     * 
     * @param \ezp\content\Section $section
     * @return \ezp\content\Section The newly create section
     * @throws \ezp\content\ValidationException If a validation problem has been found for $section
     */
    public function create( \ezp\content\Section $section )
    {
    }

    /**
     * Updates $section in the content repository
     *
     * @param \ezp\content\Section $section
     * @return \ezp\content\Section
     * @throws \ezp\content\ValidationException If a validation problem has been found for $section
     */
    public function update( \ezp\content\Section $section )
    {
    }

    /**
     * Loads a Section from its id ($sectionId)
     * 
     * @param int $sectionId 
     * @return \ezp\content\Section
     * @throws \ezp\content\SectionNotFoundException if section could not be found
     */
    public function load( $sectionId )
    {
    }

    /**
     * Loads a Section from its identifier ($sectionIdentifier)
     * 
     * @param string $sectionIdentifier 
     * @return \ezp\content\Section
     * @throws \ezp\content\SectionNotFoundException if section could not be found
     */
    public function loadByIdentifier( $sectionIdentifier )
    {
    }

    /**
     * Counts the contents which $section is assigned to 
     * 
     * @param \ezp\content\Section $section
     * @return int
     */
    public function countAssignedContents( \ezp\content\Section $section )
    {
    }

    /**
     * Counts the contents which $section is assigned to
     *
     * @param \ezp\content\Section $section
     * @param \ezp\content\Content $content
     * @uses \ezp\base\StorageEngine\SectionHandler::assign()
     */
    public function assign( \ezp\content\Section $section, \ezp\content\Content $content )
    {
        if ( $section->id === $content->section->id )
            return;
        $this->handler->sectionHandler()->assign( $section->id, $content->id );
    }

    /**
     * Deletes $section from content repository 
     * 
     * @param \ezp\content\Section $section
     * @return void
     * @throws \ezp\content\ValidationException
     *         if section can not be deleted
     *         because it is still assigned to some contents.
     */
    public function delete( \ezp\content\Section $section )
    {
        if ( $this->countAssignedContents( $section ) > 0 )
        {
            throw new \ezp\content\ValidationException( 'This section is assigned to some contents' );
        }
        // do the removal
    }
}
?>
