<?php
declare(strict_types = 1);

namespace vvt;

final class Pagination
{
    private int $numPages = 1;
    private int $currentPage = 1;
    private string $uri = '';
    private int $midSize = 2;
    private int $allPages = 3;

    public function __construct(
        public int $pageNumber = 1,
        public int $perPage = 1,
        public int $totalPosts = 1,
    )
    { 
        $this->numPages = $this->getPages();
        $this->currentPage = $this->getCurrentPage();
        $this->uri = $this->getParams();
        $this->midSize = $this->getMidSize();
    }
    public function getPages():int
    {
        return max(1, intdiv( $this->totalPosts + $this->perPage - 1, $this->perPage ));
    }
    private function getCurrentPage():int
    {
        if($this->pageNumber < 1){
            $this->pageNumber = 1;
        }
        if($this->pageNumber > $this->numPages){
            throw new \InvalidArgumentException("Номер страницы больше, чем максимальный");
        }
        return $this->pageNumber;
    }
    public function getOffset():int
    {
        return ($this->pageNumber * $this->perPage) - $this->perPage;
    }
    private function getParams():string
    {
        $url = parse_url($_SERVER['REQUEST_URI']);
        $uri = $url['path'] ?? "";
        $params = $url['query'] ?? "";
        if(isset($params) && $params != ""){
            $uri .= "?";
            $params = explode("&",$params);
            foreach($params as $param){
                if(!str_contains($param, "page="))
                $uri .= "{$param}&";
            }
        }
        return $uri;
    }
    public function getHtml(): string
    {
        $back = '';
        $forward = '';
        $start_page = '';
        $end_page = '';
        $pages_left = '';
        $pages_right = '';

        if ($this->currentPage > 1) {
            $back = '<li class="page-item"><a href="' 
                    . $this->getLink($this->currentPage - 1) 
                    . '" class="page-link">&lt;</a></li>';
        }

        if ($this->currentPage < $this->numPages) {
            $forward = "<li class='page-item'><a class='page-link' href='" 
                        . $this->getLink($this->currentPage + 1) 
                        . "'>&gt;</a></li>";
        }

        if ($this->currentPage > $this->midSize + 1) {
            $start_page = "<li class='page-item'><a class='page-link' href='" 
                            . $this->getLink(1) 
                            . "'>&laquo;</a></li>";
        }

        if ($this->currentPage < ($this->numPages - $this->midSize)) {
            $end_page = "<li class='page-item'><a class='page-link' href='" 
                        . $this->getLink($this->numPages) 
                        . "'>&raquo;</a></li>";
        }

        for ($i = $this->midSize; $i > 0; $i--) {
            if ($this->currentPage - $i > 0) {
                $pages_left .= "<li class='page-item'><a class='page-link' href='" 
                                . $this->getLink($this->currentPage - $i) 
                                . "'>" . ($this->currentPage - $i) . "</a></li>";
            }
        }

        for ($i = 1; $i <= $this->midSize; $i++) {
            if ($this->currentPage + $i <= $this->numPages) {
                $pages_right .= "<li class='page-item'><a class='page-link' href='"
                                 . $this->getLink($this->currentPage + $i) 
                                 . "'>" . ($this->currentPage + $i) 
                                 . "</a></li>";
            }
        }
        return '<nav aria-label="Page navigation example">
                <ul class="pagination">'
                 . $start_page . $back . $pages_left 
                 . '<li class="page-item active"><a class="page-link">' 
                 . $this->currentPage . '</a></li>' 
                 . $pages_right . $forward . $end_page 
                 . '</ul></nav>';
    }

    private function getLink(int $pageNumber): string
    {
        if ($pageNumber == 1) {
            return rtrim($this->uri, '?&');
        }
        if (str_contains($this->uri, '&') || str_contains($this->uri, '?')) {
            return "{$this->uri}page={$pageNumber}";
        } else {
            return "{$this->uri}?page={$pageNumber}";
        }
    }

    private function getMidSize(): int
    {
        return $this->numPages <= $this->allPages ? $this->numPages : $this->midSize;
    }

    public function __toString(): string
    {
        return $this->getHtml();
    }

}