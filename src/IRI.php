<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xabbuh\XApi\Model;

/**
 * An internationalized resource identifier according to RFC 3987.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class IRI
{
    private $value;

    private function __construct()
    {
    }

    /**
     * @throws \InvalidArgumentException if the given value is no valid IRI
     */
    public static function fromString(string $value): self
    {
        if (false === filter_var($value, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('IRI "'.$value.'" is not valid.');
        }

        $iri = new self();
        $iri->value = $value;

        return $iri;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(IRI $iri): bool
    {
        return $this->value === $iri->value;
    }
}
