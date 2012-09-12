<?php
/**
 * File containing a test class
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\Core\REST\Server\Tests\Output\ValueObjectVisitor;
use eZ\Publish\Core\REST\Common\Tests\Output\ValueObjectVisitorBaseTest;

use eZ\Publish\Core\REST\Server\Output\ValueObjectVisitor;
use eZ\Publish\Core\REST\Server\Values\RelationList;
use eZ\Publish\Core\Repository\Values\Content;
use eZ\Publish\Core\REST\Common;

class RelationListTest extends ValueObjectVisitorBaseTest
{
    /**
     * Test the RelationList visitor
     *
     * @return string
     */
    public function testVisit()
    {
        $visitor   = $this->getRelationListVisitor();
        $generator = $this->getGenerator();

        $generator->startDocument( null );

        $sectionList = new RelationList( 23, array() );

        $visitor->visit(
            $this->getVisitorMock(),
            $generator,
            $sectionList
        );

        $result = $generator->endDocument( null );

        $this->assertNotNull( $result );

        return $result;
    }

    /**
     * Test if result contains Relations element
     *
     * @param string $result
     * @depends testVisit
     */
    public function testResultContainsRelationsElement( $result )
    {
        $this->assertTag(
            array(
                'tag'      => 'Relations',
            ),
            $result,
            'Invalid <Relations> element.',
            false
        );
    }

    /**
     * Test if result contains Relations element attributes
     *
     * @param string $result
     * @depends testVisit
     */
    public function testResultContainsRelationsAttributes( $result )
    {
        $this->assertTag(
            array(
                'tag'      => 'Relations',
                'attributes' => array(
                    'media-type' => 'application/vnd.ez.api.RelationList+xml',
                    'href'       => '/content/objects/23/relations',
                )
            ),
            $result,
            'Invalid <Relations> attributes.',
            false
        );
    }

    /**
     * Test if RelationList visitor visits the children
     */
    public function testRelationListVisitsChildren()
    {
        $visitor   = $this->getRelationListVisitor();
        $generator = $this->getGenerator();

        $generator->startDocument( null );

        $sectionList = new RelationList(
            23,
            array(
                new Content\Relation(),
                new Content\Relation(),
            )
        );

        $this->getVisitorMock()->expects( $this->exactly( 2 ) )
            ->method( 'visitValueObject' )
            ->with( $this->isInstanceOf( 'eZ\\Publish\\API\\Repository\\Values\\Content\\Relation' ) );

        $visitor->visit(
            $this->getVisitorMock(),
            $generator,
            $sectionList
        );
    }

    /**
     * Get the RelationList visitor
     *
     * @return \eZ\Publish\Core\REST\Server\Output\ValueObjectVisitor\RelationList
     */
    protected function getRelationListVisitor()
    {
        return new ValueObjectVisitor\RelationList(
            new Common\UrlHandler\eZPublish()
        );
    }
}
