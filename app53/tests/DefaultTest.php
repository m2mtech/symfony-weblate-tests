<?php
/*
 * This file is part of the weblate-translation-provider package.
 *
 * (c) 2022 m2m server software gmbh <tech@m2m.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests;

class DefaultTest extends AbstractWeblateTest
{
    public function test(): void
    {
        $this->copyTranslationDirectory('default', 'step1.setup');
        $this->assertCommandRun('translation:push', ['provider' => 'weblate']);

        $this->resetApplication();
        $this->cleanUpTranslationDirectory();
        $this->assertCommandRun('translation:pull', ['provider' => 'weblate', '--format' => 'yaml']);
        $this->assertTranslationDirectoryContent('default', 'step1.result');

        $this->resetApplication();
        $this->cleanUpTranslationDirectory();
        $this->copyTranslationDirectory('default', 'step2.setup');
        $this->assertCommandRun('translation:push', ['provider' => 'weblate']);

        $this->resetApplication();
        $this->cleanUpTranslationDirectory();
        $this->assertCommandRun('translation:pull', ['provider' => 'weblate', '--format' => 'yaml']);
        $this->assertTranslationDirectoryContent('default', 'step2.result');

        $this->resetApplication();
        $this->cleanUpTranslationDirectory();
        $this->copyTranslationDirectory('default', 'step3.setup');
        $this->assertCommandRun('translation:push', ['provider' => 'weblate', '--force' => true]);

        $this->resetApplication();
        $this->cleanUpTranslationDirectory();
        $this->assertCommandRun('translation:pull', ['provider' => 'weblate', '--format' => 'yaml']);
        $this->assertTranslationDirectoryContent('default', 'step3.result');

        $this->resetApplication();
        $this->cleanUpTranslationDirectory();
        $this->copyTranslationDirectory('default', 'step4.setup');
        $this->assertCommandRun('translation:push', ['provider' => 'weblate', '--delete-missing' => true]);

        $this->resetApplication();
        $this->cleanUpTranslationDirectory();
        $this->assertCommandRun('translation:pull', ['provider' => 'weblate', '--format' => 'yaml']);
        $this->assertTranslationDirectoryContent('default', 'step4.result');
    }
}
