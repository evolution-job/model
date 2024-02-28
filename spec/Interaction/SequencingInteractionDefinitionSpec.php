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
use Xabbuh\XApi\Model\Interaction\SequencingInteractionDefinition;

class SequencingInteractionDefinitionSpec extends InteractionDefinitionSpec
{
    public function it_returns_a_new_instance_with_choices(): void
    {
        $choices = [new InteractionComponent('test')];
        $interaction = $this->withChoices($choices);

        $this->getChoices()->shouldBeNull();

        $interaction->shouldNotBe($this);
        $interaction->shouldBeAnInstanceOf(SequencingInteractionDefinition::class);
        $interaction->getChoices()->shouldReturn($choices);
    }

    public function it_is_not_equal_if_only_other_interaction_has_choices(): void
    {
        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withChoices([new InteractionComponent('test')]);

        $this->equals($interaction)->shouldReturn(false);
    }

    public function it_is_not_equal_if_only_this_interaction_has_choices(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, [new InteractionComponent('test')]);

        $this->equals($this->createEmptyDefinition())->shouldReturn(false);
    }

    public function it_is_not_equal_if_number_of_choices_differs(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, [new InteractionComponent('test')]);

        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withChoices([new InteractionComponent('test'), new InteractionComponent('foo')]);

        $this->equals($interaction)->shouldReturn(false);
    }

    public function it_is_not_equal_if_choices_differ(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, [new InteractionComponent('foo')]);

        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withChoices([new InteractionComponent('bar')]);

        $this->equals($interaction)->shouldReturn(false);
    }

    public function it_is_equal_if_choices_are_equal(): void
    {
        $this->beConstructedWith(null, null, null, null, null, null, [new InteractionComponent('test')]);

        $interaction = $this->createEmptyDefinition();
        $interaction = $interaction->withChoices([new InteractionComponent('test')]);

        $this->equals($interaction)->shouldReturn(true);
    }

    protected function createEmptyDefinition(): InteractionDefinition
    {
        return new SequencingInteractionDefinition();
    }
}
