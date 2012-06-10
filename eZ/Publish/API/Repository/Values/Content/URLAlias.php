<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\Content\URLAlias class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\API\Repository\Values\Content;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * This class represents a url alias in the repository
 *
 * @property-read string $id A unique identifier for the alias
 * @property-read int $type The type of the URL Alias i.e. one of URLAlias::LOCATION, URLAlias::RESOURCE, URLAlias::VIRTUAL
 * @property-read mixed $destination If type = URLAlias::LOCATION it is a Location otherwise a string (e.g. /content/search)
 * @property-read string $path the alias path
 * @property-read string[] languageCodes the languages for which this alias is valid
 * @property-read boolean $alwaysAvailable Fallback indicator for other languages
 * @property-read boolean $isHistory Indicates that this alias was autogenerated for an in the meanwhile archived version of the content
 * @property-read boolean $isCustom If false this alias was autogenerated otherwise manuel created
 * @property-read boolean $forward Indicates if the url should be redirected
 */

class URLAlias extends ValueObject
{
    const LOCATION = 0;
    const RESOURCE = 1;
    const VIRTUAL = 2;

    /**
     * A unique identifier for the alias
     * (in legacy implementation this would be <parentid>-<md5text>)
     *
     * @var string
     */
    protected $id;

    /**
     * The type of the URL Alias i.e. one of URLAlias::LOCATION, URLAlias::RESOURCE, URLAlias::VIRTUAL
     *
     * @var int
     */
    protected $type;

    /**
     * If type = URLAlias::LOCATION it is a Location
     * otherwise a string (e.g. /content/search)
     *
     * @var mixed
     */
    protected $destination;

    /**
     * the full path of the alias
     *
     * @var string
     */
    protected $path;

    /**
     * The languageCodes for which this path is valid
     *
     * @var string[]
     */
    protected $languageCodes;

    /**
     * Fallback indicator for other languages
     *
     * @var boolean
     */
    protected $alwaysAvailable;

    /**
     * Indicates that this alias was autogenerated for an in the meanwhile archived version of the content
     *
     * @var boolean
     */
    protected $isHistory;

    /**
     * If false this alias was autogenerated otherwise manually created
     *
     * @var boolean
     */
    protected $isCustom;

    /**
     * Indicates if the url should be redirected
     *
     * @var boolean
     */
    protected $forward;
}
