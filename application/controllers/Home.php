<?php


class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->model('Activity');
        $row = $this->Activity->doFind();
        echo '<pre>';
        var_dump($row);
        echo '</pre>';

        $this->load->view('home/index');
    }

    public function about($keywords)
    {
        $keywords = urldecode($keywords);
        $host = 'http://cililian.me';
        $filepath = '/list/'.$keywords.'/1.html';
        $url = $host.$filepath;

        $html = $this->getHtml($url);
        $li = $html->find('.mlist li');


        foreach($li as $value) {
            $title = $value->find('.T1 a',0)->text();
            $size = $value->find('.BotInfo dt span',0)->text();
            $count = $value->find('.BotInfo dt span',1)->text();
            $time = $value->find('.BotInfo dt span',2)->text();
            $link = $value->find('.dInfo a',0)->href;
        }
        $this->load->view('home/index');
    }


    private function getHtml($url)
    {
        $this->load->helper('Common_helper');
        $this->load->helper('Simple_html_dom_helper');

        $common = new Common();
        $html = new simple_html_dom();
        $content = $common->curl_get($url);
        $html->load($content);
        return $html;

    }
}