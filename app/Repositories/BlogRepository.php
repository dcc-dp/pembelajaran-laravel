<?php
namespace App\Repositories;

use App\Models\Blog;

class BlogRepository
{
	 /**
     * @var Blog
     */
    protected Blog $blog;

    /**
     * Blog constructor.
     *
     * @param Blog $blog
     */
    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    /**
     * Get all blog.
     *
     * @return Blog $blog
     */
    public function all()
    {
        return $this->blog->get();
    }

     /**
     * Get blog by id
     *
     * @param $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->blog->find($id);
    }

    /**
     * Save Blog
     *
     * @param $data
     * @return Blog
     */
     public function save(array $data)
    {
        return Blog::create($data);
    }

     /**
     * Update Blog
     *
     * @param $data
     * @return Blog
     */
    public function update(array $data, int $id)
    {
        $blog = $this->blog->find($id);
        $blog->update($data);
        return $blog;
    }

    /**
     * Delete Blog
     *
     * @param $data
     * @return Blog
     */
   	 public function delete(int $id)
    {
        $blog = $this->blog->find($id);
        $blog->delete();
        return $blog;
    }
}
