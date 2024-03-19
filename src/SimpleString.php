<?php

namespace StrannyiTip\Helper\Type;

use Closure;
use StdClass;
use StrannyiTip\Helper\Type\Exception\BadJSONException;
use Stringable;

/**
 * Simple plain string.
 */
class SimpleString implements Stringable
{

    /**
     * The source emptiness sign.
     */
    private const EMPTINESS_SIGN = '';

    /**
     * Source.
     *
     * @var string
     */
    private string $source;

    /**
     * SimpleString type.
     *
     * @param Stringable|string $string Initialize
     */
    public function __construct(Stringable|string $string = '')
    {
        $this->source = $string;
    }

    /**
     * Cut.
     *
     * @param int $start Start cut position
     * @param int $length Cut length
     *
     * @return SimpleString
     */
    public function cut(int $start, int $length): SimpleString
    {
        $this->source = \mb_substr($this->source, $start, $length);

        return $this;
    }

    /**
     * Clone to new instance.
     *
     * @return SimpleString
     */
    public function clone(): SimpleString
    {
        return new SimpleString($this->source);
    }

    /**
     * Replace symbols.
     *
     * @param Stringable|string $search Search symbols
     * @param Stringable|string $replace Replacement
     *
     * @return SimpleString
     */
    public function replace(Stringable|string $search, Stringable|string $replace): SimpleString
    {
        $this->source = \str_replace($search, $replace, $this->source);

        return $this;
    }

    /**
     * Replace symbols use regex pattern.
     *
     * @param Stringable|string $pattern Regex pattern
     * @param Closure $callback Callback-replacer (e.g. function(string $match_part){...})
     *
     * @return SimpleString
     */
    public function replace_regex(Stringable|string $pattern, Closure $callback): SimpleString
    {
        $this->source = \preg_replace_callback($pattern, $callback, $this->source);

        return $this;
    }

    /**
     * Check if start with symbols.
     *
     * @param Stringable|string $search Search symbols
     *
     * @return bool
     */
    public function is_start_with(Stringable|string $search): bool
    {
        return \str_starts_with($this->source, $search);
    }

    /**
     * Check if end with symbols.
     *
     * @param Stringable|string $search Search symbols
     *
     * @return bool
     */
    public function is_ends_with(Stringable|string $search): bool
    {
        return \str_ends_with($this->source, $search);
    }

    /**
     * Check if contains symbols.
     *
     * @param Stringable|string $search Search symbols
     *
     * @return bool
     */
    public function contains(Stringable|string $search): bool
    {
        return \str_contains($this->source, $search);
    }

    /**
     * Check if is equal to search string.
     *
     * @param Stringable|string $search Search string
     *
     * @return bool
     */
    public function is_equal(Stringable|string $search):bool
    {
        return $this->source == $search;
    }

    /**
     * Check if match regex pattern.
     *
     * @param Stringable|string $pattern Search regex pattern
     *
     * @return bool
     */
    public function is_match_regex(Stringable|string $pattern): bool
    {
        return (bool)\preg_match($pattern, $this->source);
    }

    /**
     * Check if is empty.
     *
     * @return bool
     */
    public function is_empty(): bool
    {
        return $this->source == self::EMPTINESS_SIGN;
    }

    /**
     * Append to end.
     *
     * @param Stringable|string $string Some symbols
     *
     * @return SimpleString
     */
    public function append(Stringable|string $string): SimpleString
    {
        $this->source .= $string;

        return $this;
    }

    /**
     * Prepend.
     *
     * @param Stringable|string $string Some symbols
     *
     * @return SimpleString
     */
    public function prepend(Stringable|string $string): SimpleString
    {
        $this->source = $string . $this->source;

        return $this;
    }

    /**
     * Convert to array.
     *
     * @return array
     */
    public function to_array(): array
    {
        return \str_split($this->source);
    }

    /**
     * Check is numeric.
     *
     * @return bool
     */
    public function is_numeric(): bool
    {
        return \is_numeric($this->source);
    }

    /**
     * Length.
     *
     * @return int
     */
    public function length(): int
    {
        return \strlen($this->source);
    }

    /**
     * Split use delimiter.
     *
     * @param Stringable|string $delimiter Delimiter
     *
     * @return array
     */
    public function split(Stringable|string $delimiter = ' '): array
    {
        return \explode($delimiter, $this->source);
    }

    /**
     * Invert to associative array.
     *
     * @throws BadJSONException If json_decode throw exception e.g. damaged data
     *
     * @return array
     */
    public function toJSONArray(): array
    {
        try {
            return \json_decode($this->source, true);
        } catch (\RuntimeException $e) {
            throw new BadJSONException($e);
        }
    }

    /**
     * Invert to StdClass object.
     *
     * @throws BadJSONException If json_decode throw exception e.g. damaged data
     *
     * @return StdClass
     */
    public function toJSONObject(): StdClass
    {
        try {
            return \json_decode($this->source, false);
        } catch (\RuntimeException $e) {
            throw new BadJSONException($e);
        }
    }

    /**
     * Get source.
     *
     * @return string
     */
    public function get_source(): string
    {
        return $this->source;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->source;
    }
}
