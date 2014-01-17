<?php

namespace Application\CoreBundle\Form\Helper;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class FormHelper
 */
class FormHelper
{
    /**
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    private $translator;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    private $session;

    /**
     * @param TranslatorInterface $translator
     * @param SessionInterface    $session
     */
    public function __construct(TranslatorInterface $translator, SessionInterface $session)
    {
        $this->translator = $translator;
        $this->session    = $session;
    }

    /**
     * Genereate cache id for session storage
     *
     * @param integer       $id
     * @param FormInterface $form
     *
     * @return string
     */
    public function generateCacheId($id, FormInterface $form)
    {
        $cacheId = md5($id . get_class($form));

        return $cacheId;
    }

    /**
     * Get error messages from form
     *
     * @param FormInterface $form
     *
     * @return Array
     */
    protected function handleErrors(FormInterface $form)
    {
        $retval = array();
        foreach ($form->getErrors() as $error) {
            if ($error->getMessagePluralization() !== null) {
                $retval['_message'] = $this->translator->transChoice(
                    $error->getMessage(),
                    $error->getMessagePluralization(),
                    $error->getMessageParameters(),
                    'validators'
                );
            } else {
                $retval['_message'] = $this->translator->trans($error->getMessage(), array(), 'validators');
            }
        }
        foreach ($form->all() as $name => $child) {
            $errors = $this->handleErrors($child);
            if (!empty($errors)) {
                $retval[$name] = $errors;
            }
        }

        return $retval;
    }


    /**
     * @param FormInterface $form
     *
     * @return array
     */
    public function handleErrorsAsString(FormInterface $form)
    {
        $errors = $this->handleErrors($form);

        $messages = array();
        foreach ($errors as $key => $error) {
            if ($key == '_message') {
                $messages[] = $error;
            } else {
                $messages[] = $key . ': ' . @$error['_message'];
            }
        }

        return $messages;
    }

    /**
     * @param array|string $message
     */
    public function showErrorNotice($message)
    {
        if (is_array($message)) {
            foreach ($message as $error) {
                $this->session->getFlashBag()->add('notice', $error);
            }
        } else {
            $this->session->getFlashBag()->add('notice', $message);
        }
    }

    /**
     * @param array|string|null $message
     */
    public function showSuccessNotice($message = null)
    {
        if (is_array($message)) {
            foreach ($message as $text) {
                $this->session->getFlashBag()->add('success', $text);
            }
        } else {
            $this->session->getFlashBag()->add('success', $message ? $message : $this->translator->trans('Your changes were saved!'));
        }
    }
}
