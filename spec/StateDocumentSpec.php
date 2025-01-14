<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Xabbuh\XApi\Model;

use PhpSpec\ObjectBehavior;
use Xabbuh\XApi\Common\Exception\UnsupportedOperationException;
use Xabbuh\XApi\Model\Activity;
use Xabbuh\XApi\Model\Agent;
use Xabbuh\XApi\Model\Document;
use Xabbuh\XApi\Model\DocumentData;
use Xabbuh\XApi\Model\InverseFunctionalIdentifier;
use Xabbuh\XApi\Model\IRI;
use Xabbuh\XApi\Model\State;

class StateDocumentSpec extends ObjectBehavior
{
    public function let(): void
    {
        $activity = new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid'));
        $agent = new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));
        $this->beConstructedWith(new State($activity, $agent, 'state-id'), new DocumentData(['x' => 'foo', 'y' => 'bar']));
    }

    public function it_is_a_document(): void
    {
        $this->shouldHaveType(Document::class);
    }

    public function its_data_can_be_read(): void
    {
        $this->shouldHaveKey('x');
        $this->offsetGet('x')->shouldReturn('foo');
        $this->shouldHaveKey('y');
        $this->offsetGet('y')->shouldReturn('bar');
        $this->shouldNotHaveKey('z');
    }

    public function it_throws_exception_when_not_existing_data_is_being_read(): void
    {
        $this->shouldThrow('\InvalidArgumentException')->duringOffsetGet('z');
    }

    public function its_data_cannot_be_manipulated(): void
    {
        $this->shouldThrow(UnsupportedOperationException::class)->duringOffsetSet('z', 'baz');
        $this->shouldThrow(UnsupportedOperationException::class)->duringOffsetUnset('x');
    }
}
