<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Services\BlogService;

class BlogController extends Controller
{
    /**
     * @var BlogService
     */
    protected BlogService $blogService;

    /**
     * DummyModel Constructor
     *
     * @param BlogService $blogService
     *
     */
    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function index(): \Illuminate\Contracts\View\View
    {
        $blogs = $this->blogService->getAll();
        return view('blogs.index', compact('blogs'));
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        return view('blogs.create');
    }

    public function store(BlogRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->blogService->save($request->validated());
        return redirect()->route('blogs.index')->with('success', 'Created successfully');
    }

    public function show(int $id): \Illuminate\Contracts\View\View
    {
        $blog = $this->blogService->getById($id);
        return view('blogs.show', compact('blog'));
    }

    public function edit(int $id): \Illuminate\Contracts\View\View
    {
        $blog = $this->blogService->getById($id);
        return view('blogs.edit', compact('blog'));
    }

    public function update(BlogRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $this->blogService->update($request->validated(), $id);
        return redirect()->route('blogs.index')->with('success', 'Updated successfully');
    }

    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $this->blogService->deleteById($id);
        return redirect()->route('blogs.index')->with('success', 'Deleted successfully');
    }
}
