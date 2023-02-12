<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    public function __construct(
        private TaskRepository $taskRepository,
        private EntityManagerInterface $entityManager,
    )
    {
    }

    #[Route('/', name: 'app_task', methods: ['GET'])]
    public function showTasks(): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $this->taskRepository->findAll(),
        ]);
    }

    #[Route('/task/edit/{id}', name: 'app_task_edit', methods: ['GET'])]
    public function editEditTask(Task $task): Response
    {
        return $this->render('task/edit.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/task/edit', name: 'app_task_process_edit', methods: ['POST'])]
    public function processEditTask(Request $request): Response
    {
        $task = $this->taskRepository->find($request->request->get('id'));
        $task->setTitle($request->request->get('title'));

        $this->entityManager->flush();

        return $this->redirectToRoute('app_task');
    }

    #[Route('/task/create', name: 'app_task_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $task = new Task();
        $task->setTitle($request->request->get('title'));

        // TODO: Implement on the form the description field
        $task->setDescription('Pending implementation!');
        $task->setIsDone(false);

        $this->taskRepository->save($task);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_task');
    }

    #[Route('/task/delete/{id}', name: 'app_task_delete', methods: ['GET'])]
    public function delete(Task $task): Response
    {
        $this->taskRepository->remove($task);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_task');
    }
}
