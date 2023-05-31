<?php

declare(strict_types=1);

namespace Takeoto\PrettyCode\Dictionary;

final class Country
{
    public const AUSTRIA = 'AT';
    public const BELGIUM = 'BE';
    public const ESTONIA = 'EE';
    public const BULGARIA = 'BG';
    public const CROATIA = 'HR';
    public const CYPRUS = 'CY';
    public const CZECHIA = 'CZ';
    public const DENMARK = 'DK';
    public const FINLAND = 'FI';
    public const FRANCE = 'FR';
    public const GERMANY = 'DE';
    public const GREECE = 'GR';
    public const HUNGARY = 'HU';
    public const IRELAND = 'IE';
    public const ITALY = 'IT';
    public const LATVIA = 'LV';
    public const LITHUANIA = 'LT';
    public const LUXEMBOURG = 'LU';
    public const MALTA = 'MT';
    public const NETHERLANDS = 'NL';
    public const PORTUGAL = 'PT';
    public const ROMANIA = 'RO';
    public const SLOVAKIA = 'SK';
    public const SLOVENIA = 'SI';
    public const SPAIN = 'ES';
    public const SWEDEN = 'SE';
    public const AFGHANISTAN = 'AF';
    # Other countries

    public static function getContinent(string $country): ?string
    {
        return match ($country) {
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
