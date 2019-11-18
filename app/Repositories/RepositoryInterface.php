<?php


namespace App\Repositories;


interface RepositoryInterface
{
    public function all();

    public function paginate($size);

    public function destroy($id);

    public function findOrFail($id);
}
