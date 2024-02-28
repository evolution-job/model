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

use DateTime;
use InvalidArgumentException;

/**
 * A {@link Statement} included as part of a parent Statement.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class SubStatement extends StatementObject
{
    private $verb;
    private $actor;
    private $object;
    private $result;
    private $created;
    private $context;
    private $attachments;

    /**
     * @param Attachment[]|null $attachments
     */
    public function __construct(Actor $actor, Verb $verb, StatementObject $statementObject, Result $result = null, Context $context = null, DateTime $created = null, array $attachments = null)
    {
        if ($statementObject instanceof SubStatement) {
            throw new InvalidArgumentException('Nesting sub statements is forbidden by the xAPI spec.');
        }

        $this->actor = $actor;
        $this->verb = $verb;
        $this->object = $statementObject;
        $this->result = $result;
        $this->created = $created;
        $this->context = $context;
        $this->attachments = null !== $attachments ? array_values($attachments) : null;
    }

    public function withActor(Actor $actor): self
    {
        $subStatement = clone $this;
        $subStatement->actor = $actor;

        return $subStatement;
    }

    public function withVerb(Verb $verb): self
    {
        $subStatement = clone $this;
        $subStatement->verb = $verb;

        return $subStatement;
    }

    public function withObject(StatementObject $statementObject): self
    {
        $subStatement = clone $this;
        $subStatement->object = $statementObject;

        return $subStatement;
    }

    public function withResult(Result $result): self
    {
        $subStatement = clone $this;
        $subStatement->result = $result;

        return $subStatement;
    }

    public function withCreated(DateTime $created = null): self
    {
        $statement = clone $this;
        $statement->created = $created;

        return $statement;
    }

    public function withContext(Context $context): self
    {
        $subStatement = clone $this;
        $subStatement->context = $context;

        return $subStatement;
    }

    /**
     * @param Attachment[]|null $attachments
     */
    public function withAttachments(array $attachments = null): self
    {
        $statement = clone $this;
        $statement->attachments = null !== $attachments ? array_values($attachments) : null;

        return $statement;
    }

    /**
     * Returns the Statement's {@link Verb}.
     */
    public function getVerb(): Verb
    {
        return $this->verb;
    }

    /**
     * Returns the Statement's {@link Actor}.
     */
    public function getActor(): Actor
    {
        return $this->actor;
    }

    /**
     * Returns the Statement's {@link StatementObject}.
     */
    public function getObject(): StatementObject
    {
        return $this->object;
    }

    /**
     * Returns the {@link Activity} {@link Result}.
     */
    public function getResult(): ?Result
    {
        return $this->result;
    }

    /**
     * Returns the timestamp of when the events described in this statement
     * occurred.
     */
    public function getCreated(): ?DateTime
    {
        return $this->created;
    }

    /**
     * Returns the {@link Statement} {@link Context}.
     */
    public function getContext(): ?Context
    {
        return $this->context;
    }

    /**
     * @return Attachment[]|null
     */
    public function getAttachments(): ?array
    {
        return $this->attachments;
    }

    /**
     * Tests whether or not this Statement is a void Statement (i.e. it voids
     * another Statement).
     */
    public function isVoidStatement(): bool
    {
        return $this->verb->isVoidVerb();
    }

    /**
     * {@inheritdoc}
     */
    public function equals(StatementObject $statementObject): bool
    {
        if (!$statementObject instanceof SubStatement) {
            return false;
        }

        if (!$this->actor->equals($statementObject->actor)) {
            return false;
        }

        if (!$this->verb->equals($statementObject->verb)) {
            return false;
        }

        if (!$this->object->equals($statementObject->object)) {
            return false;
        }

        if (null === $this->result && null !== $statementObject->result) {
            return false;
        }

        if (null !== $this->result && null === $statementObject->result) {
            return false;
        }

        if (null !== $this->result && !$this->result->equals($statementObject->result)) {
            return false;
        }

        if ($this->created != $statementObject->created) {
            return false;
        }

        if (null !== $this->context xor null !== $statementObject->context) {
            return false;
        }

        if (null !== $this->context && null !== $statementObject->context && !$this->context->equals($statementObject->context)) {
            return false;
        }

        if (null !== $this->attachments xor null !== $statementObject->attachments) {
            return false;
        }

        if (null !== $this->attachments && null !== $statementObject->attachments) {
            if (count($this->attachments) !== count($statementObject->attachments)) {
                return false;
            }

            foreach ($this->attachments as $key => $attachment) {
                if (!$attachment->equals($statementObject->attachments[$key])) {
                    return false;
                }
            }
        }

        return true;
    }
}
