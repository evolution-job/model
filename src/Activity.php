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
 * An Activity in a {@link Statement}.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class Activity extends StatementObject
{
    private $id;
    private $definition;

    public function __construct(IRI $id, Definition $definition = null)
    {
        $this->id = $id;
        $this->definition = $definition;
    }

    /**
     * Returns the Activity's unique identifier.
     */
    public function getId(): IRI
    {
        return $this->id;
    }

    /**
     * Returns the Activity's {@link Definition}.
     */
    public function getDefinition(): ?Definition
    {
        return $this->definition;
    }

    /**
     * {@inheritdoc}
     */
    public function equals(StatementObject $statementObject): bool
    {
        if (!$statementObject instanceof self) {
            return false;
        }

        if (!$this->id->equals($statementObject->id)) {
            return false;
        }

        if (null === $this->definition && null !== $statementObject->definition) {
            return false;
        }

        if (null !== $this->definition && null === $statementObject->definition) {
            return false;
        }

        if (null !== $this->definition && !$this->definition->equals($statementObject->definition)) {
            return false;
        }

        return true;
    }
}
