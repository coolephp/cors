<?php

/**
 * This file is part of the coolephp/cors.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Coole\Cors\Tests\Benchmark;

use Coole\Cors\PackageSkeleton;

/**
 * @BeforeMethods({"setUp"})
 */
final class PackageSkeletonBench
{
    /**
     * @var \Coole\Cors\PackageSkeleton
     */
    private $packageSkeleton;

    public function setUp(): void
    {
        $this->packageSkeleton = new PackageSkeleton();
    }

    public function benchTest(): void
    {
        // $this->packageSkeleton->test();
        PackageSkeleton::test();
    }
}
