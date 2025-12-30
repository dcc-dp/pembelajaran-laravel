<?php
namespace App\Services;

use App\Models\Blog;
use App\Repositories\BlogRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class BlogService
{
	/**
     * @var BlogRepository $blogRepository
     */
    protected $blogRepository;

    /**
     * DummyClass constructor.
     *
     * @param BlogRepository $blogRepository
     */
    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Get all blogRepository.
     *
     * @return String
     */
    public function getAll()
    {
        return $this->blogRepository->all();
    }

    /**
     * Get blogRepository by id.
     *
     * @param $id
     * @return String
     */
    public function getById(int $id)
    {
        return $this->blogRepository->getById($id);
    }

    /**
     * Validate blogRepository data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function save(array $data)
    {
        return $this->blogRepository->save($data);
    }

    /**
     * Update blogRepository data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function update(array $data, int $id)
    {
        DB::beginTransaction();
        try {
            $blogRepository = $this->blogRepository->update($data, $id);
            DB::commit();
            return $blogRepository;
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            throw new InvalidArgumentException('Unable to update post data');
        }
    }

    /**
     * Delete blogRepository by id.
     *
     * @param $id
     * @return String
     */
    public function deleteById(int $id)
    {
        DB::beginTransaction();
        try {
            $blogRepository = $this->blogRepository->delete($id);
            DB::commit();
            return $blogRepository;
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            throw new InvalidArgumentException('Unable to delete post data');
        }
    }
}
