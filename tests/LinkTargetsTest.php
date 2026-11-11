<?php

declare(strict_types=1);

namespace MunicipioModularityManualInputExtensions\Tests;

use MunicipioModularityManualInputExtensions\LinkTargets;
use PHPUnit\Framework\TestCase;

final class LinkTargetsTest extends TestCase
{
    public function testTargetsBelongToRowsRatherThanUrls(): void
    {
        $rows = array_fill(0, 5, ['link' => 'https://example.test', 'title' => 'Visible title']);
        $raw = [
            ['field_64ff232ad91ba' => ['url' => 'https://example.test', 'target' => '_blank']],
            ['field_64ff232ad91ba' => ['url' => 'https://example.test', 'target' => '']],
            ['link' => ['url' => 'https://example.test', 'target' => '_self']],
            ['link' => 'https://example.test'],
            ['link' => ['target' => ['invalid']]],
        ];
        $result = LinkTargets::withTargets($rows, $raw);
        static::assertSame(['_blank', '', '_self', '', ''], array_column($result, 'link_target'));
        static::assertSame(array_column($rows, 'link'), array_column($result, 'link'));
        static::assertSame(array_column($rows, 'title'), array_column($result, 'title'));
        static::assertSame([], LinkTargets::withTargets([], []));
        static::assertSame([null], LinkTargets::withTargets([null], []));
    }
}
