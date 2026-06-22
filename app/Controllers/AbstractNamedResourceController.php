<?php

namespace App\Controllers;

use App\Interfaces\Service\CrudServiceInterface;
use CodeIgniter\HTTP\RedirectResponse;
use InvalidArgumentException;

abstract class AbstractNamedResourceController extends BaseController
{
    abstract protected function serviceName(): string;

    abstract protected function viewPath(): string;

    abstract protected function routePrefix(): string;

    abstract protected function title(): string;

    protected function hasAddress(): bool
    {
        return false;
    }

    public function index(): string
    {
        return view($this->viewPath() . '/index', [
            'title' => $this->title(),
            'items' => $this->service()->list(),
            'routePrefix' => $this->routePrefix(),
        ]);
    }

    public function create(): string
    {
        return view($this->viewPath() . '/form', [
            'title' => 'Add ' . $this->title(),
            'item' => null,
            'hasAddress' => $this->hasAddress(),
            'routePrefix' => $this->routePrefix(),
        ]);
    }

    public function store(): RedirectResponse
    {
        return $this->persist();
    }

    public function edit(int $id): string|RedirectResponse
    {
        $item = $this->service()->find($id);

        if ($item === null) {
            return redirect()->to(url_to($this->routePrefix() . '.index'))->with('error', 'Record not found.');
        }

        return view($this->viewPath() . '/form', [
            'title' => 'Edit ' . $this->title(),
            'item' => $item,
            'hasAddress' => $this->hasAddress(),
            'routePrefix' => $this->routePrefix(),
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        return $this->persist($id);
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            $this->service()->delete($id);

            return redirect()->to(url_to($this->routePrefix() . '.index'))->with('success', 'Record deleted.');
        } catch (InvalidArgumentException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    protected function persist(?int $id = null): RedirectResponse
    {
        $rules = ['name' => 'required|min_length[2]|max_length[150]'];
        if ($this->hasAddress()) {
            $rules['address'] = 'required|min_length[3]|max_length[255]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        try {
            $this->service()->save($this->request->getPost(), $id);

            return redirect()->to(url_to($this->routePrefix() . '.index'))->with('success', 'Record saved.');
        } catch (InvalidArgumentException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }
    }

    protected function service(): CrudServiceInterface
    {
        return service($this->serviceName());
    }
}
