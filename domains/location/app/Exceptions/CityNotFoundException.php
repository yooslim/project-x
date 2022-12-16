<?php

namespace Domains\Location\Exceptions;

use App\Contracts\Exceptions\EntityNotFoundException;

/**
 * This exception is thrown in case of repository doesnt
 * find any results matching a city criterias.
 */
class CityNotFoundException extends EntityNotFoundException
{

}
