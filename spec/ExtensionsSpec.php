<?php

namespace spec\Xabbuh\XApi\Model;

use PhpSpec\ObjectBehavior;
use SplObjectStorage;
use Xabbuh\XApi\Common\Exception\UnsupportedOperationException;
use Xabbuh\XApi\Model\Extensions;
use Xabbuh\XApi\Model\IRI;
use Xabbuh\XApi\Model\IRL;

class ExtensionsSpec extends ObjectBehavior
{
    public function let(): void
    {
        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');
        $this->beConstructedWith($extensions);
    }

    public function its_extensions_can_be_read(): void
    {
        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/color'), ['model' => 'RGB', 'value' => '#FFFFFF']);
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/starting-position'), 1);
        $this->beConstructedWith($extensions);

        $this->shouldHaveKey(IRI::fromString('http://id.tincanapi.com/extension/topic'));
        $this->offsetGet(IRI::fromString('http://id.tincanapi.com/extension/topic'))->shouldReturn('Conformance Testing');

        $this->shouldHaveKey(IRI::fromString('http://id.tincanapi.com/extension/color'));
        $this->offsetGet(IRI::fromString('http://id.tincanapi.com/extension/color'))->shouldReturn(['model' => 'RGB', 'value' => '#FFFFFF']);

        $this->shouldHaveKey(IRI::fromString('http://id.tincanapi.com/extension/starting-position'));
        $this->offsetGet(IRI::fromString('http://id.tincanapi.com/extension/starting-position'))->shouldReturn(1);

        $returnedExtensions = $this->getExtensions();
        $returnedExtensions->shouldBeAnInstanceOf('\SplObjectStorage');
        $returnedExtensions->count()->shouldReturn(3);
    }

    public function it_throws_exception_when_keys_are_passed_that_are_not_iri_instances_during_instantiation(): void
    {
        $extensions = new SplObjectStorage();
        $extensions->attach(IRL::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');
        $this->beConstructedWith($extensions);
        $this->shouldThrow('\InvalidArgumentException')->duringInstantiation();
    }

    public function it_throws_exception_when_keys_are_passed_that_are_not_iri_instances(): void
    {
        $this->shouldThrow('\InvalidArgumentException')->during('offsetExists', ['http://id.tincanapi.com/extension/topic']);
        $this->shouldThrow('\InvalidArgumentException')->during('offsetGet', ['http://id.tincanapi.com/extension/topic']);
    }

    public function it_throws_exception_when_not_existing_extension_is_being_read(): void
    {
        $this->shouldThrow('\InvalidArgumentException')->duringOffsetGet(IRI::fromString('z'));
    }

    public function its_extensions_cannot_be_manipulated(): void
    {
        $this->shouldThrow(UnsupportedOperationException::class)->duringOffsetSet(IRI::fromString('z'), 'baz');
        $this->shouldThrow(UnsupportedOperationException::class)->duringOffsetUnset(IRI::fromString('x'));
    }

    public function its_not_equal_to_other_extensions_with_a_different_number_of_entries(): void
    {
        $this->equals(new Extensions())->shouldReturn(false);

        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/starting-position'), 1);
        $this->equals(new Extensions($extensions))->shouldReturn(false);
    }

    public function its_not_equal_to_other_extensions_if_extension_keys_differ(): void
    {
        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/subject'), 'Conformance Testing');

        $this->equals(new Extensions($extensions))->shouldReturn(false);
    }

    public function its_not_equal_to_other_extensions_if_extension_values_differ(): void
    {
        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Tests');

        $this->equals(new Extensions($extensions))->shouldReturn(false);
    }

    public function its_equal_to_other_extensions_even_if_extension_names_are_in_different_order(): void
    {
        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/color'), ['model' => 'RGB', 'value' => '#FFFFFF']);
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/starting-position'), 1);

        $this->beConstructedWith($extensions);

        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/starting-position'), 1);
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/color'), ['model' => 'RGB', 'value' => '#FFFFFF']);
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');

        $this->equals(new Extensions($extensions))->shouldReturn(true);
    }
}
