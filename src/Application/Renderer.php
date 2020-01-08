<?php
declare(strict_types=1);
namespace OliverHader\HardCode\Application;

use OliverHader\HardCode\Domain\BookRepository;
use TYPO3Fluid\Fluid\View\TemplateView;

class Renderer
{
    /**
     * @var string
     */
    private $rootDirectory;

    /**
     * @var BookRepository
     */
    private $bookRepository;

    /**
     * @var string
     */
    private $content;

    public function __construct(string $rootDirectory)
    {
        $this->rootDirectory = $rootDirectory;
        $this->bookRepository = new BookRepository();
    }

    public function render()
    {
        $books = $this->bookRepository->findAll();

        $view = new TemplateView();
        $view->getTemplatePaths()->setTemplatePathAndFilename(
            $this->rootDirectory . '/res/Index.html'
        );
        $view->assign('books', $books);

        $this->content = $view->render();
    }

    public function output()
    {
        header('Content-Type: text/html');
        echo $this->content;
    }
}
