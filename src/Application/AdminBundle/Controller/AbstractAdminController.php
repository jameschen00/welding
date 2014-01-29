<?php
namespace Application\AdminBundle\Controller;

use Application\CoreBundle\Manager\AbstractManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    abstract protected function grid($manager);

    /**
     * @return \Symfony\Component\Form\Form
     */
    abstract protected function form();

    /**
     * @param AbstractManager              $manager
     * @param \Symfony\Component\Form\Form $form
     *
     * @return integer
     */
    protected function save($manager, $form)
    {
        $entity = $form->getData();
        $manager->save($entity);

        return $entity->getId();
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
        $cacheId = $this->get('core_form_helper')->generateCacheId(0, $form);
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
        $cacheId = $this->get('core_form_helper')->generateCacheId(0, $form);
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
     * @param Request $request
     *
     * @Route("/save/{id}/", requirements={"id" = "\d+"})
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function saveAction($id, Request $request)
    {
        if (!$request->isMethod('POST')) {
            throw $this->createNotFoundException('This page does not exist');
        }

        $form = $this->form();
        $formHelper = $this->get('core_form_helper');

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

        $form->submit($request);
        if ($form->isValid()) {
            //save
            $id = $this->save($manager, $form);

            //notice
            $formHelper->showSuccessNotice();

            //redirect
            if ($request->get('cmd') == self::CMD_APPLY && $id) {
                $url = $this->createUrl('update', array('id' => $id));
            } else {
                $url = $this->createUrl('index');
            }

            return $this->redirect($url);

        } else {
            //save form data in session
            $this->get('session')->set($formHelper->generateCacheId($id, $form), $request->get($form->getName()));

            //notice
            $formHelper->showErrorNotice($formHelper->handleErrorsAsString($form));

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
     * @param string $name
     *
     * @return \Application\CoreBundle\Manager\AbstractManager
     */
    private function getManagerByName($name)
    {
        return $this->get('core_manager_factory')->get($name);
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
