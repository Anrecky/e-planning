<?php

namespace App\Enums;

enum Month: int
{
    case Januari = 1;
    case Februari = 2;
    case Maret = 3;
    case April = 4;
    case Mei = 5;
    case Juni = 6;
    case Juli = 7;
    case Agustus = 8;
    case September = 9;
    case Oktober = 10;
    case November = 11;
    case Desember = 12;

    /**
     * Get the abbreviation of the month.
     *
     * @return string
     */
    public function abbreviation(): string
    {
        return match ($this) {
            self::Januari => 'Jan',
            self::Februari => 'Feb',
            self::Maret => 'Mar',
            self::April => 'Apr',
            self::Mei => 'Mei',
            self::Juni => 'Jun',
            self::Juli => 'Jul',
            self::Agustus => 'Agu',
            self::September => 'Sep',
            self::Oktober => 'Okt',
            self::November => 'Nov',
            self::Desember => 'Des',
        };
    }

    /**
     * Get the full name of the month.
     *
     * @return string
     */
    public function getName(): string
    {
        return match ($this) {
            self::Januari => 'Januari',
            self::Februari => 'Februari',
            self::Maret => 'Maret',
            self::April => 'April',
            self::Mei => 'Mei',
            self::Juni => 'Juni',
            self::Juli => 'Juli',
            self::Agustus => 'Agustus',
            self::September => 'September',
            self::Oktober => 'Oktober',
            self::November => 'November',
            self::Desember => 'Desember',
        };
    }

    /**
     * Get all months with their respective names.
     *
     * @return array
     */
    public static function getAllMonths(): array
    {
        return array_map(fn ($month) => $month->getName(), self::cases());
    }

    /**
     * Parse a month from a string name.
     *
     * @param string $monthName
     * @return self|null
     */
    public static function parseFromString(string $monthName): ?self
    {
        foreach (self::cases() as $month) {
            if (strtolower($month->getName()) === strtolower($monthName)) {
                return $month;
            }
        }
        return null;
    }

    /**
     * Get the number of days in the month.
     *
     * @return int
     */
    public function getNumberOfDays(): int
    {
        return match ($this) {
            self::Februari => 28, // Note: Does not account for leap years
            self::April, self::Juni, self::September, self::November => 30,
            default => 31,
        };
    }

    /**
     * Get the next month.
     *
     * @return self
     */
    public function getNextMonth(): self
    {
        return self::fromValue(($this->value % 12) + 1);
    }

    /**
     * Get the previous month.
     *
     * @return self
     */
    public function getPreviousMonth(): self
    {
        return self::fromValue(($this->value + 10) % 12 + 1);
    }
}
