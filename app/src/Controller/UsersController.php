<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Security;
use Cake\View\JsonView;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->viewBuilder()->setOption('serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Articles', 'Likes'],
        ]);

        $this->set(compact('user'));
        $this->viewBuilder()->setOption('serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->request->allowMethod(['post']);
        $user = $this->Users->newEntity($this->request->getData());
        if ($this->Users->save($user)) {
            $message = 'Created user successfully!';
        } else {
            $message = 'Error when create user.';
        }
        $this->set([
            'message' => $message,
            'user' => $user,
        ]);
        $this->viewBuilder()->setOption('serialize', ['user', 'message']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['patch', 'put']);
        $user = $this->Users->get($id);
        $user = $this->Users->patchEntity($user, $this->request->getData());
        if ($this->Users->save($user)) {
            $message = 'Updated user successfully';
        } else {
            $message = 'Error when update user.';
        }
        $this->set([
            'message' => $message,
            'user' => $user,
        ]);
        $this->viewBuilder()->setOption('serialize', ['user', 'message']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $user = $this->Users->get($id);
        $message = 'Deleted user successfully';
        if (!$this->Users->delete($user)) {
            $message = 'Error when delete user';
        }
        $this->set('message', $message);
        $this->viewBuilder()->setOption('serialize', ['message']);
    }

    /**
     *
     */
    public function login()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $userIdentity = $this->Authentication->getIdentity();

            $user = $userIdentity->getOriginalData();
            $user->token = $this->generateToken();
            $user = $this->Users->save($user);
            $user = $this->Users->get($user->id);

            $this->set(compact('user'));
            $this->viewBuilder()->setOption('serialize', ['user']);
        } else {
            throw new NotFoundException(__('User not found'));
        }
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $userIdentity = $this->Authentication->getIdentity();

            $user = $userIdentity->getOriginalData();
            $user->token = null;
            $user = $this->Users->save($user);

            $message = 'Logout';
            $this->set(compact('message'));
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
    }

    /**
     * @param int $length
     * @return array|string|string[]|null
     */
    private function generateToken(int $length = 36)
    {
        $random = base64_encode(Security::randomBytes($length));
        $cleaned = preg_replace('/[^A-Za-z0-9]/', '', $random);
        return $cleaned;
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @return \Cake\Http\Response|void|null
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login', 'index', 'view']);
    }
}
