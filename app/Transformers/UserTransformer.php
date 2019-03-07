<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\User  $user
     *
     * @return array
     */
    public function transform(User $user): array
    {
        return [
            'id' => $user->id_user,
            'name' => $user->name,
            'email' => $user->username,
            'type' => $user->type,
            'phone' => $user->notelepon,
            'status' => $user->Status,

        ];
    }
}
