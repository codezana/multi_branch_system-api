<?php

namespace App\Repositories;

use App\Models\Categories;

class CategoriesRepository
{
    public function all()
    {
      return Categories::all();
    }

    public function find($id)
    {
      return Categories::find($id);
    }

    public function create(array $data)
    {
        return Categories::create($data);
    }

    public function update($id, array $data)
    {
      return Categories::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Categories::destroy($id);
    }
}