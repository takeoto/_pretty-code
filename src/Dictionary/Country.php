<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\Dictionary;

enum Country: string
{
    case AUSTRIA = 'AT';
    case BELGIUM = 'BE';
    case ESTONIA = 'EE';
    case BULGARIA = 'BG';
    case CROATIA = 'HR';
    case CYPRUS = 'CY';
    case CZECHIA = 'CZ';
    case DENMARK = 'DK';
    case FINLAND = 'FI';
    case FRANCE = 'FR';
    case GERMANY = 'DE';
    case GREECE = 'GR';
    case HUNGARY = 'HU';
    case IRELAND = 'IE';
    case ITALY = 'IT';
    case LATVIA = 'LV';
    case LITHUANIA = 'LT';
    case LUXEMBOURG = 'LU';
    case MALTA = 'MT';
    case NETHERLANDS = 'NL';
    case PORTUGAL = 'PT';
    case ROMANIA = 'RO';
    case SLOVAKIA = 'SK';
    case SLOVENIA = 'SI';
    case SPAIN = 'ES';
    case SWEDEN = 'SE';
    case AFGHANISTAN = 'AF';
    # Other countries

    public function getContinent(): ?Continent
    {
        return match ($this) {
            self::AUSTRIA,
            self::BELGIUM,
            self::BULGARIA,
            self::CYPRUS,
            self::CZECHIA,
            self::GERMANY,
            self::DENMARK,
            self::ESTONIA,
            self::SPAIN,
            self::FINLAND,
            self::FRANCE,
            self::GREECE,
            self::CROATIA,
            self::HUNGARY,
            self::IRELAND,
            self::ITALY,
            self::LITHUANIA,
            self::LUXEMBOURG,
            self::LATVIA,
            self::MALTA,
            self::NETHERLANDS,
            # ? 'PO',
            self::PORTUGAL,
            self::ROMANIA,
            self::SWEDEN,
            self::SLOVENIA,
            self::SLOVAKIA => Continent::EUROPE,
            # Other maps
            default => null,
        };
    }
}
