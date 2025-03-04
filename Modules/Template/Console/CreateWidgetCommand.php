<?php

namespace Modules\Template\Console;

use Modules\Base\Console\Abstracts\BaseMakeCommand;
use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Support\Str;
use League\Flysystem\FileNotFoundException;

class CreateWidgetCommand extends BaseMakeCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'module:widget:create {name : The widget that you want to create} {module : Name module that you want to create in}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new widget';

    /**
     * @var File
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param File $files
     */
    public function __construct(File $files)
    {
        $this->files = $files;

        parent::__construct();
    }

    /**
     * @return bool
     * @throws FileNotFoundException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
	    $module = $this->argument('module');
	    
        $widget = $this->getWidget();
        $path = $this->getPath($module);
        $viewPath = $this->getviewPath($module);

        if (is_file($path. '/' . $widget)) {
            $this->error('Widget "' . $widget . '" is already exists.');
            return false;
        }

        $this->publishStubs($this->getStub(), $path);
        $this->publishStubs($this->getViewStub(), $viewPath);
        $this->searchAndReplaceInFiles($widget, $path);
        $this->searchAndReplaceInFiles($widget, $viewPath);
        $this->renameFiles($widget, $path);
        $this->renameFiles($widget, $viewPath);

        $this->info('Widget "' . $widget . '" has been created!');

        return true;
    }
    
    public function getModuleName()
    {
	    return ucfirst($this->argument('module'));
    }

    /**
     * Get the theme name.
     *
     * @return string
     */
    protected function getWidget()
    {
        return strtolower($this->argument('name'));
    }

    /**
     * Get the destination view path.
     *
     * @return string
     */
    protected function getPath($module)
    {
	    //return platform_path($module . '/Widgets/' . $this->getWidget());
	    return platform_path($module . '/Widgets');
    }
    
    
     protected function getViewPath($module)
    {
	    return platform_path($module . '/Resources/views/widgets');
    }
  

    /**
     * {@inheritDoc}
     */
    public function getStub(): string
    {
        return __DIR__ . '/../Stubs/Controller';
    }
    
    /**
     * {@inheritDoc}
     */
    public function getViewStub(): string
    {
        return __DIR__ . '/../Stubs/Views';
    }

    /**
     * {@inheritDoc}
     */
    public function getReplacements(string $replaceText): array
    {
        return [
            '{widget}' => strtolower($replaceText),
            '{Widget}' => Str::studly($replaceText),
            '{-widget}' => strtolower(Str::snake($replaceText)),
            '{-module}'  => strtolower($this->getModuleName()),
            '{module}' => Str::snake(str_replace('-', '_', $this->getModuleName())),
            '{Modules}'  => ucfirst(Str::plural(Str::snake(str_replace('-', '_', $this->getModuleName())))),
            '{Module}'   => ucfirst(Str::camel($this->getModuleName()))
        ];
    }
}
