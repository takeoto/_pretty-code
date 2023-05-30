<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\Dictionary;

enum Continent: string
{
    case ASIA = 'AS';
    case AFRICA = 'AF';
    case EUROPE = 'EU';
    case NORTH_AMERICA = 'NA';
    case SOUTH_AMERICA = 'SA';
    case OCEANIA = 'OC';
    case AUSTRALIA = 'AN';
}