<?php

namespace spec\Xabbuh\XApi\Model;

use PhpSpec\ObjectBehavior;
use SplObjectStorage;
use Xabbuh\XApi\Model\Agent;
use Xabbuh\XApi\Model\Context;
use Xabbuh\XApi\Model\ContextActivities;
use Xabbuh\XApi\Model\Extensions;
use Xabbuh\XApi\Model\Group;
use Xabbuh\XApi\Model\InverseFunctionalIdentifier;
use Xabbuh\XApi\Model\IRI;
use Xabbuh\XApi\Model\StatementId;
use Xabbuh\XApi\Model\StatementReference;

class ContextSpec extends ObjectBehavior
{
    public function its_properties_are_empty_by_default(): void
    {
        $this->getRegistration()->shouldBeNull();
        $this->getInstructor()->shouldBeNull();
        $this->getTeam()->shouldBeNull();
        $this->getContextActivities()->shouldBeNull();
        $this->getRevision()->shouldBeNull();
        $this->getPlatform()->shouldBeNull();
        $this->getLanguage()->shouldBeNull();
        $this->getStatement()->shouldBeNull();
        $this->getExtensions()->shouldBeNull();
    }

    public function it_returns_a_new_instance_with_registration(): void
    {
        $context = $this->withRegistration('12345678-1234-5678-8234-567812345678');

        $this->getRegistration()->shouldBeNull();

        $context->shouldNotBe($this);
        $context->shouldBeAnInstanceOf(Context::class);
        $context->getRegistration()->shouldReturn('12345678-1234-5678-8234-567812345678');
    }

    public function it_returns_a_new_instance_with_instructor(): void
    {
        $agent = new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));
        $context = $this->withInstructor($agent);

        $this->getInstructor()->shouldBeNull();

        $context->shouldNotBe($this);
        $context->shouldBeAnInstanceOf(Context::class);
        $context->getInstructor()->shouldReturn($agent);
    }

    public function it_returns_a_new_instance_with_team(): void
    {
        $group = new Group(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')), 'team');
        $context = $this->withTeam($group);

        $this->getTeam()->shouldBeNull();

        $context->shouldNotBe($this);
        $context->shouldBeAnInstanceOf(Context::class);
        $context->getTeam()->shouldReturn($group);
    }

    public function it_returns_a_new_instance_with_context_activities(): void
    {
        $contextActivities = new ContextActivities();
        $context = $this->withContextActivities($contextActivities);

        $this->getContextActivities()->shouldBeNull();

        $context->shouldNotBe($this);
        $context->shouldBeAnInstanceOf(Context::class);
        $context->getContextActivities()->shouldReturn($contextActivities);
    }

    public function it_returns_a_new_instance_with_revision(): void
    {
        $context = $this->withRevision('test');

        $this->getRevision()->shouldBeNull();

        $context->shouldNotBe($this);
        $context->shouldBeAnInstanceOf(Context::class);
        $context->getRevision()->shouldReturn('test');
    }

    public function it_returns_a_new_instance_with_platform(): void
    {
        $context = $this->withPlatform('test');

        $this->getPlatform()->shouldBeNull();

        $context->shouldNotBe($this);
        $context->shouldBeAnInstanceOf(Context::class);
        $context->getPlatform()->shouldReturn('test');
    }

    public function it_returns_a_new_instance_with_language(): void
    {
        $context = $this->withLanguage('en-US');

        $this->getLanguage()->shouldBeNull();

        $context->shouldNotBe($this);
        $context->shouldBeAnInstanceOf(Context::class);
        $context->getLanguage()->shouldReturn('en-US');
    }

    public function it_returns_a_new_instance_with_statement_reference(): void
    {
        $statementReference = new StatementReference(StatementId::fromString('16fd2706-8baf-433b-82eb-8c7fada847da'));
        $context = $this->withStatement($statementReference);

        $this->getStatement()->shouldBeNull();

        $context->shouldNotBe($this);
        $context->shouldBeAnInstanceOf(Context::class);
        $context->getStatement()->shouldReturn($statementReference);
    }

    public function it_returns_a_new_instance_with_extensions(): void
    {
        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');
        $extensions = new Extensions($extensions);

        $context = $this->withExtensions($extensions);

        $this->getExtensions()->shouldBeNull();

        $context->shouldNotBe($this);
        $context->shouldBeAnInstanceOf(Context::class);
        $context->getExtensions()->shouldReturn($extensions);
    }

    public function it_is_not_equal_to_other_context_if_only_this_context_has_a_team(): void
    {
        $context = $this->withTeam(new Group());

        $context->equals(new Context())->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_context_if_only_the_other_context_has_a_team(): void
    {
        $otherContext = $this->withTeam(new Group());

        $this->equals($otherContext)->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_context_if_teams_are_not_equal(): void
    {
        $context = $this->withTeam(new Group());

        $otherContext = new Context();
        $otherContext = $otherContext->withTeam(new Group(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest-group@tincanapi.com'))));

        $context->equals($otherContext)->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_context_if_only_this_context_has_a_statement_reference(): void
    {
        $context = $this->withStatement(new StatementReference(StatementId::fromString('16fd2706-8baf-433b-82eb-8c7fada847da')));

        $context->equals(new Context())->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_context_if_only_the_other_context_has_a_statement_reference(): void
    {
        $otherContext = $this->withStatement(new StatementReference(StatementId::fromString('16fd2706-8baf-433b-82eb-8c7fada847da')));

        $this->equals($otherContext)->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_context_if_statement_references_are_not_equal(): void
    {
        $context = $this->withStatement(new StatementReference(StatementId::fromString('16fd2706-8baf-433b-82eb-8c7fada847da')));

        $otherContext = new Context();
        $otherContext = $otherContext->withStatement(new StatementReference(StatementId::fromString('39e24cc4-69af-4b01-a824-1fdc6ea8a3af')));

        $context->equals($otherContext)->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_context_if_only_this_context_has_extensions(): void
    {
        $context = $this->withExtensions(new Extensions());

        $context->equals(new Context())->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_context_if_only_the_other_context_has_extensions(): void
    {
        $otherContext = $this->withExtensions(new Extensions());

        $this->equals($otherContext)->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_context_if_extensions_are_not_equal(): void
    {
        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/subject'), 'Conformance Testing');

        $context = $this->withExtensions(new Extensions($extensions));

        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');

        $otherContext = new Context();
        $otherContext = $otherContext->withExtensions(new Extensions($extensions));

        $context->equals($otherContext)->shouldReturn(false);
    }
}
