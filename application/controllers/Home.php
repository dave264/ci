<?php


class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('home/index');
    }

    public function socket() {
        
        if(($sock = socket_create(AF_INET,SOCK_STREAM,SOL_TCP)) < 0) {
             echo "socket_create() 失败的原因是:".socket_strerror($sock)."\n";
        }
        if(($ret = socket_bind($sock,$ip,$port)) < 0) {
             echo "socket_bind() 失败的原因是:".socket_strerror($ret)."\n";
        }
         
        if(($ret = socket_listen($sock,4)) < 0) {
             echo "socket_listen() 失败的原因是:".socket_strerror($ret)."\n";
        }
         
        $count = 0;
        do {
            if (($msgsock = socket_accept($sock)) < 0) {
                 echo "socket_accept() failed: reason: " . socket_strerror($msgsock) . "\n";
                 break;
             } else {
                 
                //发到客户端
                 $msg ="测试成功！\n";
                 socket_write($msgsock, $msg, strlen($msg));
                
                 echo "测试成功了啊\n";
                 $buf = socket_read($msgsock,8192);
                 
                
                 $talkback = "收到的信息:$buf\n";
                echo $talkback;
                 
                 if(++$count >= 5){
                     break;
                };
                 
             
             }
             //echo $buf;
            socket_close($msgsock);
         
        } while (true);
         
        socket_close($sock);
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
	
	/**
	 * 分享
	 */
	public function share()
	{
		$this->load->view('home/share');
	}
	
	public function youyan()
	{
		$this->load->view('home/youyan');
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