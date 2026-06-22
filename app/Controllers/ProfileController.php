<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use InvalidArgumentException;

class ProfileController extends BaseController
{
    public function show(): string
    {
        $user = service('authService')->currentUser();

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('Profile not found.');
        }

        return view('admin/profile', [
            'title' => 'Admin Profile',
            'user' => $user,
        ]);
    }

    public function updatePicture(): RedirectResponse
    {
        $user = service('authService')->currentUser();

        if ($user === null) {
            return redirect()->to(url_to('auth.login'))->with('error', 'Please sign in to continue.');
        }

        $rules = [
            'picture' => 'uploaded[picture]|max_size[picture,2048]|is_image[picture]|mime_in[picture,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(url_to('admin.profile'))->with('error', implode(' ', $this->validator->getErrors()));
        }

        $file = $this->request->getFile('picture');

        if ($file === null || ! $file->isValid()) {
            return redirect()->to(url_to('admin.profile'))->with('error', 'Please choose a valid image file.');
        }

        try {
            $picturePath = service('profileService')->updatePicture((int) $user->getId(), $file);
            session()->set('picture', $picturePath);

            return redirect()->to(url_to('admin.profile'))->with('success', 'Profile picture updated successfully.');
        } catch (InvalidArgumentException $exception) {
            return redirect()->to(url_to('admin.profile'))->with('error', $exception->getMessage());
        }
    }
}
