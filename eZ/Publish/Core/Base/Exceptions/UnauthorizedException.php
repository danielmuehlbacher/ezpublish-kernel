<?php
/**
 * Contains UnauthorizedException Exception implementation
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\Core\Base\Exceptions;
use eZ\Publish\API\Repository\Exceptions\UnauthorizedException as APIUnauthorizedException,
    Exception;

/**
 * UnauthorizedException Exception implementation
 *
 * Use:
 *   throw new UnauthorizedException( 'content', 'read', 42 );
 */
class UnauthorizedException extends APIUnauthorizedException implements Httpable
{
    /**
     * Generates: User does not have access to '{$function}' '{$module}'[ with identifier '{$identifier}']
     *
     * Example: User does not have access to 'read' 'content' with identifier '42'
     *
     * @param string $module The module name should be in sync with the name of the domain object in question
     * @param string $function
     * @param string|null $identifier
     * @param \Exception|null $previous
     */
    public function __construct( $module, $function, $identifier = null, Exception $previous = null )
    {
        parent::__construct(
            "User does not have access to '{$function}' '{$module}'" .
            ( $identifier !== null ? " with identifier '{$identifier}'" : '' ),
            self::UNAUTHORIZED,
            $previous
        );
    }
}
