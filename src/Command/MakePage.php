<?php namespace Anomaly\DefaultPageHandlerExtension\Command;

use Anomaly\PagesModule\Page\Contract\PageInterface;
use Anomaly\PagesModule\Page\PageAssets;
use Anomaly\PagesModule\Page\PageAuthorizer;
use Anomaly\PagesModule\Page\PageBreadcrumb;
use Anomaly\PagesModule\Page\PageContent;
use Anomaly\PagesModule\Page\PageLoader;
use Anomaly\PagesModule\Page\PageResponse;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class MakePage
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\DefaultPageHandlerExtension\Command
 */
class MakePage implements SelfHandling
{

    /**
     * The page instance.
     *
     * @var PageInterface
     */
    protected $page;

    /**
     * Create a new MakePage instance.
     *
     * @param PageInterface $page
     */
    public function __construct(PageInterface $page)
    {
        $this->page = $page;
    }

    /**
     * Handle the command.
     *
     * @param PageAssets     $assets
     * @param PageLoader     $loader
     * @param PageContent    $content
     * @param PageResponse   $response
     * @param PageAuthorizer $authorizer
     * @param PageBreadcrumb $breadcrumb
     */
    public function handle(
        PageAssets $assets,
        PageLoader $loader,
        PageContent $content,
        PageResponse $response,
        PageAuthorizer $authorizer,
        PageBreadcrumb $breadcrumb
    ) {
        $assets->add($this->page);
        $authorizer->authorize($this->page);
        $breadcrumb->make($this->page);
        $loader->load($this->page);

        $content->make($this->page);
        $response->make($this->page);
    }
}
