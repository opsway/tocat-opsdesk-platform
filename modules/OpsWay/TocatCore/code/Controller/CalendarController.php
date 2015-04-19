<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace OpsWay\TocatCore\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use OpsWay\TocatUser\Entity\Calendar;
use OpsWay\TocatUser\Entity\CalendarEvent;
use OpsWay\TocatUser\Entity\User;
use Symfony\Component\Config\Definition\Exception\Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\Common\Collections\Criteria;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
use Zend\Mail;

class CalendarController extends AbstractActionController
{
    public function indexAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $user = $this->zfcUserAuthentication()->getIdentity();
        if ($user) {
            $userRepository = $em->getRepository(User::class);
            $user = $userRepository->find($user->getId());
        }
        return new ViewModel(['listCalendar' => $this->getListCalendar(), 'user' => $user]);
    }

    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');
        $list = $this->getListCalendar();
        foreach ($list as $calendar) {
            if ($calendar->getId() == $id) {
                break;
            }
        }
        if (!$calendar) {
            return $this->forward('calendar', ['action' => 'notFound']);
        }
        return new ViewModel(['listCalendar' => $list, 'calendar' => $calendar]);
    }

    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            $calendar = new Calendar();
            $this->changeCalendar($calendar, $this->params()->fromPost());
        }

        return new ViewModel(['listCalendar' => $this->getListCalendar()]);
    }

    public function eventsAction()
    {
        $id = $this->params()->fromRoute('id');
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $calendar = $em->getRepository(Calendar::class)->find($id);
        if ($calendar && $this->getRequest()->isPost()) {
            try {
                $data = Json::decode($this->getRequest()->getContent(), Json::TYPE_ARRAY);
                if (!isset($data['action'])) {
                    return new ApiProblemResponse(new ApiProblem(404, 'Not Found Action'));
                }
                switch ($data['action']) {
                    case 'save':
                        $calendarEvent = new CalendarEvent();
                        $calendarEvent->setStartAt(new \DateTime($data['data']['startAt']))
                            ->setEndAt(new \DateTime($data['data']['endAt']))
                            ->setEmail($data['data']['email'])
                            ->setName($data['data']['name'])
                            ->setNotes($data['data']['notes'])
                            ->setCalendar($calendar);
                        $em->persist($calendarEvent);
                        $em->flush();
                        try {
                            $date = new \DateTime($data['data']['startAt']);
                            $mail = new Mail\Message();
                            $mail->setBody(
                                $calendar->getUser()->getDisplayName()
                                . ' will be ready start conversation at ' . $date->format("m/d/Y H:i")
                            );
                            $mail->setFrom('calendar@opsway.support', 'Calendar OpsDesk');
                            $mail->addTo($data['data']['email'], $data['data']['name']);
                            $mail->setSubject('You created meet with ' . $calendar->getUser()->getDisplayName());
                            $mail->addReplyTo($calendar->getUser()->getEmail());
                            $transport = new Mail\Transport\Sendmail();
                            $transport->send($mail);

                            $mail = new Mail\Message();
                            $mail->setBody(
                                $data['data']['name'] . ' will be ready start conversation at '
                                . $date->format("m/d/Y H:i")
                            );
                            $mail->setFrom('calendar@opsway.support', 'Calendar OpsDesk');
                            $mail->addTo($calendar->getUser()->getEmail(), $data['data']['name']);
                            $mail->setSubject('New booking with ' . $data['data']['name']);
                            $mail->addReplyTo($data['data']['email']);
                            $transport = new Mail\Transport\Sendmail();
                            $transport->send($mail);
                        } catch (Exception $e) {
                        }
                        break;
                    case 'list':
                        $hydrator = new DoctrineObject($em, true);
                        $expr = Criteria::expr();
                        $criteria = Criteria::create();
                        $criteria->where(
                            $expr->andX(
                                $expr->gte('startAt', new \DateTime($data['startAt'])),
                                $expr->lte('endAt', new \DateTime($data['endAt']))
                            )
                        );
                        return new JsonModel(array_map(function ($event) use ($hydrator) {
                            return $hydrator->extract($event);
                        }, $calendar->getEventsCollection()->matching($criteria)->getValues()));
                        break;

                    default:
                        return new ApiProblemResponse(new ApiProblem(404, 'Not Found Action'));
                }
            } catch (Exception $e) {
                return new ApiProblemResponse(new ApiProblem(503, $e->getMessage()));
            }
        }

        return new JsonModel([]);
    }

    public function editAction()
    {
        $calendar = $this->getListCalendar(true)->find($this->params()->fromRoute('id'));

        if ($calendar->getId()) {
            if ($this->getRequest()->isPost()) {
                $this->changeCalendar($calendar, $this->params()->fromPost());
            }
        } else {
            return $this->forward('calendar', ['action' => 'notFound']);
        }

        return new ViewModel(['listCalendar' => $this->getListCalendar(), 'calendar' => $calendar]);
    }

    protected function changeCalendar(Calendar $calendar, $data)
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        try {
            $validator = new \Zend\Validator\Regex('/^\d{1,2}:\d{2} [PpAa][Mm]$/ui');
            if (!$validator->isValid($data['begin_day']) || !$validator->isValid($data['begin_day'])) {
                throw new \Exception('Time value is not valid!');
            }
            $user = $this->zfcUserAuthentication()->getIdentity();
            $userRepository = $em->getRepository(User::class);
            $user = $userRepository->find($user->getId());
            $calendar->setBeginDay(new \DateTime($data['begin_day']))
                ->setEndDay(new \DateTime($data['end_day']))
                ->setUser($user);
            $em->persist($calendar);
            $em->persist($user);
            $em->flush();
            $this->flashMessenger()->addSuccessMessage('Calendar was saved.');
            return $this->redirect()->toRoute('calendar', ['action' => 'edit', 'id' => $calendar->getId()]);
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }
        return $this->redirect()->toRoute('calendar', ['action' => 'create']);
    }

    protected function getListCalendar($getSource = false)
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $calendarRepo = $em->getRepository(Calendar::class);
        if ($getSource) {
            return $calendarRepo;
        }
        return $calendarRepo->findAll();
    }
}
