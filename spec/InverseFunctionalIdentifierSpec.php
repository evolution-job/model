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
use Xabbuh\XApi\Model\InverseFunctionalIdentifier;
use Xabbuh\XApi\Model\IRI;
use Xabbuh\XApi\Model\IRL;

class InverseFunctionalIdentifierSpec extends ObjectBehavior
{
    public function it_can_be_built_with_an_mbox(): void
    {
        $iri = IRI::fromString('mailto:conformancetest@tincanapi.com');
        $this->beConstructedThrough(
            static function (IRI $mbox): InverseFunctionalIdentifier {
                return InverseFunctionalIdentifier::withMbox($mbox);
            },
            [$iri]
        );

        $this->getMbox()->shouldReturn($iri);
        $this->getMboxSha1Sum()->shouldReturn(null);
        $this->getOpenId()->shouldReturn(null);
        $this->getAccount()->shouldReturn(null);
    }

    public function it_can_be_built_with_an_mbox_sha1_sum(): void
    {
        $this->beConstructedThrough(
            static function (string $mboxSha1Sum): InverseFunctionalIdentifier {
                return InverseFunctionalIdentifier::withMboxSha1Sum($mboxSha1Sum);
            },
            ['db77b9104b531ecbb0b967f6942549d0ba80fda1']
        );

        $this->getMbox()->shouldReturn(null);
        $this->getMboxSha1Sum()->shouldReturn('db77b9104b531ecbb0b967f6942549d0ba80fda1');
        $this->getOpenId()->shouldReturn(null);
        $this->getAccount()->shouldReturn(null);
    }

    public function it_can_be_built_with_an_openid(): void
    {
        $this->beConstructedThrough(
            static function (string $openId): InverseFunctionalIdentifier {
                return InverseFunctionalIdentifier::withOpenId($openId);
            },
            ['http://openid.tincanapi.com']
        );

        $this->getMbox()->shouldReturn(null);
        $this->getMboxSha1Sum()->shouldReturn(null);
        $this->getOpenId()->shouldReturn('http://openid.tincanapi.com');
        $this->getAccount()->shouldReturn(null);
    }

    public function it_can_be_built_with_an_account(): void
    {
        $account = new Account('test', IRL::fromString('https://tincanapi.com'));
        $this->beConstructedThrough(
            static function (Account $account): InverseFunctionalIdentifier {
                return InverseFunctionalIdentifier::withAccount($account);
            },
            [$account]
        );

        $this->getMbox()->shouldReturn(null);
        $this->getMboxSha1Sum()->shouldReturn(null);
        $this->getOpenId()->shouldReturn(null);
        $this->getAccount()->shouldReturn($account);
    }

    public function it_is_equal_when_mboxes_are_equal(): void
    {
        $this->beConstructedThrough('withMbox', [IRI::fromString('mailto:conformancetest@tincanapi.com')]);

        $this->equals(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')))->shouldReturn(true);
    }

    public function it_is_equal_when_mbox_sha1_sums_are_equal(): void
    {
        $this->beConstructedThrough('withMboxSha1Sum', ['db77b9104b531ecbb0b967f6942549d0ba80fda1']);

        $this->equals(InverseFunctionalIdentifier::withMboxSha1Sum('db77b9104b531ecbb0b967f6942549d0ba80fda1'))->shouldReturn(true);
    }

    public function it_is_equal_when_open_ids_are_equal(): void
    {
        $this->beConstructedThrough('withOpenId', ['http://openid.tincanapi.com']);

        $this->equals(InverseFunctionalIdentifier::withOpenId('http://openid.tincanapi.com'))->shouldReturn(true);
    }

    public function it_is_equal_when_accounts_are_equal(): void
    {
        $this->beConstructedThrough('withAccount', [new Account('test', IRL::fromString('https://tincanapi.com'))]);

        $this->equals(InverseFunctionalIdentifier::withAccount(new Account('test', IRL::fromString('https://tincanapi.com'))))->shouldReturn(true);
    }

    public function its_mbox_value_can_be_retrieved_as_a_string(): void
    {
        $this->beConstructedWithMbox(IRI::fromString('mailto:conformancetest@tincanapi.com'));

        $this->__toString()->shouldReturn('mailto:conformancetest@tincanapi.com');
    }

    public function its_mbox_sha1_sum_value_can_be_retrieved_as_a_string(): void
    {
        $this->beConstructedWithMboxSha1Sum('db77b9104b531ecbb0b967f6942549d0ba80fda1');

        $this->__toString()->shouldReturn('db77b9104b531ecbb0b967f6942549d0ba80fda1');
    }

    public function its_open_id_value_can_be_retrieved_as_a_string(): void
    {
        $this->beConstructedWithOpenId('http://openid.tincanapi.com');

        $this->__toString()->shouldReturn('http://openid.tincanapi.com');
    }

    public function its_account_value_can_be_retrieved_as_a_string(): void
    {
        $this->beConstructedWithAccount(new Account('test', IRL::fromString('https://tincanapi.com')));

        $this->__toString()->shouldReturn('test (https://tincanapi.com)');
    }
}
