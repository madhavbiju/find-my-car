<?php

namespace App\Enums\Concerns;

trait HasLabel
{
    public function label(): string
    {
        return __('recommendations.options.'.$this->langGroup().'.'.$this->value);
    }

    /**
     * Returns value → label pairs, driven by enum cases.
     *
     * @return array<string, string>
     */
    public static function toOptions(): array
    {
        return array_combine(
            array_column(static::cases(), 'value'),
            array_map(fn (self $case): string => $case->label(), static::cases()),
        );
    }

    abstract private function langGroup(): string;
}
