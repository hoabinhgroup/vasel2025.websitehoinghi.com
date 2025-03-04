<?php

namespace Modules\Base\Console;

use Illuminate\Console\Command;
use Modules\Base\Console\Abstracts\BaseMakeCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use File;
use Illuminate\Support\Str;
use League\Flysystem\FileNotFoundException;

class ModuleCreateCommand extends BaseMakeCommand
{
   /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'module:create {name : The plugin that you want to create} {--force : Overwrite any existing files.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a plugin in the /Modules directory.';

    /**
     * Execute the console command.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws FileNotFoundException
     */
    public function handle()
    {
        if (!preg_match('/^[a-z0-9\-]+$/i', $this->argument('name'))) {
            $this->error('Only alphabetic characters are allowed.');
            return false;
        }

        $plugin = ucfirst($this->argument('name'));
        $location = plugin_path($plugin);

        if (File::isDirectory($location)) {
            $this->error('A plugin named [' . $plugin . '] already exists.');
            return false;
        }

        $this->publishStubs($this->getStub(), $location);
        File::copy(__DIR__ . '/../stubs/module.json', $location . '/module.json');
        //File::copy(__DIR__ . '/../../stubs/Plugin.stub', $location . '/src/Plugin.php');
        $this->renameFiles($plugin, $location);
        $this->searchAndReplaceInFiles($plugin, $location);
        $this->removeUnusedFiles($location);
        $this->line('------------------');
        $this->line('<info>The plugin</info> <comment>' . $plugin . '</comment> <info>was created in</info> <comment>' . $location . '</comment><info>, customize it!</info>');
        $this->line('------------------');
        $this->call('cache:clear');

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getStub(): string
    {
        return __DIR__ . '/../stubs/module';
    }

    /**
     * @param string $location
     */
    protected function removeUnusedFiles(string $location)
    {
        $files = [
            //'composer.json',
        ];

        foreach ($files as $file) {
            File::delete($location . '/' . $file);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getReplacements(string $replaceText): array
    {
        return [
            '{type}'     => 'plugin',
            '{types}'    => 'plugins',
            '{-module}'  => strtolower($replaceText),
            '{module}'   => Str::snake(str_replace('-', '_', $replaceText)),
            '{+module}'  => Str::camel($replaceText),
            '{modules}'  => Str::plural(Str::snake(str_replace('-', '_', $replaceText))),
            '{Modules}'  => ucfirst(Str::plural(Str::snake(str_replace('-', '_', $replaceText)))),
            '{-modules}' => Str::plural($replaceText),
            '{MODULE}'   => strtoupper(Str::snake(str_replace('-', '_', $replaceText))),
            '{Module}'   => ucfirst(Str::camel($replaceText)),
        ];
    }
}
