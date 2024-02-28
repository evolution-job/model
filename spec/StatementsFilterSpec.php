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

use DateTime;
use PhpSpec\ObjectBehavior;
use Xabbuh\XApi\Model\Activity;
use Xabbuh\XApi\Model\Agent;
use Xabbuh\XApi\Model\InverseFunctionalIdentifier;
use Xabbuh\XApi\Model\IRI;
use Xabbuh\XApi\Model\LanguageMap;
use Xabbuh\XApi\Model\Verb;

class StatementsFilterSpec extends ObjectBehavior
{
    public function it_does_not_filter_anything_by_default(): void
    {
        $filter = $this->getFilter();
        $filter->shouldHaveCount(0);
    }

    public function it_can_filter_by_actor(): void
    {
        $agent = new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));
        $this->byActor($agent)->shouldReturn($this);

        $filter = $this->getFilter();
        $filter->shouldHaveCount(1);
        $filter->shouldHaveKeyWithValue('agent', $agent);
    }

    public function it_can_filter_by_verb(): void
    {
        $this->byVerb(new Verb(IRI::fromString('http://tincanapi.com/conformancetest/verbid'), LanguageMap::create(['en-US' => 'test'])))->shouldReturn($this);

        $filter = $this->getFilter();
        $filter->shouldHaveCount(1);
        $filter->shouldHaveKeyWithValue('verb', 'http://tincanapi.com/conformancetest/verbid');
    }

    public function it_can_filter_by_activity(): void
    {
        IRI::fromString('http://tincanapi.com/conformancetest/activityid');
        $this->byActivity(new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid')))->shouldReturn($this);

        $filter = $this->getFilter();
        $filter->shouldHaveCount(1);
        $filter->shouldHaveKeyWithValue('activity', 'http://tincanapi.com/conformancetest/activityid');
    }

    public function it_can_filter_by_registration(): void
    {
        $this->byRegistration('foo')->shouldReturn($this);

        $filter = $this->getFilter();
        $filter->shouldHaveCount(1);
        $filter->shouldHaveKeyWithValue('registration', 'foo');
    }

    public function it_can_enable_to_filter_related_activities(): void
    {
        $this->enableRelatedActivityFilter()->shouldReturn($this);

        $filter = $this->getFilter();
        $filter->shouldHaveCount(1);
        $filter->shouldHaveKeyWithValue('related_activities', 'true');
    }

    public function it_can_disable_to_filter_related_activities(): void
    {
        $this->disableRelatedActivityFilter()->shouldReturn($this);

        $filter = $this->getFilter();
        $filter->shouldHaveCount(1);
        $filter->shouldHaveKeyWithValue('related_activities', 'false');
    }

    public function it_can_enable_to_filter_related_agents(): void
    {
        $this->enableRelatedAgentFilter()->shouldReturn($this);

        $filter = $this->getFilter();
        $filter->shouldHaveCount(1);
        $filter->shouldHaveKeyWithValue('related_agents', 'true');
    }

    public function it_can_disable_to_filter_related_agents(): void
    {
        $this->disableRelatedAgentFilter()->shouldReturn($this);

        $filter = $this->getFilter();
        $filter->shouldHaveCount(1);
        $filter->shouldHaveKeyWithValue('related_agents', 'false');
    }

    public function it_can_filter_by_timestamp(): void
    {
        $this->since(DateTime::createFromFormat(DateTime::ATOM, '2013-05-18T05:32:34Z'))->shouldReturn($this);
        $this->getFilter()->shouldHaveKeyWithValue('since', '2013-05-18T05:32:34+00:00');

        $this->until(DateTime::createFromFormat(DateTime::ATOM, '2014-05-18T05:32:34Z'))->shouldReturn($this);
        $this->getFilter()->shouldHaveKeyWithValue('until', '2014-05-18T05:32:34+00:00');
    }

    public function it_can_sort_the_result_in_ascending_order(): void
    {
        $this->ascending()->shouldReturn($this);

        $filter = $this->getFilter();
        $filter->shouldHaveCount(1);
        $filter->shouldHaveKeyWithValue('ascending', 'true');
    }

    public function it_can_sort_the_result_in_descending_order(): void
    {
        $this->descending()->shouldReturn($this);

        $filter = $this->getFilter();
        $filter->shouldHaveCount(1);
        $filter->shouldHaveKeyWithValue('ascending', 'false');
    }

    public function it_can_limit_the_number_of_results(): void
    {
        $this->limit(10)->shouldReturn($this);

        $filter = $this->getFilter();
        $filter->shouldHaveCount(1);
        $filter->shouldHaveKeyWithValue('limit', 10);
    }

    public function it_rejects_choosing_a_negative_number_of_results(): void
    {
        $this->shouldThrow('\InvalidArgumentException')->duringLimit(-1);
    }
}
