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

use PhpSpec\ObjectBehavior;
use Xabbuh\XApi\Model\Interaction\InteractionComponent;
use Xabbuh\XApi\Model\LanguageMap;

class InteractionComponentSpec extends ObjectBehavior
{
    public function its_properties_can_be_read(): void
    {
        $languageMap = LanguageMap::create(['en-US' => 'test']);
        $this->beConstructedWith('test', $languageMap);

        $this->getId()->shouldReturn('test');
        $this->getDescription()->shouldReturn($languageMap);
    }

    public function it_is_not_equal_with_other_interaction_component_if_ids_differ(): void
    {
        $languageMap = LanguageMap::create(['en-US' => 'test']);
        $this->beConstructedWith('test', $languageMap);

        $interactionComponent = new InteractionComponent('Test', $languageMap);

        $this->equals($interactionComponent)->shouldReturn(false);
    }

    public function it_is_not_equal_with_other_interaction_component_if_descriptions_differ(): void
    {
        $this->beConstructedWith('test', LanguageMap::create(['en-US' => 'test']));

        $interactionComponent = new InteractionComponent('test', LanguageMap::create(['en-GB' => 'test']));

        $this->equals($interactionComponent)->shouldReturn(false);
    }

    public function it_is_not_equal_with_other_interaction_component_if_other_interaction_component_does_not_have_a_description(): void
    {
        $this->beConstructedWith('test', LanguageMap::create(['en-US' => 'test']));

        $interactionComponent = new InteractionComponent('test');

        $this->equals($interactionComponent)->shouldReturn(false);
    }

    public function it_is_not_equal_with_other_interaction_component_if_only_the_other_interaction_component_does_have_a_description(): void
    {
        $this->beConstructedWith('test');

        $interactionComponent = new InteractionComponent('test', LanguageMap::create(['en-US' => 'test']));

        $this->equals($interactionComponent)->shouldReturn(false);
    }

    public function it_is_equal_with_other_interaction_component_if_ids_and_descriptions_are_equal(): void
    {
        $this->beConstructedWith('test', LanguageMap::create(['en-US' => 'test']));

        $interactionComponent = new InteractionComponent('test', LanguageMap::create(['en-US' => 'test']));

        $this->equals($interactionComponent)->shouldReturn(true);
    }

    public function it_is_equal_with_other_interaction_component_if_ids_are_equal_and_descriptions_are_not_present(): void
    {
        $this->beConstructedWith('test');

        $this->equals(new InteractionComponent('test'))->shouldReturn(true);
    }
}
