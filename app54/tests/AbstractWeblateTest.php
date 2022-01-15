<?php
/*
 * This file is part of the weblate-translation-provider package.
 *
 * (c) 2022 m2m server software gmbh <tech@m2m.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests;

use M2MTech\WeblateTranslationProvider\Api\ComponentApi;
use SplFileInfo;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Provider\TranslationProviderCollection;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

abstract class AbstractWeblateTest extends KernelTestCase
{
    /** @var Application */
    protected $application;

    /** @var string */
    protected $translationPath;

    /**
     * @throws ExceptionInterface
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->resetApplication();

        $container = static::getContainer();
        /** @var TranslationProviderCollection $translationProviderCollection */
        $translationProviderCollection = $container->get('translation.provider_collection');
        $translationProviderCollection->get('weblate');

        $path = $container->getParameter('translator.default_path');
        if (!is_string($path)) {
            $this->fail();
        }
        $this->translationPath = $path;

        $this->cleanUpWeblate();
        $this->cleanUpTranslationDirectory();
    }

    protected function resetApplication(): void
    {
        $kernel = self::bootKernel();
        $this->application = new Application($kernel);
    }

    /**
     * @throws ExceptionInterface
     */
    protected function cleanUpWeblate(): void
    {
        $components = ComponentApi::getComponents();
        foreach ($components as $component) {
            ComponentApi::deleteComponent($component);
        }

        while (ComponentApi::getComponents(true)) {
            sleep(1);
        }
    }

    protected function cleanUpTranslationDirectory(): void
    {
        $finder = new Finder();
        foreach ($finder->in($this->translationPath) as $file) {
            unlink($file->getPathname());
        }
    }

    protected function getTranslationFilepath(string $prefix, SplFileInfo $file): string
    {
        return $this->translationPath.'/'.str_replace($prefix.'.', '', $file->getFilename());
    }

    protected function copyTranslationDirectory(string $path, string $prefix): void
    {
        $finder = new Finder();
        foreach ($finder->name($prefix.'.*')->in(__DIR__.'/'.$path) as $file) {
            copy($file->getPathname(), $this->getTranslationFilepath($prefix, $file));
        }
    }

    protected function assertTranslationDirectoryContent(string $path, string $prefix): void
    {
        $finder = new Finder();
        foreach ($finder->name($prefix.'.*')->in(__DIR__.'/'.$path) as $file) {
            $this->assertFileEquals($file->getPathname(), $this->getTranslationFilepath($prefix, $file));
        }
    }

    /**
     * @param array<string, string|bool> $options
     */
    protected function assertCommandRun(string $commandName, array $options): string
    {
        $command = $this->application->find($commandName);
        $commandTester = new CommandTester($command);
        $commandTester->execute($options);
        $commandTester->assertCommandIsSuccessful();

        return $commandTester->getDisplay();
    }
}
