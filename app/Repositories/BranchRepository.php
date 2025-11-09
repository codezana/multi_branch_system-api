<?php

namespace App\Repositories;

use App\Models\Branch;

class BranchRepository
{
      public function all() {
        return Branch::all();
    }

    public function find( $id ) {

        return Branch::find( $id );
    }

    public function create( array $data ) {
        return Branch::create( $data );
    }

    public function update( $id, array $data ) {
        return Branch::where( 'id', $id )->update( $data );
    }

    public function delete( $id ) {
        return Branch::destroy( $id );
    }
}