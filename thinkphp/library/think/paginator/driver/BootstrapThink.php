<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: zhangyajun <448901948@qq.com>
// +----------------------------------------------------------------------

namespace think\paginator\driver;

use think\Paginator;

class BootstrapThink extends Paginator
{

    /**
     * 上一页按钮
     * @param string $text
     * @return string
     */
    protected function getPreviousButton($text = "上一页")
    {

        if ($this->currentPage() <= 1) {
            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->url(
            $this->currentPage() - 1
        );

        return $this->getPageLinkWrapper($url, $text);
    }

    /**
     * 下一页按钮
     * @param string $text
     * @return string
     */
    protected function getNextButton($text = '下一页')
    {
        if (!$this->hasMore) {
            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->url($this->currentPage() + 1);

        return $this->getPageLinkWrapper($url, $text);
    }

    /**
     * 页码按钮
     * @return string
     */
    protected function getLinks()
    {
        if ($this->simple)
            return '';

        $block = [
            'first'  => null,
            'slider' => null,
            'last'   => null
        ];

        $side   = 3;
        $window = $side * 2;

        if ($this->lastPage < $window + 6) {
            $block['first'] = $this->getUrlRange(1, $this->lastPage);
        } elseif ($this->currentPage <= $window) {
            $block['first'] = $this->getUrlRange(1, $window + 1);
            $block['last']  = $this->getUrlRange($this->lastPage, $this->lastPage);
        } elseif ($this->currentPage > ($this->lastPage - $window)) {
            $block['first'] = $this->getUrlRange(1, 1);
            $block['last']  = $this->getUrlRange($this->lastPage - ($window + 2), $this->lastPage);
        } else {
            $block['first']  = $this->getUrlRange(1, 1);
            $block['slider'] = $this->getUrlRange($this->currentPage - $side, $this->currentPage + $side);
            $block['last']   = $this->getUrlRange($this->lastPage, $this->lastPage);
        }

        $html = '';
        if (is_array($block['first'])) {
            $html .= $this->getUrlLinks($block['first']);
        }

        if (is_array($block['slider'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['slider']);
        }

        if (is_array($block['last'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['last']);
        }

        return $html;
    }

    /**
     * 渲染分页html
     * @return mixed
     */
    public function render()
    {
        if ($this->hasPages()) {
            if ($this->simple) {
                return sprintf(
                    '<div id="page" class="page_div pager">%s %s</ul>',
                    $this->getPreviousButton(),
                    $this->getNextButton()
                );
            } else {
                /************跳转页面************/
                $base_url = '';
                $path_url_page_url = $this->url($this->currentPage);
                $pathArr           = explode( '?', $path_url_page_url );
                if( $pathArr ){
                    $paramArr = explode( '&', $pathArr[1] );
                    foreach( $paramArr as $key=>$val ) {
                        if( $val == 'page='.$this->currentPage ) {
                            unset( $paramArr[$key] );
                        }
                    }
                    $base_url = $pathArr[0].'?'.implode( '&', $paramArr );
                }
                /************跳转页面************/
                return sprintf(
                    '<div id="page" class="page_div pagination">%s %s %s<span class=\'totalSize\'> 跳转<input class=\'jump_class jump_page_num\' onkeyup="this.value=this.value.replace(/\D/, \'\');" type=\'text\' value=\'\'>页 </span><a href=\'javascript:void(0);\' onclick=\'jumpPage(this);\' data-href="'.$base_url.'" class=\'jump_btn\' style=\'color: #18a689;border: 1px solid #18a689!important;margin-left:0px;\'>确定</a><span class="totalPages"> 共<span>'.$this->lastPage.'</span>页 </span><span class="totalSize"> 共<span>'.$this->total.'</span>条记录 </span></div>',
                    $this->getPreviousButton(),
                    $this->getLinks(),
                    $this->getNextButton()
                );
            }
        }
    }

    /**
     * 生成一个可点击的按钮
     *
     * @param  string $url
     * @param  int    $page
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page)
    {
        $id = '';
        $page == '上一页' ? $id = 'prePage' : '';
        $page == '下一页' ? $id = 'nextPage' : '';
        return '<a id="'.$id.'" href="' . htmlentities($url) . '">' . $page . '</a>';
    }

    /**
     * 生成一个禁用的按钮
     *
     * @param  string $text
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        $id = '';
        $text == '上一页' ? $id = 'prePage' : '';
        $text == '下一页' ? $id = 'nextPage' : '';
        return '<a id="'.$id.'" class="disabled"><span>' . $text . '</span></a>';
    }

    /**
     * 生成一个激活的按钮
     *
     * @param  string $text
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return '<a class="current"><span>' . $text . '</span></a>';
    }

    /**
     * 生成省略号按钮
     *
     * @return string
     */
    protected function getDots()
    {
        return $this->getDisabledTextWrapper('...');
    }

    /**
     * 批量生成页码按钮.
     *
     * @param  array $urls
     * @return string
     */
    protected function getUrlLinks(array $urls)
    {
        $html = '';

        foreach ($urls as $page => $url) {
            $html .= $this->getPageLinkWrapper($url, $page);
        }

        return $html;
    }

    /**
     * 生成普通页码按钮
     *
     * @param  string $url
     * @param  int    $page
     * @return string
     */
    protected function getPageLinkWrapper($url, $page)
    {
        //dump($page);
        if ($page == $this->currentPage()) {
            return $this->getActivePageWrapper($page);
        }
        //dump($page);

        return $this->getAvailablePageWrapper($url, $page);
    }
}
