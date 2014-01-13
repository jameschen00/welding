<?php
namespace Application\AdminBundle\Controller;

use Application\CoreBundle\Manager\AbstractManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Typical admin CRUD controller
 */
abstract class AbstractAdminController extends Controller
{
    /**
     * @var string
     */
    const CMD_APPLY = 'apply';

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }

    /**
     * @param AbstractManager $manager
     *
     * @return \Widget\Grid\Grid
     */
    abstract public function grid($manager);

    /**
     * @return \Symfony\Component\Form\Form
     */
    abstract public function form();

    /**
     * @param AbstractManager              $manager
     * @param \Symfony\Component\Form\Form $form
     *
     * @return integer
     */
    public function save($manager, $form)
    {
        return $manager->save($form->getData());
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     *
     * @Route("/")
     * @Route("/view/")
     */
    public function indexAction(Request $request)
    {
        $configuration = $this->getConfiguration();
        $manager       = $this->getManagerByName($configuration->getManager());
        $grid          = $this->grid($manager);

        $grid->setBaseUrl($this->createUrl('index'));
        $grid->getStorage()->load();

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(array('success' => true, 'grid' => $grid->render()));
        }

        //crumbs
        $this->createCrumbs();

        //render
        return $this->render(
            $configuration->getTemplateIndex(),
            array(
                'grid'          => $grid,
                'createUrl'     => $this->createUrl('create'),
                'page'          => 'index',
                'configuration' => $configuration
            )
        );
    }

    /**
     * @param integer $id
     *
     * @Route("/update/{id}/", requirements={"id" = "\d+"})
     *
     * @return Response
     */
    public function updateAction($id)
    {
        $configuration = $this->getConfiguration();

        //get data
        $manager = $this->getManagerByName($configuration->getManager());
        $manager->setId($id);
        $entity = $manager->findOne();
        if ($entity == null) {
            $this->createNotFoundException('Entity not found');
        }

        //create form
        $form = $this->form()->setData($entity);

        //errors
        $cacheId = $this->generateCacheId(0, $form);
        if ($this->get('session')->has($cacheId)) {
            $data = $this->get('session')->get($cacheId);
            $this->get('session')->remove($cacheId);

            //assign data to form
            $form->submit($data);
        }

        //crumbs
        $this->createCrumbs('update');

        //render
        return $this->render(
            $configuration->getTemplateUpdate(),
            array(
                'form'          => $form->createView(),
                'saveUrl'       => $this->createUrl('save', array('id' => $id)),
                'backUrl'       => $this->createUrl('index'),
                'page'          => 'update',
                'configuration' => $configuration,
                'entity'        => $entity
            )
        );
    }

    /**
     * @Route("/create/")
     *
     * @return Response
     */
    public function createAction()
    {
        $configuration = $this->getConfiguration();

        //create form
        $form = $this->form();

        //errors
        $cacheId = $this->generateCacheId(0, $form);
        if ($this->get('session')->has($cacheId)) {
            $data = $this->get('session')->get($cacheId);
            $this->get('session')->remove($cacheId);

            //assign data to form
            $form->submit($data);
        }

        //crumbs
        $this->createCrumbs('create');

        //render
        return $this->render(
            $configuration->getTemplateCreate(),
            array(
                'form'          => $form->createView(),
                'saveUrl'       => $this->createUrl('save', array('id' => 0)),
                'backUrl'       => $this->createUrl('index'),
                'page'          => 'create',
                'configuration' => $configuration
            )
        );
    }

    /**
     * @param integer $id
     *
     * @Route("/save/{id}/", requirements={"id" = "\d+"})
     *
     * @return Response
     */
    public function saveAction($id)
    {
        if (!$this->getRequest()->isMethod('POST')) {
            throw $this->createNotFoundException('This page does not exist');
        }

        $form = $this->form();

        //get data
        $manager = $this->getManagerByName($this->getConfiguration()->getManager());
        if ($id) {
            $manager->setId($id);
            $entity = $manager->findOne();

            if ($entity == null) {
                $this->createNotFoundException('Entity not found');
            }

            $form->setData($entity);
        }

        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            //save
            $id = $this->save($manager, $form);

            //notice
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('Your changes were saved!'));

            //redirect
            if ($this->getRequest()->get('cmd') == self::CMD_APPLY && $id) {
                $url = $this->createUrl('update', array('id' => $id));
            } else {
                $url = $this->createUrl('index');
            }

            return $this->redirect($url);

        } else {
            //save form data in session
            $this->get('session')->set($this->generateCacheId($id, $form), $this->get('request')->request->get($form->getName()));

            //notice
            $this->flashMassege($form);

            //redirect
            if ($id) {
                $url = $this->createUrl('update', array('id' => $id));
            } else {
                $url = $this->createUrl('create');
            }

            return $this->redirect($url);
        }
    }

    /**
     * @param integer $id
     *
     * @Route("/delete/{id}/", requirements={"id" = "\d+"})
     *
     * @return Response
     */
    public function deleteAction($id)
    {
        $this->getManagerByName($this->getConfiguration()->getManager())->delete($id);
    }

    /**
     * Send notice message with validation errors
     *
     * @param \Symfony\Component\Form\Form $form $form
     */
    protected function flashMassege($form)
    {
        $errors = $this->getAllFormErrorMessages($form);
        foreach ($errors as $key => $error) {
            if ($key == '_message') {
                $message = $error;
            } else {
                $message = $key . ': ' . $error['_message'];
            }

            if ($message) {
                $this->get('session')->getFlashBag()->add('notice', $message);
            }
        }
//        // get a ConstraintViolationList
//        $errors = $this->get('validator')->validate( $entity );
//
//        $result = '';
//
//        // iterate on it
//        foreach( $errors as $error )
//        {
//            printAll($error->getPropertyPath());
//            printAll($error->getMessage());
//        }
    }

    /**
     * Genereate cache id for session storage
     *
     * @param integer $id
     * @param object  $form
     *
     * @return string
     */
    protected function generateCacheId($id, $form)
    {
        $cacheId = md5($id . get_class($form));

        return $cacheId;
    }

    /**
     * @param string $name
     *
     * @return \Application\CoreBundle\Manager\AbstractManager
     */
    private function getManagerByName($name)
    {
        return $this->get('core_manager_factory')->get($name);
    }

    /**
     * Get error messages from form
     *
     * @param Form $form
     *
     * @return Array
     */
    protected function getAllFormErrorMessages(Form $form)
    {
        $retval = array();
        foreach ($form->getErrors() as $error) {
            if ($error->getMessagePluralization() !== null) {
                $retval['_message'] = $this->get('translator')->transChoice(
                    $error->getMessage(),
                    $error->getMessagePluralization(),
                    $error->getMessageParameters(),
                    'validators'
                );
            } else {
                $retval['_message'] = $this->get('translator')->trans($error->getMessage(), array(), 'validators');
            }
        }
        foreach ($form->all() as $name => $child) {
            $errors = $this->getAllFormErrorMessages($child);
            if (!empty($errors)) {
                $retval[$name] = $errors;
            }
        }

        return $retval;
    }

    /**
     * @param string $action
     */
    private function createCrumbs($action = '')
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem($this->getConfiguration()->getPageTitle(), $this->createUrl('index'));

        if ($action) {
            $breadcrumbs->addItem($action);
        }
    }

    /**
     * Create url
     *
     * @param string $action
     * @param array  $params
     *
     * @return mixed
     */
    protected function createUrl($action, $params = array())
    {
        $arr = explode('_', $this->getRequest()->attributes->get('_route'));
        array_pop($arr);
        $arr[] = $action;

        return $this->get('router')->generate(join('_', $arr), $params, true);
    }
}
