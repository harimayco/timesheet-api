<?php

namespace App;

use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Fractal\Fractal;

class Accounts
{
    /**
     * Get list of paginated users.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function getUsersWithPagination(Request $request): array
    {
        $users = User::filter($request)->paginate();

        return fractal($users, new UserTransformer())->toArray();
    }

    public function getStaffList(Request $request): array
    {
        $users = User::filter($request)->where([
            ['type', '<>', 'Admin'],
            ['Status', '=', '1']
        ])->orderBy('name', 'asc')->get();

        return fractal($users, new UserTransformer())->toArray();
    }

    /**
     * Get a user by ID.
     *
     * @param  int  $id
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return array
     */
    public function getUserById(int $id): array
    {
        $user = User::findOrFail($id);

        return fractal($user, new UserTransformer())->toArray();
    }

    /**
     * Store a new user.
     *
     * @param  array  $attrs
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return array
     */
    public function storeUser(array $attrs): array
    {
        $user = new User($attrs);

        if (!$user->isValid()) {
            throw new ValidationException($user->validator());
        }

        $user->save();

        event(new UserCreated($user));

        return fractal($user, new UserTransformer())->toArray();
    }

    /**
     * Update a user by ID.
     *
     * @param  int  $id
     * @param  array  $attrs
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return array
     */
    public function updateUserById(int $id, array $attrs): array
    {
        $user = User::findOrFail($id);
        $user->fill($attrs);
        $changes = $user->getDirty();

        if (!$user->isValid()) {
            throw new ValidationException($user->validator());
        }

        $user->save();

        event(new UserUpdated($user, $changes));

        return fractal($user, new UserTransformer())->toArray();
    }

    /**
     * Delete a user by ID.
     *
     * @param  int  $id
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return bool
     */
    public function deleteUserById(int $id): bool
    {
        $user = User::findOrFail($id);

        if (!$user->delete()) {
            return false;
        }

        return true;
    }
}
