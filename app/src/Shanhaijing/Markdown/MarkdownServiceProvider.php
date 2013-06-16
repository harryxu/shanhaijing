<?php namespace Shanhaijing\Markdown;

use Illuminate\Support\ServiceProvider;
use dflydev\markdown\MarkdownExtraParser;

class MarkdownServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('markdown', function()
        {
            return new MarkdownExtraParser();
        });
    }
}

