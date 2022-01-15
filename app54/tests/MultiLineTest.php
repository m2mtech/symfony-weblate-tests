<?php
/*
 * This file is part of the weblate-translation-provider package.
 *
 * (c) 2022 m2m server software gmbh <tech@m2m.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests;

class MultiLineTest extends AbstractWeblateTest
{
    public function test(): void
    {
        $this->copyTranslationDirectory('multiLine', 'step1.setup');
        $this->assertCommandRun('translation:push', ['provider' => 'weblate']);

        $this->resetApplication();
        $this->cleanUpTranslationDirectory();
        $this->assertCommandRun('translation:pull', ['provider' => 'weblate', '--format' => 'yaml']);
        $this->assertTranslationDirectoryContent('multiLine', 'step1.result');

        $this->resetApplication();
        $this->cleanUpTranslationDirectory();
        $this->copyTranslationDirectory('multiLine', 'step2.setup');
        $this->assertCommandRun('translation:push', ['provider' => 'weblate', '--force' => true]);

        $this->resetApplication();
        $this->cleanUpTranslationDirectory();
        $this->assertCommandRun('translation:pull', ['provider' => 'weblate', '--format' => 'yaml']);
        $this->assertTranslationDirectoryContent('multiLine', 'step2.result');
    }
}
