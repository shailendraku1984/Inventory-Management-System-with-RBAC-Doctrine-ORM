<?php

namespace App\Controllers;

use App\Interfaces\Service\AuthServiceInterface;
use CodeIgniter\HTTP\RedirectResponse;

class AuthController extends BaseController
{
    private AuthServiceInterface $auth;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ): void {
        parent::initController($request, $response, $logger);

        $this->auth = service('authService');
    }

    public function login(): string|RedirectResponse
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(url_to('admin.profile'));
        }

        return view('auth/login', [
            'title' => 'Admin Login',
        ]);
    }

    public function attemptLogin(): RedirectResponse
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->to(url_to('auth.login'))
                ->withInput()
                ->with('error', implode(' ', $this->validator->getErrors()));
        }

        $result = $this->auth->attempt(
            (string) $this->request->getPost('email'),
            (string) $this->request->getPost('password')
        );

        if (! $result['success'] || $result['user'] === null) {
            return redirect()
                ->to(url_to('auth.login'))
                ->withInput()
                ->with('error', $result['message']);
        }

        session()->regenerate(true);
        session()->set($this->auth->sessionPayload($result['user']));

        return redirect()
            ->to(url_to('admin.profile'))
            ->with('success', $result['message']);
    }

    public function logout(): RedirectResponse
    {
        session()->remove([
            'isLoggedIn',
            'auth_user_id',
            'auth_user_name',
            'auth_user_email',
            'auth_user_role',
        ]);
        session()->regenerate(true);

        return redirect()
            ->to(url_to('auth.login'))
            ->with('success', 'You have been logged out.');
    }
}
