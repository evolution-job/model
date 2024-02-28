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
use Xabbuh\XApi\Model\Interaction\PerformanceInteractionDefinition;

class PerformanceInteractionDefinitionSpec extends InteractionDefinitionSpec
{
    public function it_returns_a_new_instance_with_steps(): void
    {
        $steps = [new InteractionComponent('test')];
        $interaction = $this->withSteps($steps);

        $this->getSteps()->shouldBeNull();

        $interaction->shouldNotBe($this);
        $interaction->shouldBeAnInstanceOf(PerformanceInteractionDefinition::class);
        $interaction->getSteps()->shouldReturn($steps);
    }

    public function it_is_not_equal_if_only_other_interaction_has_steps(): void
    {
        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withSteps([new InteractionComponent('test')]);

        $this->equals($interaction)->shouldReturn(false);
    }

    public function it_is_not_equal_if_only_this_interaction_has_steps(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, [new InteractionComponent('test')]);

        $this->equals($this->createEmptyDefinition())->shouldReturn(false);
    }

    public function it_is_not_equal_if_number_of_steps_differs(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, [new InteractionComponent('test')]);

        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withSteps([new InteractionComponent('test'), new InteractionComponent('foo')]);

        $this->equals($interaction)->shouldReturn(false);
    }

    public function it_is_not_equal_if_steps_differ(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, [new InteractionComponent('foo')]);

        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withSteps([new InteractionComponent('bar')]);

        $this->equals($interaction)->shouldReturn(false);
    }

    public function it_is_equal_if_steps_are_equal(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, [new InteractionComponent('test')]);

        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withSteps([new InteractionComponent('test')]);

        $this->equals($interaction)->shouldReturn(true);
    }

    protected function createEmptyDefinition(): InteractionDefinition
    {
        return new PerformanceInteractionDefinition();
    }
}
