<?php

namespace Sid\Framework\View\Engine;

use Sid\Framework\View\EngineInterface;
use Sid\Framework\View\Engine\Php\Renderer;

class Php implements EngineInterface
{
    /**
     * @var string
     */
    protected $viewFolder;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     */
    protected $variables;



    public function __construct($viewFolder = "")
    {
        $this->viewFolder = $viewFolder;
    }



    public function render(string $path, array $variables) : string
    {
        /*
         * This method uses two variables - $path and $variables. As we'll be
         * using `include` to execute the PHP view, we need to use `extract()`
         * so that the view has access to its variables. Unfortunately, we can't
         * have any other variables within the symbol table as that may conflict
         * with the view.
         *
         * To solve this problem, our variables are stored as properties and the
         * variables are unset which removes any possible conflicts. We also
         * overwrite $this when extracting the view's variables as we don't want
         * the view to be aware of this class. Interestingly, we can still use
         * $this within this class.
         */



        // We don't want the view to be able to access this class.
        if (!isset($variables["this"])) {
            $variables["this"] = null;
        }



        $this->path      = $path;
        $this->variables = $variables;

        unset($path);
        unset($variables);



        extract($this->variables);

        ob_start();

        include $this->viewFolder . $this->path . ".php";

        $contents = ob_get_clean();



        $this->path      = null;
        $this->variables = null;



        return $contents;
    }
}
