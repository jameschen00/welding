<?php
namespace Application\MessageBundle\Controller;

use Application\MessageBundle\Library\Dklab\Realplexor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;





/**
 * Cart controller
 */
class IndexController extends Controller
{
    public function indexAction()
    {
//        for ($i=0; $i<5000; $i++) {
//            $msg = array('user_id' => rand(1000,1000000), 'image_path' => '/path/to/new/pic.png');
//            $this->get('old_sound_rabbit_mq.upload_picture_producer')->publish(serialize($msg));
//        }
        return $this->render('ApplicationMessageBundle:Message:index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statusAction()
    {
        $realplexor = new Realplexor("127.0.0.1", "10010");
        $realplexor->send(array("alpha", "beta"), json_encode(array('text' => 'hello')));

        exit('done');
    }
}
