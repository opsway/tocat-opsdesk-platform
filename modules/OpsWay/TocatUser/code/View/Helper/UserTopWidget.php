<?php

namespace OpsWay\TocatUser\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use ZfcUser\Entity\UserInterface as User;

class UserTopWidget extends AbstractHelper
{
    /**
     * __invoke
     *
     * @access public
     * @throws \ZfcUser\Exception\DomainException
     * @return String
     */
    public function __invoke()
    {
        $displayName = '';
        if ($user = $this->getView()->zfcUserIdentity()) {
            //$user = $this->getAuthService()->getIdentity();
            if (!$user instanceof User) {
                throw new \ZfcUser\Exception\DomainException(
                    '$user is not an instance of User',
                    500
                );
            }
            $displayName = $user->getDisplayName();
            if (null === $displayName) {
                $displayName = $user->getUsername();
            }
            // User will always have an email, so we do not have to throw error
            if (null === $displayName) {
                $displayName = $user->getEmail();
                $displayName = substr($displayName, 0, strpos($displayName, '@'));
            }
        }
        $vm = new ViewModel([
            'displayName' => $displayName,
        ]);
        $vm->setTemplate('tocatuser/partial/helper/user-top-widget.phtml');
        return $this->getView()->render($vm);
    }
}
