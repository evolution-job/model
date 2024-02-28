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
use Xabbuh\XApi\Model\Account;
use Xabbuh\XApi\Model\Agent;
use Xabbuh\XApi\Model\InverseFunctionalIdentifier;
use Xabbuh\XApi\Model\IRI;
use Xabbuh\XApi\Model\IRL;
use Xabbuh\XApi\Model\Person;

class PersonSpec extends ObjectBehavior
{
    public function it_can_be_built_from_an_array_of_agents(): void
    {
        $agents = [new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com'))), new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')))];

        $this->beConstructedThrough('createFromAgents', [$agents]);

        $this->shouldHaveType(Person::class);
    }

    public function it_has_mboxes_from_agents(): void
    {
        $iri = IRI::fromString('mailto:conformancetest@tincanapi.com');
        $mbox2 = IRI::fromString('mailto:conformancetest2@tincanapi.com');
        $agents = [new Agent(InverseFunctionalIdentifier::withMbox($iri)), new Agent(InverseFunctionalIdentifier::withMbox($mbox2))];

        $this->beConstructedThrough('createFromAgents', [$agents]);

        $this->getMboxes()->shouldReturn([$iri, $mbox2]);
    }

    public function it_has_mbox_sha_1_sums_from_agents(): void
    {
        $sha1Sum = 'sha1Sum';
        $sha1Sum2 = 'sha1Sum2';
        $agents = [new Agent(InverseFunctionalIdentifier::withMboxSha1Sum($sha1Sum)), new Agent(InverseFunctionalIdentifier::withMboxSha1Sum($sha1Sum2))];

        $this->beConstructedThrough('createFromAgents', [$agents]);

        $this->getMboxSha1Sums()->shouldReturn([$sha1Sum, $sha1Sum2]);
    }

    public function it_has_open_ids_from_agents(): void
    {
        $openId = 'openId';
        $openId2 = 'openId2';
        $agents = [new Agent(InverseFunctionalIdentifier::withOpenId($openId)), new Agent(InverseFunctionalIdentifier::withOpenId($openId2))];

        $this->beConstructedThrough('createFromAgents', [$agents]);

        $this->getOpenIds()->shouldReturn([$openId, $openId2]);
    }

    public function it_has_accounts_from_agents(): void
    {
        $account = new Account('test', IRL::fromString('http://example.com'));
        $account2 = new Account('test2', IRL::fromString('http://example.com'));
        $agents = [new Agent(InverseFunctionalIdentifier::withAccount($account)), new Agent(InverseFunctionalIdentifier::withAccount($account2))];

        $this->beConstructedThrough('createFromAgents', [$agents]);

        $this->getAccounts()->shouldReturn([$account, $account2]);
    }

    public function it_has_names_from_agents(): void
    {
        $name = 'name';
        $name2 = 'name2';
        $agents = [new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')), $name), new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')), $name2)];

        $this->beConstructedThrough('createFromAgents', [$agents]);

        $this->getNames()->shouldReturn([$name, $name2]);
    }
}
