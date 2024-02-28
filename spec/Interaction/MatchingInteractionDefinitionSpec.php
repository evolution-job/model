<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Xabbuh\XApi\Model\Interaction;

use Xabbuh\XApi\Model\Interaction\InteractionComponent;
use Xabbuh\XApi\Model\Interaction\InteractionDefinition;
use Xabbuh\XApi\Model\Interaction\MatchingInteractionDefinition;

class MatchingInteractionDefinitionSpec extends InteractionDefinitionSpec
{
    public function it_returns_a_new_instance_with_source(): void
    {
        $source = [new InteractionComponent('test')];
        $interaction = $this->withSource($source);

        $this->getSource()->shouldBeNull();

        $interaction->shouldNotBe($this);
        $interaction->shouldBeAnInstanceOf(MatchingInteractionDefinition::class);
        $interaction->getSource()->shouldReturn($source);
    }

    public function it_returns_a_new_instance_with_target(): void
    {
        $target = [new InteractionComponent('test')];
        $interaction = $this->withTarget($target);

        $this->getTarget()->shouldBeNull();

        $interaction->shouldNotBe($this);
        $interaction->shouldBeAnInstanceOf(MatchingInteractionDefinition::class);
        $interaction->getTarget()->shouldReturn($target);
    }

    public function it_is_not_equal_if_only_other_interaction_has_source(): void
    {
        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withSource([new InteractionComponent('test')]);

        $this->equals($interaction)->shouldReturn(false);
    }

    public function it_is_not_equal_if_only_this_interaction_has_source(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, [new InteractionComponent('test')]);

        $this->equals($this->createEmptyDefinition())->shouldReturn(false);
    }

    public function it_is_not_equal_if_number_of_source_differs(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, [new InteractionComponent('test')]);

        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withSource([new InteractionComponent('test'), new InteractionComponent('foo')]);

        $this->equals($interaction)->shouldReturn(false);
    }

    public function it_is_not_equal_if_source_differ(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, [new InteractionComponent('foo')]);

        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withSource([new InteractionComponent('bar')]);

        $this->equals($interaction)->shouldReturn(false);
    }

    public function it_is_equal_if_sources_are_equal(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, [new InteractionComponent('test')]);

        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withSource([new InteractionComponent('test')]);

        $this->equals($interaction)->shouldReturn(true);
    }

    public function it_is_not_equal_if_only_other_interaction_has_target(): void
    {
        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withTarget([new InteractionComponent('test')]);

        $this->equals($interaction)->shouldReturn(false);
    }

    public function it_is_not_equal_if_only_this_interaction_has_target(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, null, [new InteractionComponent('test')]);

        $this->equals($this->createEmptyDefinition())->shouldReturn(false);
    }

    public function it_is_not_equal_if_number_of_target_differs(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, null, [new InteractionComponent('test')]);

        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withTarget([new InteractionComponent('test'), new InteractionComponent('foo')]);

        $this->equals($interaction)->shouldReturn(false);
    }

    public function it_is_not_equal_if_target_differ(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, null, [new InteractionComponent('foo')]);

        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withTarget([new InteractionComponent('bar')]);

        $this->equals($interaction)->shouldReturn(false);
    }

    public function it_is_equal_if_targets_are_equal(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, null, [new InteractionComponent('test')]);

        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withTarget([new InteractionComponent('test')]);

        $this->equals($interaction)->shouldReturn(true);
    }

    protected function createEmptyDefinition(): InteractionDefinition
    {
        return new MatchingInteractionDefinition();
    }
}
