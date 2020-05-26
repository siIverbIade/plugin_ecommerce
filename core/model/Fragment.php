<?php

declare(strict_types=1);

namespace Spreng\model;

use Twig\Lexer;
use Twig\Environment;
use Spreng\model\Template;
use Spreng\config\SessionConfig;
use Twig\Loader\FilesystemLoader;

abstract class Fragment implements Template
{
    private string $folder;
    private string $template;

    public function __construct(string $template = '', string $folder = '')
    {
        $this->folder = $folder;
        $this->template = $template;
    }

    private function set(array $obj): string
    {
        $template = $this->template;
        $modelConfig = SessionConfig::getModelConfig();
        $rootpath = SessionConfig::getSystemConfig()->getSourcePath() . '\\' . $modelConfig->getTemplateRoot();
        $env = new Environment(new FilesystemLoader("$rootpath/$this->folder"), [
            'auto_reload' => $modelConfig->isAutoReloadEnabled(),
            'cache' => "$rootpath/$this->folder/compilation_cache",
        ]);

        $env->setLexer(new Lexer($env, [
            'tag_block' => ['@@', '@@'],
            'tag_variable' => ['$', '$'],
        ]));
        return $env->render($template . '.html', $obj);
    }

    public function show()
    {
        session_reset();
        return $this->set(get_object_vars($this));
    }

    public function build()
    {
    }
}
