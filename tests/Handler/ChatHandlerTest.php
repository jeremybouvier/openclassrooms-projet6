<?php

namespace App\Tests\Handler;

use App\Entity\Chat;
use App\Entity\Trick;
use App\Handler\ChatHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class ChatHandlerTest extends TestCase
{
    /**
     * Test du handle d'un chat
     */
    public function testHandle()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $security = $this->createMock(Security::class);
        $chatHandler = new ChatHandler($entityManager, $security);

        $form = $this->createMock(FormInterface::class);
        $form->method("isSubmitted")->willReturn(true);
        $form->method("isValid")->willReturn(true);
        $form->method("handleRequest")->willReturnSelf();


        $formFactory = $this->createMock(FormFactoryInterface::class);
        $formFactory->method('create')->willReturn($form);

        $chatHandler->setFormFactory($formFactory);
        $request = Request::create("/");

        $this->assertTrue($chatHandler->handle($request, new Chat(), new Trick()));
    }
}
