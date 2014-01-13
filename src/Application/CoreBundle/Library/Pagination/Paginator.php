<?php
namespace Application\CoreBundle\Library\Pagination;

use Application\CoreBundle\Library\Pagination\Adapter\AdapterInterface;

/**
 * Class Paginator
 */
class Paginator
{
    /**
     * @var string
     */
    const DEFAULT_ADAPTER = 'ManagerAdapter';

    /**
     * Максимальное к-во на странице
     * @var String
     */
    const MAX_ON_PAGE = 200;

    /**
     * @var String
     */
    protected $url = null;

    /**
     * Элементов на странице
     * @var Integer
     */
    protected $onPage = 24;

    /**
     * Номер текущей страници
     * @var Integer
     */
    protected $page = 1;

    /**
     * Страниц в диапазоне
     * @var Integer
     */
    protected $pageRange = 5;

    /**
     * Страниц
     * @var Integer
     */
    protected $pageCount = 0;

    /**
     * Список страниц
     * @var array
     */
    protected $pages = null;

    /**
     * Список доп параметров, которые будут передаватся в шаблон
     * @var array
     */
    protected $params = array();

    /**
     * Список доп параметров, которые будут передаватся в URL
     * @var array
     */
    protected $optional = array();

    /**
     * Пареметр
     * @var String
     */
    protected $pageKey = 'page';

    /**
     * @var AdapterInterface
     */
    protected $adapter = null;

    /**
     * @var \Symfony\Bundle\TwigBundle\TwigEngine
     */
    protected $templating;

    /**
     * @var string
     */
    protected $template;

    /**
     * @param \Symfony\Bundle\TwigBundle\TwigEngine $templating
     */
    public function __construct(\Symfony\Bundle\TwigBundle\TwigEngine $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @param AdapterInterface $adapter
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return array
     */
    public function getOptional()
    {
        return $this->optional;
    }

    /**
     * @param array $optional
     *
     * @return Paginator
     */
    public function setOptional(array $optional)
    {
        $this->optional = $optional;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     *
     * @return Paginator
     */
    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * К-во страниц в диапазоне
     *
     * @param int $pageRange
     *
     * @return Paginator
     */
    public function setPageRange($pageRange)
    {
        $this->pageRange = $pageRange;

        return $this;
    }

    /**
     * К-во страниц в диапазоне
     *
     * @return Integer
     */
    public function getPageRange()
    {
        return $this->pageRange;
    }

    /**
     * Текущий номер страницы
     *
     * @return Integer
     */
    public function getPage()
    {
        return $this->normalizePageNumber($this->page);
    }

    /**
     * Текущий номер страницы
     * @param Integer $page
     *
     * @return Paginator
     */
    public function setPage($page)
    {
        $this->page = $this->normalizePageNumber($page);

        return $this;
    }

    /**
     * Базовый урл
     *
     * @param String $url
     *
     * @return Paginator
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Ключ в урле который отвечает за страницу (/news/page/2)
     *
     * @return String
     */
    public function getPageKey()
    {
        return $this->pageKey;
    }

    /**
     * Ключ в урле который отвечает за страницу (/news/page/2)
     *
     * @param String $name
     */
    public function setPageKey($name)
    {
        $this->pageKey = $name;
    }

    /**
     * К-во элементов
     *
     * @return integer
     */
    public function getCount()
    {
        if (!$this->pageCount) {
            $this->pageCount = $this->calculatePageCount();
        }

        return $this->pageCount;
    }

    /**
     * К-во на странице
     *
     * @param Integer $onPage
     *
     * @return Paginator
     */
    public function setOnPage($onPage)
    {
        $this->onPage = $onPage < self::MAX_ON_PAGE ? $onPage : self::MAX_ON_PAGE;

        return $this;
    }

    /**
     * К-во на странице
     * @return integer
     */
    public function getOnPage()
    {
        return $this->onPage;
    }

    /**
     * Получение списка элементов
     *
     * @return array
     */
    public function getItemsByPage()
    {
        return $this->adapter->getItems(($this->getPage() - 1) * $this->getOnPage(), $this->getOnPage());
    }

    /**
     * Формирование URL страницы с параметрами
     *
     * @param int $page
     *
     * @return String
     */
    public function url($page)
    {
        $url = '/';
        if ($this->url && trim($this->url)) {
            $url = '/' . trim($this->url, '/') . '/';
        }

        $params = array(
            array($this->pageKey => $page)
        );
        foreach ($this->optional as $k => $v) {
            $params[] = array($k => $v);
        }

        $get = '';
        foreach ($params as $arr) {
            foreach ($arr as $key => $values) {
                $get .= $this->paramsToUrl($key, $values);
            }
        }

        $separator = strpos($url, '?') === false ? '?' : '&';
        $url = !empty($get) ? rtrim($url, '/') . $separator . ltrim($get, '&') : rtrim($url, '/');

        return $url;
    }

    /**
     * @param string $key
     * @param array  $values
     *
     * @return string
     */
    protected function paramsToUrl($key, $values)
    {
        $url = '';
        foreach ((array) $values as $value) {
            $url .= $key . '=' . $value;
        }

        return $url;
    }

    /**
     * К-во страниц
     * @return Integer
     */
    protected function calculatePageCount()
    {
        return intval(ceil($this->adapter->count() / $this->getOnPage()));
    }

    /**
     * Creates the page collection.
     *
     * @return stdClass
     */
    protected function createPages()
    {
        $currentPageNumber = $this->getPage();
        $pageCount = $this->getCount();
        $pages = new \stdClass();
        $pages->pageCount = $pageCount;
        $pages->itemCountPerPage = $this->getOnPage();
        $pages->first   = array('url' => $this->url(1), 'number' => 1);
        $pages->current = $currentPageNumber;
        $pages->last    = array("url" => $this->url($pageCount), "number" => $pageCount);
        $pages->onPage  = $this->getOnPage();

        // Previous and next
        if ($currentPageNumber - 1 > 0) {
            $pages->previous = array("url" => $this->url($currentPageNumber - 1), "number" => $currentPageNumber - 1);
        }

        if ($currentPageNumber + 1 <= $pageCount) {
            $pages->next = array("url" => $this->url($currentPageNumber + 1), "number" => $currentPageNumber + 1);
        }

        $pages->pagesInRange = $this->getPages();
        foreach ($pages->pagesInRange as &$p) {
            $page['number'] = $p;
            $page['url'] = $this->url($p);
            $p = $page;
        }

        $pages->firstPageInRange = min($pages->pagesInRange);
        $pages->lastPageInRange = max($pages->pagesInRange);

        return $pages;
    }

    /**
     * Returns an array of "local" pages given a page number and range.
     *
     * @return array
     */
    protected function getPages()
    {
        $pageNumber = $this->getPage();
        $pageCount = $this->getCount();
        $pageRange = $this->getPageRange();
        if ($pageRange > $pageCount) {
            $pageRange = $pageCount;
        }

        $delta = ceil($pageRange / 2);

        if ($pageNumber - $delta > $pageCount - $pageRange) {
            $lowerBound = $pageCount - $pageRange + 1;
            $upperBound = $pageCount;
        } else {
            if ($pageNumber - $delta < 0) {
                $delta = $pageNumber;
            }

            $offset = $pageNumber - $delta;
            $lowerBound = $offset + 1;
            $upperBound = $offset + $pageRange;
        }

        if ($lowerBound == 2 && $upperBound - $lowerBound == $pageRange - 1) {
            --$upperBound;
        }

        if ($lowerBound == $pageCount - $pageRange && $lowerBound > 1) {
            ++$lowerBound;
        }

        return $this->getPagesInRange($lowerBound, $upperBound);
    }

    /**
     * Returns the page collection.
     *
     * @return Paginator
     */
    public function generatePages()
    {
        if ($this->pages === null) {
            $this->pages = $this->createPages();
        }

        return $this;
    }

    /**
     * Returns a subset of pages within a given range.
     *
     * @param integer $lowerBound Lower bound of the range
     * @param integer $upperBound Upper bound of the range
     *
     * @return array
     */
    public function getPagesInRange($lowerBound, $upperBound)
    {
        $lowerBound = $this->normalizePageNumber($lowerBound);
        $upperBound = $this->normalizePageNumber($upperBound);

        $pages = array();

        for ($pageNumber = $lowerBound; $pageNumber <= $upperBound; $pageNumber++) {
            $pages[$pageNumber] = $pageNumber;
        }

        return $pages;
    }

    /**
     * Brings the page number in range of the paginator.
     *
     * @param integer $pageNumber
     *
     * @return integer
     */
    protected function normalizePageNumber($pageNumber)
    {
        if ($pageNumber < 1) {
            $pageNumber = 1;
        }

        $pageCount = $this->getCount();
        if ($pageCount > 0 && $pageNumber > $pageCount) {
            $pageNumber = $pageCount;
        }

        return $pageNumber;
    }


    /**
     * Рендеринг
     *
     * @param String $script
     *
     * @return String
     */
    public function render($script = null)
    {
        $this->generatePages();

        $params = $this->params;
        foreach ($this->pages as $k => $v) {
            $params[$k] = $v;
        }

        return $this->templating->render($script ? $script : $this->getTemplate(), $params);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}