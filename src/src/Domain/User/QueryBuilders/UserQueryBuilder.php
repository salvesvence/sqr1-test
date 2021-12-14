<?php

namespace Src\Domain\User\QueryBuilders;

use Src\Domain\Role\Types\RoleEnum;
use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    /**
     * @return UserQueryBuilder
     */
    public function admins(): UserQueryBuilder
    {
        return $this->role(RoleEnum::admin());
    }

    /**
     * @return UserQueryBuilder
     */
    public function bloggers(): UserQueryBuilder
    {
        return $this->role(RoleEnum::blogger());
    }
}
